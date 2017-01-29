<?php
require 'constants.php';
header('Content-Type: application/json');
$projects = $TIME_API->post('timely.php?action=get_projects');
$project_id = $projects['ZAMA']['id'];
$account_id = $projects['ZAMA']['account_id'];
$params = array('account_id'=>$account_id,'project_id'=>$project_id,'note'=>'Sample','date'=>'2017-01-29T11:36:00+00:00','duration'=>12000);
echo json_encode($TIME_API->post('timely.php?action=add_event',$params));
?>