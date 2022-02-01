#!/usr/bin/php
<?php

// (c) 2022 Bill Simon. Permissions given according to MIT license.

$msSpeechUrl = 'https://eastus.stt.speech.microsoft.com/speech/recognition/conversation/cognitiveservices/v1?language=en-US';
$apiKey = 'YOUR-KEY-HERE';

$maildata = file_get_contents("php://stdin");
$msg = preg_split("/\r\n|\n|\r/", $maildata);
$att = '';
for($i = 0; $i < count($msg); $i++) {
        if (preg_match('/Content-Disposition: attachment/', $msg[$i])) {
                $i++; // skip to next line
                while (! preg_match('/----/', $msg[$i])) {
                        $att .= $msg[$i] . "\n";
                        $i++;
                }
        }
}

if ($att) {
        $opts = array('http' =>
                array(
                        'method' => 'POST',
                        'header' => array(
                                "Ocp-Apim-Subscription-Key: $apiKey",
                                'Content-Type: audio/wav'
                                ),
                        'content' => base64_decode($att)
                )
        );
        $context = stream_context_create($opts);
        $result = json_decode(file_get_contents($msSpeechUrl, false, $context));
}

if (! empty($result->{"DisplayText"})) {
        $maildata = str_replace('(TRANSCRIPTION)', $result->{"DisplayText"}, $maildata);
} else {
        $maildata = str_replace('(TRANSCRIPTION)', 'No transcription availabile.', $maildata);
}

$mailproc = popen('/usr/sbin/sendmail -t', 'w');
fwrite($mailproc, $maildata);
pclose($mailproc);

exit;
?>
