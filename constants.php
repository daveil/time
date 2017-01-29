<?php
require __DIR__ . '/vendor/autoload.php';
if(!isset($_ENV['TMLY_APP_ID']) && !isset($_ENV['TMLY_SECRET']))
	$_ENV = json_decode(file_get_contents('env.json'),true);
define('TIMELY_API','https://api.timelyapp.com/1.0');
define('TMLY_APP_ID', $_ENV['TMLY_APP_ID']);
define('TMLY_SECRET', $_ENV['TMLY_SECRET']);
define('TMLY_TOKEN',$_ENV['TMLY_TOKEN']);
define('BASE_URL',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTP_HOST']=='localhost'?'/time/':'/'));
?>