<?php 
include('hrssession.php');
if (!session_id())
{
	session_start(); 
}

include ('dbconnect.php');

//Retrieve data from form and session
$fbid = $_POST['fbid'];
$froom = $_POST['froom'];
$checkindate = $_POST['checkindate'];
$checkoutdate = $_POST['checkoutdate'];
$guestnum = $_POST['guestnum'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$comment = mysqli_real_escape_string($con, $_POST['comment']);
//$fid = $_SESSION['xuserid'];


//Calculate total rent
$sqlp = "SELECT x_price FROM o_room WHERE x_roomid='$froom'";
$resultp = mysqli_query($con,$sqlp);
$rowp = mysqli_fetch_array($resultp);

$start = date('Y-m-d H:i:s', strtotime($checkindate));
$end = date('Y-m-d H:i:s', strtotime($checkoutdate));
$daydiff = abs(strtotime($start)-strtotime($end));
$daynum = $daydiff/(60*60*24);
$totalprice = $daynum*($rowp['x_price']);

$sql = "UPDATE o_book 
		SET x_room='$froom', 
			x_datein='$checkindate', 
			x_dateout='$checkoutdate', 
			x_totalfee='$totalprice',
			x_status='0',
			x_guestnum='$guestnum',
			x_emailaddr='$email',
			x_telnum='$tel',
			x_comment='$comment'
		WHERE x_bookid='$fbid'";

//var_dump($sql);

mysqli_query($con,$sql);
mysqli_close($con);

header('Location: customermanage.php');
?>