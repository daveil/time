<?php
require 'constants.php';
$url = TIMELY_API.'/oauth/token';
$params = array(
	'response_type'=>'code',
	'redirect_uri'=>BASE_URL.'token.php',
	'client_id'=>TMLY_APP_ID
);
$p =array();
foreach($params as $k=>$v){
	array_push($p,$k.'='.$v);
}
$url .='?'.implode('&',$p);
header("Location: $url");
?>