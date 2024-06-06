<?php 
include('hrssession.php');

// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

include('dbconnect.php');

// Retrieve ID from URL
if(isset($_GET['id'])) {
    // $bid = $_GET['id'];
    // $cancelReason = $_GET['reason'];
    $bid = mysqli_real_escape_string($con, $_GET['id']);
    $cancelReason = mysqli_real_escape_string($con, $_GET['reason']); // Escape input to prevent SQL injection
    
    
    // Perform the delete query
    //$sql = "DELETE FROM o_book WHERE x_bookid='$bid'";
    $sql = "UPDATE o_book SET x_status = 3, x_cancelreason = '$cancelReason' WHERE x_bookid='$bid'";
    if (mysqli_query($con, $sql)) {
        // Check user class and redirect accordingly
        $allowadmin = array(0);
        $allowcustomer = array(1);

        if (in_array($_SESSION['x_userclass'], $allowadmin)) {
            header("Location: manageall.php");
        } elseif (in_array($_SESSION['x_userclass'], $allowcustomer)) {
            header('Location: customermanage.php');
        } else {
            // Redirect to a default page or an error page if the user class is neither admin nor customer
            header('Location: index.php');
        }
        exit;
    } else {
        // Handle query failure (optional)
        echo "Error cancelling record: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // Redirect to index if no ID is provided
    header('Location: index.php');
    exit;
}
?>
