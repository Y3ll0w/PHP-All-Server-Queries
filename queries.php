<?php
error_reporting(0);
$ip = '0.0.0.0';
$queryport = 27017;

//A2S_INFO
$socket = @fsockopen("udp://".$ip, $queryport , $errno, $errstr, 1);
stream_set_timeout($socket, 2);	
fwrite($socket, "\xFF\xFF\xFF\xFF\x54Source Engine Query\x00");
$response = fread($socket, 4096);
fclose($socket);
$packet = explode("\x00", substr($response, 6), 5);
print "<pre>";
print_r($packet);
print "</pre>";

//A2S_SERVERQUERY_GETCHALLENGE
$socket2 = @fsockopen("udp://".$ip, $queryport , $errno, $errstr, 1);
stream_set_timeout($socket2, 2);	
fwrite($socket2, "\xFF\xFF\xFF\xFF\x56\x00\x00\x00\x00");
$response2 = fread($socket2, 4096);
fclose($socket2);
$challenge = explode("\x41", substr($response2, 5));
$challenge = $challenge[0];

echo bin2hex($challenge);

//A2S_RULES
$socket3 = @fsockopen("udp://".$ip, $queryport , $errno, $errstr, 1);
stream_set_timeout($socket3, 2);	
fwrite($socket3, "\xFF\xFF\xFF\xFF\x56" . $challenge);
$response3 = fread($socket3, 4096);
fclose($socket3);

$packet3 = explode("\x00", substr($response3, 6));
print "<pre>";
print_r($packet3);
print "</pre>";

//A2S_PLAYER
$socket4 = @fsockopen("udp://".$ip, $queryport , $errno, $errstr, 1);
stream_set_timeout($socket4, 2);	
fwrite($socket4, "\xFF\xFF\xFF\xFF\x55" . $challenge);
$response4 = fread($socket4, 4096);
fclose($socket4);

$packet4 = explode("\x00", substr($response4, 6));
print "<pre>";
print_r($packet4);
print "</pre>";
?>
