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
            '{imap.eiliasolutions.com:993/ssl/novalidate-cert/imap}', 
            'hello@eiliasolutions.com', 
            'Bw7d57944', 
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

            if ($mailData)
            {
                $Email = new Email();
                $Email->email_id            = $mailData['email_id'];
                $Email->from_name           = $mailData['from_name'];
                $Email->from_email          = $mailData['from_email'];
                $Email->from_host           = $mailData['from_host'];
                $Email->subject             = $mailData['subject'];
                $Email->body                = $mailData['body'];
                $Email->links               = $mailData['links'];
                $Email->save();

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

        if (count($return)) return serialize($return);

        return "";
    }
}
