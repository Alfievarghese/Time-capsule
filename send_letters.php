<?php
$from_email = "yourdomain@yourwebsite.com"; // CHANGE THIS!

if (!file_exists('messages.json')) {
    die('No messages found.');
}

$all_entries = json_decode(file_get_contents('messages.json'), true);
$today = date('Y-m-d');

$still_pending = [];

foreach ($all_entries as $entry) {
    if ($entry['delivery_date'] == $today) {
        $to = $entry['email'];
        $subject = "A Special Letter from Your Past Self";

        $message_html = "
        <html>
        <head>
          <style>
            body { font-family: 'Poppins', sans-serif; background: #f4f4f4; padding: 20px; }
            .letter { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);}
            .title { font-size: 24px; color: #6C63FF; margin-bottom: 20px; }
            .content { font-size: 18px; color: #333; white-space: pre-wrap; }
          </style>
        </head>
        <body>
          <div class='letter'>
            <div class='title'>A Message From Your Past Self</div>
            <div class='content'>" . nl2br($entry['message']) . "</div>
          </div>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Digital Time Capsule <" . $from_email . ">\r\n";

        mail($to, $subject, $message_html, $headers);
    } else {
        $still_pending[] = $entry;
    }
}

file_put_contents('messages.json', json_encode($still_pending, JSON_PRETTY_PRINT));
?>