<?php 

require_once('twitter-api-php/TwitterAPIExchange.php');

/*

$settings = array(
    'oauth_access_token' => "******",
    'oauth_access_token_secret' => "*",
    'consumer_key' => "*",
    'consumer_secret' => "*"
);

*/
require_once('../../jdl_settings.php');


$url = 'https://api.twitter.com/1.1/search/tweets.json';

//$getfield = "q=" . $_GET['q'] . "&lang=es";
$getfield = http_build_query(
		array(
		    'q' => $_GET['q'],
		    'lang' => 'es',
            'count' => '100',
		)
	);
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$data =  $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$object_data = json_decode($data);

$clean_daw = array();

foreach($object_data->statuses as $key => $o){
    $text = $o->text;
    $img = $o->user->profile_image_url;
    
    $content = file_get_contents($img);
    file_put_contents("./imgs/" . basename($img), $content);
    
    $name = $o->user->name; 
    $date = $o->created_at;
    
    $clean_daw[] = array(
            'text' => $text,
            'img'  => $img,
            'name' => $name,
            'date' => $date
        );    
}

header('Content-type: application/json');

$clean_daw = json_encode($clean_daw);

$file = fopen("json_dump.txt", "w") or die("Unable to open file!");
fwrite($file, $clean_daw);
fclose($file);


print_r($clean_daw);
?>