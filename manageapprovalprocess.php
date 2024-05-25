<?php 
include('hrsession.php');
if (!session_id())
{
	session_start(); 
}

include ('dbconnect.php');

//Retrieve data from form and session
$fbid = $_POST['fbid'];
$stat = $_POST['stat'];


$sql = "UPDATE o_book 
		SET x_status='$stat'
		WHERE x_bookid='$fbid'";

//var_dump($sql);

mysqli_query($con,$sql);
mysqli_close($con);

header('Location: manage.php');
?>