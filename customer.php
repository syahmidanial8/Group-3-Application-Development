<?php
include 'hrssession.php';
if (!session_id()) {
    session_start();
}
include 'dbconnect.php';
include 'functions.php'; // Include the file where the getroleid function is defined

// Check if the user is logged in
if (!isset($_SESSION['userislogged']) || $_SESSION['userislogged'] != 1) {
    header("Location: index.php?");
    exit;
}
// Check if the necessary session variables are set
if (!isset($_SESSION['x_userid']) || empty($_SESSION['x_userid'])) {
    header("Location: index.php");
    exit;
}
//securing page based on roles | 1 - customer
$alloweduserclass = array(1);
if (!in_array($_SESSION['x_userclass'], $alloweduserclass)) {
    header("Location: index.php");
}

$fid = $_SESSION['xuserid'];

//new
$sqlb = "SELECT x_name FROM o_user WHERE x_userid = ?";
$stmt = mysqli_prepare($con, $sqlb);
mysqli_stmt_bind_param($stmt, "s", $fid); // Bind the user ID parameter to the prepared statement, s - represent string only
mysqli_stmt_execute($stmt);
$resultb = mysqli_stmt_get_result($stmt);
$rowb = mysqli_fetch_array($resultb);
mysqli_stmt_close($stmt);

