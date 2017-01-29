<?php
require __DIR__ . '/vendor/autoload.php';
if(!isset($_ENV['TMLY_APP_ID']) && !isset($_ENV['TMLY_SECRET']))
	$_ENV = json_decode(file_get_contents('env.json'),true);
define('TIMELY_API','https://api.timelyapp.com/1.0');
define('TMLY_APP_ID', $_ENV['TMLY_APP_ID']);
define('TMLY_SECRET',$_ENV['TMLY_SECRET']);
define('BASE_URL',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$curl = new Curl\Curl();
$curl->get(TIMELY_API.'/oauth/authorize',
		array(
			'response_type'=>'code',
			'redirect_uri'=>BASE_URL.'timely.php',
			'client_id'=>TMLY_APP_ID,
		));
 
 if ($curl->error) {
	echo 'Error';
    echo $curl->error_code;
}
else {
    echo $curl->response;
}

var_dump($curl->request_headers);
var_dump($curl->response_headers);
?>