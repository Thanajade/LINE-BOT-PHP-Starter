<?php
date_default_timezone_set('Asia/Bangkok');
$access_token = '5xB8I03dwTqRr7bAVZxYaU4FE2C+f9yzpTen4z+B/Q28nL+5Mvio/fsOzJeVmIq0eAeRCsOuw/gxsJdcyMn5+/lPgkpd+VnPWz3YLHP4DSDZiLpaYR6GP9YU/K68+Cf/N5Hr/AfbFGGYpiJ6JOM1ewdB04t89/1O/w1cDnyilFU=';
$groupId = 'Ca272127b007bb6677319b550dccc2057';

try{
	// Get request/response message from firebase
	$url = 'https://friendlychat-7162a.firebaseio.com/images/aGirl.json';
	$content = file_get_contents($url);
	$json = json_decode($content, true);
	$imageList = array();
	$count = 0;
	foreach($json as $item){
		//array_push($imageList,$item['downloadURLs']);
		$imageList[$counter] = $item['downloadURLs'];
		$counter++;
	}
}catch(Exception $e){
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo 'image size: '+ $imageList.size();
$randomIndex = echo(rand(0,$imageList.size() - 1));
$imgUrl = $imageList[$randomIndex];

try{
	//RESPONSE
	$messages = [
		'type' => 'image',
		'originalContentUrl' => $imgUrl,
		'previewImageUrl' => $imgUrl
	];

	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/push';
	$data = [
		'to' => $groupId,
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
}catch(Exception $e){
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "OK";