?>
<!doctype html>
<html lang="en">
   <head>
      <title>Hotel Reservation System</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/animate.css">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
      <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/magnific-popup.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
      <link rel="stylesheet" href="css/toastr.css" type="text/css" >
      <!-- Theme Style -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
   </head>
   <body>
      <header role="banner">
         <nav class="navbar navbar-expand-md navbar-dark bg-light">
            <div class="container">
               <a class="navbar-brand" href="home.php">Hotel Sunshine</a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
                  <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
                     <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link " href="customer.php">Room Reservation</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="customermanage.php">My Reservation</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="home.php#featuredrooms">Rooms</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="mailto:support@hotelsunshine.com">Contact</a>
                     </li>
                     <!--
                        <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $fid; ?></a>
                        </li>
                        -->
                     <li class="nav-item cta">
                        <a class="nav-link" href="logout.php"><span>Logout</span></a>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
      </header>
      <!-- END header -->
      <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
         <div class="container">
            <div class="row align-items-center site-hero-inner justify-content-center">
               <div class="col-md-12 text-center">
                  <div class="mb-5 pt-5 element-animate">
                     <h1 style= "color:white" >Welcome, <?php echo $_SESSION['x_username']; ?></h1>
                     <p>Make a reservation and secure your room now</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- END section -->
      <section class="site-section">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h2 class="mb-5">Reservation Form</h2>
                  <form method="POST" action="payment.php" >
                     <div class="row">
                        <div class="col-sm-6 form-group">
                           <label for="chkin">Check In Date</label>
                           <div style="position: relative;">
                              <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span>
                              <input type='date' class="form-control" id='chkin' name='checkindate' required onchange="updateAndValidateDates()"  required onchange="setMinCheckoutDate()" min="<?php echo date('Y-m-d'); ?>" />
                              <!-- <input type='date' class="form-control" id='chkin' name='checkindate' required onchange="updateAndValidateDates()"  required onchange="setMinCheckoutDate()"  /> -->
                           </div>
                        </div>
                        <div class="col-sm-6 form-group">
                           <label for="chkout">Check Out Date</label>
                           <div style="position: relative;">
                              <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span>
                              <input type='date' class="form-control" id='chkout' name='checkoutdate' required onchange="updateRoomOptions()" />
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="sel1">Room</label>
                            <select class='form-control' id='sel1' name='froom'>
                                <!-- default dropdown value -->
                                <option value="">Please input Check In & Out date first</option> 
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                           <label for="room">Guests</label>
                           <select name="guestnum" id="room" class="form-control">
                              <option value="1">1 Guest</option>
                              <option value="2">2 Guests</option>
                              <option value="3">3 Guests</option>
                              <option value="4">4 Guests</option>
                              <option value="5">5+ Guests</option>
                           </select>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <label for="tel">Telephone</label>
                           <input type="tel" id="tel" class="form-control" placeholder="Format : [3]-[7 or 8] digit, eg : 012-3456789" pattern="[0-9]{3}-[0-9]{7}|[0-9]{3}-[0-9]{8}" name="tel" required>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <label for="email">Email</label>
                           <input type="email" id="email" class="form-control" placeholder="Enter your email address" name="email" required>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <label for="comment">Write a Note</label>
                           <textarea id="message" class="form-control " cols="30" rows="3" placeholder="Enter if you have any special instructions" name="comment"></textarea>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3 form-group">
                                 <input type="reset" value="Clear Information" class="btn btn-default" onclick="resetDropdown()">

                        </div>
                        <div class="col-md-3 form-group">
                           <input type="submit" value="Reserve Now" class="btn btn-primary" onClick="return rsvConfirmation();">
                        </div>
                     </div>
                  </form>
               </div>
               <script type="text/javascript">
                  function rsvConfirmation()
                  {
                    var x = confirm("Are you sure you want to place reservation?");
                    if (x == true)
                    {
                      return true;
                    }
                    else
                    {
                      return false;
                    }
                  }
               </script>
            </div>
         </div>
      </section>
      <!-- END section -->
      <script type="text/javascript" src="js/sweetalert.js" language="javascript"></script>
      <?php include 'footer.php';?>
      <?php
      if (isset($_GET["stype"]) && $_GET["stype"] == 'logged') {
         echo '
                     <script>
                           // Use SweetAlert
                           Swal.fire({
                              icon: "success",
                              title: "Welcome Back!",
                              text: "You Have Successfully Accessed Your Account.",
                           });
                     </script>
                  ';
      }
      ?>
      <script>
         function updateAndValidateDates() {
             updateRoomOptions(); // Call the function to update room options
             setMinCheckoutDate(); // Call the function to set minimum checkout date
         }
      </script>
      <script>
         function setMinCheckoutDate() {
             var checkinDateString = document.getElementById("chkin").value;
             var checkinDate = new Date(checkinDateString); // Get the selected check-in date

             var checkoutDateString = document.getElementById("chkout").value;
             var checkoutDate = new Date(checkoutDateString); // Get the selected check-in date
             var today = new Date(); // Get the current date

             // Convert today's date to ISO format
             var todayISO = today.toISOString().split('T')[0];

             // Check if the selected check-in date is less than today's date
            //  if (checkinDate < today) {
            //      // If the selected check-in date is less than today's date, set it to today's date
            //      document.getElementById("chkin").value = todayISO;
            //      // Alert the user to select a new date for check-in
            //      // Use SweetAlert
            //      Swal.fire({
            //          icon: "warning",
            //          title: "Warning!",
            //          text: "Check In Date must be same day or later",
            //      });
            //  }
             
             if(checkinDate > checkoutDate) 
             {
               document.getElementById("chkin").value = todayISO;
                Swal.fire({
                     icon: "warning",
                     title: "Warning!",
                     text: "Ops, Check in date must not greater than Check out date",
                 });
             }

             // Set the minimum check-out date to the selected check-in date
             document.getElementById("chkout").min = checkinDateString;
         }
      </script>
<script>
    // Function to update room options based on selected dates
    function updateRoomOptions() {
        var checkinDate = document.getElementById("chkin").value;
        var checkoutDate = document.getElementById("chkout").value;

        // Check if both dates are selected
        if (!checkinDate || !checkoutDate) {
            // Display a message in the dropdown
            document.getElementById("sel1").innerHTML = "<option value=''>Please input Check In & Out date first</option>";
            return; // Exit the function
        }

        // AJAX request to fetch updated room options
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("sel1").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "update_room_options.php?checkindate=" + checkinDate + "&checkoutdate=" + checkoutDate, true);
        xhr.send();
    }

    // Function to reset the dropdown content when reset button is clicked
    function resetDropdown() {
        document.getElementById("sel1").innerHTML = "<option value=''>Please input Check In & Out date first</option>";
    }
</script>
