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
		// Get replyToken
		$replyToken = $event['replyToken'];
		
		//&&  $event['message']['text'] == 'hi'
		// Build message to reply back
		if ($event['type'] == 'message' && $event['message']['type'] == 'text' && $event['message']['text'] == 'hi')
		{
			// Reply with Text
			/*
			$messages = [
				'type' => 'text',
				'text' => 'สวัสดีค่ะ'
			];*/
			
			$messages = array(
				array(
					"type" => "text",
					"text" => "สวัสดีค่ะ"
				)
				
			);
			//$messages = json_decode($ret);
			
		}
		else if($event['type'] == 'message' && $event['message']['type'] == 'sticker')
		{
			// Reply with Sticker
			$messages = [
				'type' => 'sticker',
				'packageId' => '2',
				'stickerId' => '145'
			];
		}
		else
		{
			$ret = '
			{
			  "type": "template",
			  "altText": "this is a carousel template",
			  "template": {
				  "type": "carousel",
				  "columns": [
					  {
						"thumbnailImageUrl" : "https://www.advanced-media.co.jp/common/images/corporate/top_message/president.jpg",
						"title": "Advance Media",
						"text": "Communicate with machines as part of our everyday lives",
						"actions": [
							{
								"type": "uri",
								"label": "Mobile",
								"uri": "https://www.advanced-media.co.jp/english/solution/mobile"
							},
							{
								"type": "uri",
								"label": "Conference",
								"uri": "https://www.advanced-media.co.jp/english/solution/conferenceproceedings"
							}
						]
					  },
					  {
						"thumbnailImageUrl" : "https://www.advanced-media.co.jp/common/images/advm_contents_amivoice_images_strong1.png",
						"title": "AmiVoice Thai",
						"text": "Consulting services for all commercial enterprises",
						"actions": [
							{
								"type": "uri",
								"label": "Company Profile",
								"uri": "http://www.amivoicethai.com"
							},
							{
								"type": "uri",
								"label": "Logistic",
								"uri": "https://www.advanced-media.co.jp/english/solution/logistics"
							}
						]
					  }
				  ]
			  }
			}';
			$messages = json_decode($ret);
		}

		// Make a POST Request to Messaging API to reply to sender
		$url = 'https://api.line.me/v2/bot/message/reply';
		$data = [
			'replyToken' => $replyToken,
			'messages' => [$messages],
		];
		$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
		
		echo $post. "\r\n";

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		$curl_info = curl_getinfo($ch);
		curl_close($ch);
		
		print_r($curl_info);

		echo $result . "\r\n";
		
	}
}
echo "OK";
