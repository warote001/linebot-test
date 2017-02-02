
<?php
$access_token = 'bBBopbyU12SrtYUjHBtOkJs0WRVnY/xs5nD6DnULKevoT6NHiuN+mQg7BS7EYMUsVOzMm+xCENitBtKnb300JmaMhR2dl3SzseTWAgY0Cwst5QqgyFqXGkpBLFuyE5PsKBjuJq8UvzQO31jCYgQcCwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			if($text == "อีกาดำ"){
				$sendtext = "คนที่เหนือกว่าเขาทุกอย่าง คือ ผม อีกาดำ";
			}else if($text == "zombie"){
				$sendtext = "แล้ววันนี้ เขาจะถูกฝั่งอยู่ในความทรงจำ ";
			}else{
				$sendtext = "การแข่งขันยอมมีแพ้ชนะเสมอ https://www.youtube.com/watch?v=dwlJbb0o8V8";
			}
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $sendtext,
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
?>
