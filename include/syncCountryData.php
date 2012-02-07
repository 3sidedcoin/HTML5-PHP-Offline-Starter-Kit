<?php
include('dbconfig.php');
$country=array();


if( get_magic_quotes_gpc() )
{
    $jsonString = stripslashes( $_POST['data'] );
	$country = json_decode( $jsonString,true );
}
else
	$country = json_decode( $_POST['data'],true );


for($i=0;$i<count($country);$i++)
{
	$query="INSERT INTO country (name,code) values ('".$country[$i]['name']."','".$country[$i][code]."')";	
	if(!mysql_query($query))
		echo mysql_error();	
}

$query="SELECT * FROM country order by id desc";
$result=mysql_query($query);
$data=array();

 while($row=mysql_fetch_array($result))
 {
	$row=array('name'=>$row['Name'],'code'=>$row['Code']);
	array_push($data,$row);
 }
$response['country'] = $data;

echo  json_encode($response);
?>