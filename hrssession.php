<?php 
if (!session_id())
{
	session_start(); 
}

if(isset($_SESSION['x_userid']) != session_id())
{
	header('Location: login.php');
}

?>