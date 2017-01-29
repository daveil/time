<?php
require 'constants.php';

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