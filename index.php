<?php
require __DIR__ . '/vendor/autoload.php';
if(!isset($_ENV['TMLY_APP_ID']) && !isset($_ENV['TMLY_SECRET']))
	$_ENV = json_decode(file_get_contents('env.json'),true);
define('TIMELY_API','https://api.timelyapp.com/1.0');
define('TMLY_APP_ID', $_ENV['TMLY_APP_ID']);
define('TMLY_SECRET', $_ENV['TMLY_SECRET']);
define('TMLY_TOKEN',$_ENV['TMLY_TOKEN']);
define('BASE_URL',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$curl = new Curl\Curl();
$curl->get(TIMELY_API.'/oauth/token',
		array(
			'response_type'=>'code',
			'redirect_uri'=>BASE_URL.'timely.php',
			'code'=>TMLY_TOKEN,
			'client_id'=>TMLY_APP_ID,
			'client_secret'=>TMLY_SECRET,
			'grant_type'=>'authorization_code',
		));
 
 if ($curl->error) {
	echo 'Error';
    echo $curl->error_code;
}
else {
    echo $curl->response;
}

?>