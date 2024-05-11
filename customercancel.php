<?php 
include('hrssession.php');
if (!session_id())
{
	session_start(); 
}
include ('dbconnect.php');

//Retrieve ID from URL
if(isset($_GET['id']))
{
	$bid = $_GET['id'];
}

$sql = "DELETE FROM o_book WHERE x_bookid='$bid'";
mysqli_query($con,$sql);
mysqli_close($con);


header('Location: customermanage.php');


?>