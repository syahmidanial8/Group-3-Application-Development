<?php
//Session
session_start();


//Connect to DB (external file)
include ("dbconnect.php");

//Retrieve data from login form (login.php)
//$fid = $_POST['fid'];
//$fpwd = $_POST['fpwd'];
$fid = mysqli_real_escape_string($con, $_POST["fid"]);  
$fpwd = mysqli_real_escape_string($con, $_POST["fpwd"]); 

//Get user detail based on login credentials
$sql = "SELECT * FROM o_user WHERE x_userid = '$fid'";
//$sql = "SELECT * FROM o_user WHERE x_userid = '$fid' AND x_pwd = '$fpwd'";

//var_dump($sql); //Enable to check input by user

//Execute SQL statements
$result = mysqli_query($con,$sql);

$sql = "SELECT * FROM o_user WHERE x_userid = '$fid'";
$result = mysqli_query($con, $sql);


/* Visitor module disabled
if ($fid === "visitor") {
	// Set the appropriate session variables for a visitor
	$_SESSION['x_userid'] = session_id();
	$_SESSION['xuserid'] = $fid;
	
	// Redirect to the appropriate page for visitors
	header('Location: visitor.php');
	exit;
}
*/
		
if(mysqli_num_rows($result) > 0) //($count == 1)  
       {  
            while($row = mysqli_fetch_array($result))  
            {  
                 if(password_verify($fpwd, $row["x_pwd"]))  
                 {  
                        //return true;  
             			$_SESSION['x_userid'] = session_id();
						$_SESSION['xuserid'] = $fid; 
                        	
                    	if ($row['x_userclass'] == 0) //Guest Manager
						{
							header ('Location: guestmanager.php');
						}
						else //Customer 
						{
							header ('Location: customer.php');
						}  
                 }  
                 else  
                 {  
                      //return false;  
                      	//include 'headermain.php';
						echo 'User not found OR password incorrect';
						echo '<br><a href="login.php">Back to Login Page</a>';
						//include 'footer.php';
                 }  
            }  
       }  
       else  
       {  
            echo '<script>alert("Wrong User Details")</script>';
			echo "<script> location.href='login.php'; </script>";
			exit;			
       } 
?>