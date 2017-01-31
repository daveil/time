<?php
require 'constants.php';
if(!isset($_GET['secret'])) return;
if($_GET['secret']!=$_ENV['IFTT_SECRET']) return;
//Toggl Projects
$tggl_prj = array();
$project = array();
$toggl = new MorningTrain\TogglApi\TogglApi(TGGLE_API_TOKEN);
$lastTimer = $toggl->getRunningTimeEntry();
$lastTime = "";
$lastHour = " -1 hour";
if(isset($_GET['last'])) $lastHour=' -'.$_GET['last'];
if($lastTimer->id){
	$toggl->stopTimeEntry($lastTimer->id);
	$project[$pid] = $toggl->getProject($pid)->name;
	$name = $project[$pid];
	$tggl_prj[$name] = array();
	$timer = array('desc'=>$lastTimer->description,'date'=>$lastTimer->at,'duration'=>$lastTimer->duration);
	array_push($tggl_prj[$name],$timer);
	
	$newTimer =  array(
					'description'=>$lastTimer->description,
					'pid'=>$lastTimer->pid,
					'start'=>date(DateTime::ATOM,strtotime("+0 minutes")),
					'duration'=>$lastTimer->duration,
					"created_with"=>"time.daveadev.com",
				);
	$lastTimer = $toggl->createTimeEntry($newTimer);
	$lastTime = $lastTimer->start;
}
$start = date(DateTime::ATOM,strtotime($lastHour));
$end = date(DateTime::ATOM,strtotime($lastTime." -10 seconds"));
$entries = $toggl->getTimeEntriesInRange($start, $end);



foreach($entries as $entry){
	$pid = $entry->pid;
	$dte = $entry->start;
	$dsc = $entry->description;
	$dur = $entry->duration;
	if(!isset($project[$pid]))
		$project[$pid] = $toggl->getProject($pid)->name;
	$name = $project[$pid];
	if(!isset($tggl_prj[$name]))
		$tggl_prj[$name] = array();
	$timer = array('desc'=>$dsc,'date'=>$dte,'duration'=>$dur);
	array_push($tggl_prj[$name],$timer);
}

//Timely Projects
date_default_timezone_set('Asia/Manila');
$tmly_prj = $TIME_API->post('timely.php?action=get_projects');
$tmly_events = array();
foreach($tggl_prj as $prj=>$evts){
	foreach($evts as $evt){
		if(isset($tmly_prj[$prj])){
		$project_id = $tmly_prj[$prj]['id'];
		$account_id = $tmly_prj[$prj]['account_id'];
		$params = array(
						'account_id'=>$account_id,
						'project_id'=>$project_id,
						'note'=>$evt['desc'],
						'date'=>date(DateTime::ATOM,strtotime($evt['date'])),
						'duration'=>$evt['duration']
					);
		array_push($tmly_events,$TIME_API->post('timely.php?action=add_event',$params));
		}
	}

}
header('Content-Type: application/json');
echo json_encode($tmly_events);
?>