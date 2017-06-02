<?php
$access_token = 'oHUxbtqthxrYl1eiQN/fBJyLZqNVw4RfDuYozEhkcDtPo2FCOkj3uHmYRM+ElE28jOX7a/LZhSQIyKA0jAveIA+jWGe84M75gLFx4Y23nBtVnM9aPXN/whBPZaZHxnYR9kK0/1Eettf5ZlN+BGNdaQdB04t89/1O/w1cDnyilFU=';

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

			// Build message to reply back
			/*
			// Reply with Text
			$messages = [
				'type' => 'text',
				'text' => $text
			];*/

			// Reply with Sticker
			$messages = [
				'type' => 'sticker',
				'packageId' => '2',
				'stickerId' => '145'
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$a3 = '			{
				"type" => "tempate",
				"altText" => "Carousel template",
				"template" => {
					"type" => "carousel",
					"columns" => [
						{
							"text" => "Description 1",
							"actions" => [
								{
									"type" => "uri",
									"label" => "Mobile",
									"uri" => "https://www.advanced-media.co.jp/english/solution/mobile"
								},
								{
									"type" => "uri",
									"label" => "Conference Proceeding",
									"uri" => "https://www.advanced-media.co.jp/english/solution/conferenceproceedings"
								}
							]
						},
						{
							"text" => "Description 2",
							"actions" => [
								{
									"type" => "uri",
									"label" => "Mobile",
									"uri" => "https://www.advanced-media.co.jp/english/solution/mobile"
								},
								{
									"type" => "uri",
									"label" => "Conference Proceeding",
									"uri" => "https://www.advanced-media.co.jp/english/solution/conferenceproceedings"
								}
							]
						}
					]
				}						
			}';
			//$messages = json_decode($a3);
			$data = [
				'replyToken' => $replyToken,
				'messages' => $messages,
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
