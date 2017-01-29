<?php
require 'constants.php';
header('Content-Type: application/json');
if(isset($_POST)){
	if(!isset($_POST['TIME_TOKEN'])){
		echo 'TIME_TOKEN required'; exit;
	}else if($_POST['TIME_TOKEN']==$_ENV['TIME_TOKEN']){
		switch($_GET['action']){
			case 'get_projects':
				$accounts = $TMLY_API->get('accounts');
				$project_list = array();
				$project_ids = array();
				foreach($accounts as $account){
					$projects =  $TMLY_API->get($account['id'].'/projects');
					foreach($projects as $project){
						array_push($project_list,$project);
						$project_ids[$project['name']] = array('id'=>$project['id'],'account_id'=>$account['id']);
					}
				}
				echo json_encode($project_ids);
			break;
			case 'add_event':
				$project_id = $_POST['project_id'];
				$account_id = $_POST['account_id'];
				$note = $_POST['note'];
				$day = date('Y-m-d',strtotime($_POST['date']));
				$duration = (int)$_POST['duration'];
				$hours = floor($duration / 3600);
				$minutes = floor(($duration / 60) % 60);
				$endpoint = $account_id.'/projects/'.$project_id.'/events';
				$event =array('event'=>array('day'=>$day,'minutes'=>$minutes,'hours'=>$hours,'note'=>$note));
				$event_resp  =  $TMLY_API->post($endpoint,$event);
				echo json_encode($event_resp);
			break;
		}
	}
}
exit;
 
?>