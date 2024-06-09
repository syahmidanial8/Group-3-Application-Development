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

// $sql = "UPDATE o_book 
// 		SET x_status='$stat', 
// 		x_approvalreason = '$management_note'
// 		WHERE x_bookid='$fbid'";

$sql = "UPDATE o_book 
        SET x_status = '$stat', 
            x_approvalreason = CASE
                WHEN ('$stat' = 1 and '$management_note' = '' and (x_approvalreason is null or x_approvalreason = '') and (select x_status from o_book where x_bookid = '$fbid') = 0)
					THEN 'Approved by Manager'
                WHEN ('$stat' = 2 and '$management_note' = '' and (x_approvalreason is null or x_approvalreason = '') and (select x_status from o_book where x_bookid = '$fbid') = 0)
					THEN 'Rejected by Manager'
				-- WHEN ('$stat' = 3 and (x_approvalreason is null or x_approvalreason = '') and (select x_status from o_book where x_bookid = '$fbid') = 0)
				-- 	THEN 'Cancelled by Manager'
                ELSE '$management_note'
            END
        WHERE x_bookid = '$fbid'";

//var_dump($sql);

mysqli_query($con,$sql);
mysqli_close($con);

header('Location: manage.php');
?>