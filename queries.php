<?php
//Server
$ip = '0.0.0.0';
$queryport = 27015;

//Socket
$socket = @fsockopen("udp://".$ip, $queryport , $errno, $errstr, 1);
stream_set_timeout($socket, 2);	

//A2S_INFO
fwrite($socket, "\xFF\xFF\xFF\xFF\x54Source Engine Query\x00");
$response = fread($socket, 4096);
$packet = explode("\x00", substr($response, 6), 5);
print "<pre>";
print_r($packet);
print "</pre>";

//A2S_SERVERQUERY_GETCHALLENGE	
fwrite($socket, "\xFF\xFF\xFF\xFF\x56\x00\x00\x00\x00");
$response = fread($socket, 4096);
$challenge = explode("\x41", substr($response, 5));
$challenge = $challenge[0];

echo bin2hex($challenge);

//A2S_RULES
fwrite($socket, "\xFF\xFF\xFF\xFF\x56" . $challenge);
$response = fread($socket, 4096);

$packet = explode("\x00", substr($response, 6));
print "<pre>";
print_r($packet);
print "</pre>";

//A2S_PLAYER
fwrite($socket, "\xFF\xFF\xFF\xFF\x55" . $challenge);
$response = fread($socket, 4096);
fclose($socket);

$packet = explode("\x00", substr($response, 6));
print "<pre>";
print_r($packet);
print "</pre>";
?>
