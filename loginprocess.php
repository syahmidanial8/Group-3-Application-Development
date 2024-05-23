<?php
// Session
session_start();

// Connect to DB (external file)
include "dbconnect.php";

// Retrieve data from login form (login.php)
$fid = mysqli_real_escape_string($con, $_POST["fid"]);
$fpwd = $_POST["fpwd"]; // No need to escape since we'll hash it

// Get user detail based on login credentials
$sql = "SELECT * FROM o_user WHERE x_userid = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $fid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($fpwd, $row["x_pwd"])) {
        // Password is correct, start a session
		$_SESSION['xuserid'] = $fid;

        session_regenerate_id(true); // Regenerate session ID to prevent session fixation
		$_SESSION['x_username'] = $row["x_name"];
        $_SESSION['x_userid'] = session_id();
		$_SESSION['userislogged'] = 1; // 1 - TRUE, 0 - FALSE
        $_SESSION['x_user'] = $row["x_userid"];
        // Redirect based on user type
        if ($row['x_userclass'] == 0) {
			$_SESSION['x_userclass'] = $row['x_userclass']; // 1 - TRUE, 0 - FALSE
            header('Location: manage.php?stype=logged');
        } else {
			$_SESSION['x_userclass'] = $row['x_userclass']; // 1 - TRUE, 0 - FALSE
            header('Location: customer.php?stype=logged');
        }
        exit;
    } else {
        // Password incorrect
        // echo 'User not found or password incorrect';
        // echo '<br><a href="login.php">Back to Login Page</a>';
        header('Location: login.php?stype=invalid-pass');
        exit;
    }
} else {
    // User not found
    // echo 'User not found';
    // echo '<br><a href="login.php">Back to Login Page</a>';
    header('Location: login.php?stype=user-notfound');

    exit;
}
