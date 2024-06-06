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
$management_note = mysqli_real_escape_string($con, $_POST['management_note']);

$sql = "UPDATE o_book 
		SET x_status='$stat', 
		x_approvalreason = '$management_note'
		WHERE x_bookid='$fbid'";

//var_dump($sql);

mysqli_query($con,$sql);
mysqli_close($con);

header('Location: manage.php');
?>