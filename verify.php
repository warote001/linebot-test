<?php
$access_token = 'bBBopbyU12SrtYUjHBtOkJs0WRVnY/xs5nD6DnULKevoT6NHiuN+mQg7BS7EYMUsVOzMm+xCENitBtKnb300JmaMhR2dl3SzseTWAgY0Cwst5QqgyFqXGkpBLFuyE5PsKBjuJq8UvzQO31jCYgQcCwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
