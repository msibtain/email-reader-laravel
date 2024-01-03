<?php

namespace App\Http\Controllers;
use App\Models\Email;

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
        $txtSince = date("Ymd");
        $mailsIds = $mailbox->searchMailbox('SINCE "'.$txtSince.'"');
        
        foreach($mailsIds as $num) 
        {
            $markAsSeen = false;
            $mail = $mailbox->getMail($num, $markAsSeen);
            if ($mail->textHtml)
                $body = $mail->textHtml;
            else
                $body = $mail->textPlain;

            $Email = new Email();
            $Email->email_id = $mail->toString . "_" . $num;
            $Email->from_name = $mail->fromName;
            $Email->from_email = $mail->fromAddress;
            $Email->from_host = $mail->fromHost;
            $Email->subject = $mail->subject;
            $Email->body = $body;
            $Email->links = "";
            $Email->save();

            
            echo "Email data saved: " . $mail->toString . "_" . $num;
            echo "<hr>";
            
        
        }

    }
}
