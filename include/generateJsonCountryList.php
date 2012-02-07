<?php
include('dbconfig.php');
 /*
 $query="SELECT * FROM tbl_activity";
 $result=mysql_query($query);
 $data=array();
	
 while($row=mysql_fetch_array($result))
 {
	$row=array('user_id'=>$row['userid'],'type'=>$row['type']);
	array_push($data,$row);
 }
 $response['activity'] = $data;

*/


$query="SELECT * FROM country";
$result=mysql_query($query);
$data1=array();

 while($row=mysql_fetch_array($result))
 {
	$row=array('name'=>$row['Name'],'code'=>$row['Code']);
	array_push($data1,$row);
 }
$response['country'] = $data1;

echo  json_encode($response);


?>