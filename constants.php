<?php
require __DIR__ . '/vendor/autoload.php';
class TimeAPI{
	protected $curl;
	public function __construct(){
		if(!isset($_ENV['TMLY_APP_ID']) && !isset($_ENV['TMLY_SECRET']))
			$_ENV = json_decode(file_get_contents('env.json'),true);
		if(!defined('BASE_URL'))   define('BASE_URL',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTP_HOST']=='localhost'?'/time/':'/'));
		if(!defined('CACERT_PEM')) define('CACERT_PEM',dirname(__FILE__).'\cacert.pem');
		if(!defined('TIME_TOKEN')) define('TIME_TOKEN', $_ENV['TIME_TOKEN']);
		$this->curl = new Curl\Curl();
		$this->curl->setOpt(CURLOPT_CAINFO,CACERT_PEM);
	}
	public function get($endpoint,$params=array()){
		$params['TIME_TOKEN'] = TIME_TOKEN;
		$this->curl->get(BASE_URL.$endpoint,$params);
		return  json_decode($this->curl->response,true);
	}
	public function post($endpoint,$params=array()){
		$params['TIME_TOKEN'] = TIME_TOKEN;
		$this->curl->post(BASE_URL.$endpoint,$params);
		return  json_decode($this->curl->response,true);
	}
}
class TimelyAPI extends TimeAPI{
	
	public function __construct(){
		parent::__construct();
		define('TIMELY_API','https://api.timelyapp.com/1.0/');
		define('TMLY_APP_ID', $_ENV['TMLY_APP_ID']);
		define('TMLY_SECRET', $_ENV['TMLY_SECRET']);
		define('TMLY_TOKEN',$_ENV['TMLY_TOKEN']);
		define('TMLY_ACCESS_TOKEN',$_ENV['TMLY_ACCESS_TOKEN']);
		define('TMLY_REFRESH_TOKEN',$_ENV['TMLY_REFRESH_TOKEN']);
	}
	public function get($endpoint,$params=array()){
		$params['access_token'] = TMLY_ACCESS_TOKEN;
		$this->curl->get(TIMELY_API.$endpoint,$params);
		echo $this->curl->error_code;
		echo TIMELY_API.$endpoint;
		print_r($params);
		echo $this->curl->response;
		return  json_decode($this->curl->response,true);
	}
	public function post($endpoint,$params=array()){
		$params['access_token'] = TMLY_ACCESS_TOKEN;
		$this->curl->post(TIMELY_API.$endpoint,$params);
		return  json_decode($this->curl->response,true);
	}
};
$TIME_API =  new TimeAPI();
$TMLY_API =  new TimelyAPI();
?>