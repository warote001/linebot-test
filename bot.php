
<?php
function replytext($text){
	if($text == "อีกาดำ"){
		$sendtext = "คนที่เหนือกว่าเขาทุกอย่างคือ ผม อีกาดำ";
	}else if(strtoupper($text) == "ZOMBIE"){
		$sendtext = "และวันนี้เขาจะฝุกฝังในความทรงจำ https://www.youtube.com/watch?v=B6h5iJJtevo";
	}else if($text == "ความเชื่อ"){
		$sendtext = "ที่ผ่านมา หมูป่าชนะมาได้ก็เป็นเพียงแค่โชคช่วย https://www.youtube.com/watch?v=aKYdF61sO2c";
	}else if(strtoupper($text) == "JOHN"){
		$sendtext = "นี่เพื่อนผม JOHN ";
	}else if($text == "อีกาดำ ถอดหน้ากากครับ"){
		$sendtext = "ลาก่อย";
	}else{
		$sendtext = "001";
	}
	return $sendtext;
}
function replyprocess($access_token,$data){
	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/reply';
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
$access_token = '';
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
			// Get replyToken
			$replyToken = $event['replyToken'];
			$sendtext = replytext($text);

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $sendtext
			];
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			replyprocess($access_token,$data);
			
			if(strtoupper($text) == "JOHN"){
				// Build message to reply back
				$image = [
					'type' => 'image',
					'originalContentUrl': "https://github.com/warote001/linebot-test/blob/master/imagebottest/chucknoland.jpg",
   					'previewImageUrl': "https://github.com/warote001/linebot-test/blob/master/imagebottest/chucknoland.jpg"
				];
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$image],
				];
				replyprocess($access_token,$data);
				
			}
			
		}	
	}
}
echo "OK";
?>
