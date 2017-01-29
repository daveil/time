<?php
require 'constants.php';
if(!isset($_GET['code'])){
	$url = TIMELY_API.'/oauth/authorize';
	$params = array(
		'response_type'=>'code',
		'redirect_uri'=>BASE_URL.'authorize.php',
		'client_id'=>TMLY_APP_ID
	);
	$p =array();
	foreach($params as $k=>$v){
		array_push($p,$k.'='.$v);
	}
	$url .='?'.implode('&',$p);
	echo '<a href="'.$url.'"> Authorize</a>';
	header("Location: $url");
}else{
?>
<form action="<?php echo TIMELY_API.'/oauth/token';?>" method="POST">
	<input type="hidden" name="redirect_uri" value="<?php echo BASE_URL.'authorize.php';?>"/>
	<input type="hidden" name="code" value="<?php echo $_GET['code'];?>"/>
	<input type="hidden" name="client_id" value="<?php echo TMLY_APP_ID;?>"/>
	<input type="hidden" name="client_secret" value="<?php echo TMLY_SECRET;?>"/>
	<input type="hidden" name="grant_type" value="<?php echo 'authorization_code';?>"/>
	<button type="submit">SUBMIT</button>
</form>
<?php
}
?>