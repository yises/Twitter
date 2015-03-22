<?php

ini_set('display_errors', 2);
require_once('config/conf.php');
require_once('library/TwitterAPIExchange.php');
require_once('library/database.php');

$db = new Database($dbUser,$dbPass,$dbTable,$dbHost);

if(isset($_GET['hashtag']) && $_GET['hashtag']!=''){
	$hashtag = $_GET['hashtag'];
	
	// Your specific requirements
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$requestMethod = 'GET';
	$getfield = '?q=#'.$hashtag.'&result_type=recent';

	// Perform the request
	$twitter = new TwitterAPIExchange($settings);
	$response= $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();

	$responseArray = json_decode($response,true);

	$body = '<ul>';
	foreach ($responseArray["statuses"] as $index => $result) {
		$body.='<li>';
		$body.= $db->insertData($result,$hashtag);
		$body.= '</li>';
	}

	$body.= '</ul>';
}else{
	$body.= '<p>Tienes que indicar un hashtag</p>';
}

echo $body;

?>