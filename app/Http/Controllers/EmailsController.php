<?php

namespace App\Http\Controllers;
use App\Models\Email;
use App\Models\BlacklistLinks;

use Illuminate\Http\Request;

use PhpImap;


class EmailsController extends Controller
{
    function read()
    {
        $mailbox = new PhpImap\Mailbox(
            '{'.env('INBOX_MAIL_HOST').':'.env('INBOX_MAIL_PORT').'/ssl/novalidate-cert/imap}', 
            env('INBOX_MAIL_EMAIL'), 
            env('INBOX_MAIL_PASSWORD'), 
            storage_path('/email_logs'),
            'US-ASCII' // force charset different from UTF-8
        );
        //$txtSince = date("Ymd");
        $txtSince = "20240102";
        $mailsIds = $mailbox->searchMailbox('SINCE "'.$txtSince.'"');
        
        foreach($mailsIds as $num) 
        {
            $markAsSeen = false;
            $mail = $mailbox->getMail($num, $markAsSeen);

            $mailData = $this->process_email($mail, $num);

            if ($mailData && $mailData['links'])
            {
                foreach ($mailData['links'] as $link)
                {
                    $Email = new Email();
                    $Email->email_id            = $mailData['email_id'];
                    $Email->from_name           = $mailData['from_name'];
                    $Email->from_email          = $mailData['from_email'];
                    $Email->from_host           = $mailData['from_host'];
                    $Email->subject             = $mailData['subject'];
                    $Email->body                = $mailData['body'];
                    $Email->links               = $link;
                    $Email->save();
                }

                echo "Email data saved: " .$mailData['email_id'];
                echo "<hr>";


            }
            else
            {
                echo "Email data is blacklist<br>";
            }
            
        
        }

    }

    function process_email($mail, $num)
    {
        
        if ($this->isBlacklist( $mail->subject, "Subject" )) return false;
        if ($this->isBlacklist( $mail->fromName, "From Name" )) return false;
        if ($this->isBlacklist( $mail->fromAddress, "From Email" )) return false;
        if ($this->isBlacklist( $mail->fromHost, "From Host" )) return false;
        
        $mailData = [];

        if ($mail->textHtml)
        {
            $body = $mail->textHtml;
        }
        else
        {
            $body = $mail->textPlain;
        }

        # Get links from the email body;
        $links = $this->filterBlacklistLinks( $body );

        $mailData['email_id']       = $mail->toString . "_" . $num;
        $mailData['from_name']      = $mail->fromName;
        $mailData['from_email']     = $mail->fromAddress;
        $mailData['from_host']      = $mail->fromHost;
        $mailData['subject']        = $mail->subject;
        $mailData['body']           = $body;
        $mailData['links']          = $links;
        
        return $mailData;
    }

    function isBlacklist($value, $column)
    {
        $BlacklistRules = BlacklistLinks::where("column", $column)->get();

        if ($BlacklistRules)
        {
            foreach ($BlacklistRules as $objRule)
            {
                if ($objRule->operator === "=" && $value === $objRule->value)
                {
                    return true;
                }

                if ($objRule->operator === "contains" && str_contains(strtolower($value), strtolower($objRule->value)))
                {
                    return true;
                }
            }
        }
        else
        {
            return false;
        }
        
    }

    function filterBlacklistLinks($body)
    {
        $return = [];

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $body, $match);
        foreach ($match[0] as $link)
        {
            if (!$this->isBlacklist($link, "Link"))
            {
                $return[] = $link;
            }
        }

        if (count($return)) return $return;

        return "";
    }

    function list()
    {
        return view('links');
    }

    function get_links_list(Request $request)
    {
        // Page Length
        $pageNumber = ( $request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // get data from products table
        $query = \DB::table('emails')->select('*');

        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search){
            $query->orWhere('from_name', 'like', "%".$search."%");
            $query->orWhere('from_email', 'like', "%".$search."%");
            $query->orWhere('links', 'like', "%".$search."%");
        });

        $orderByName = 'created_at';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'links';
                break;
            case '1':
                $orderByName = 'from_name';
                break;
            case '2':
                $orderByName = 'from_email';
                break;
            case '3':
                $orderByName = 'created_at';
                break;
        
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $users = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $users], 200);

    }

    function link_detail($id)
    {
        $email = Email::find($id);
        return view('detail', compact('email'));
    }
}
