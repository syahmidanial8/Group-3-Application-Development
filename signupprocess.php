<?php
include("dbconnect.php");

$fid = mysqli_real_escape_string($con, $_POST["fid"]);  
$fpwd = mysqli_real_escape_string($con, $_POST["fpwd"]);  
$fpwd = password_hash($fpwd, PASSWORD_DEFAULT); 
$funame = $_POST['funame'];
$fic = $_POST['fic'];
$ftel = $_POST['ftel'];
$fmail = $_POST['fmail'];

$sql = "INSERT INTO o_user(x_userid, x_pwd, x_icnum, x_name,  x_tel,  x_email, x_userclass)
		VALUES ('$fid', '$fpwd', '$fic', '$funame', '$ftel', '$fmail', '1')";

mysqli_query($con,$sql);
mysqli_close($con);

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

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <header role="banner">
     
      <nav class="navbar navbar-expand-md navbar-dark bg-light">
        <div class="container">
          <a class="navbar-brand" href="index.php">Hotel Sunshine</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php#featuredrooms">Rooms</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mailto:support@hotelsunshine.com">Contact</a>
               </li>
               <li class="nav-item cta">
                <a class="nav-link" href="login.php"><span>Login</span></a>
              </li>
            </ul>
            
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->


    <section class="site-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Thank you for your registration</h1>
              <p>You may <a href="login.php" style="color:yellow;"><u>login</u></a> now to continue with reservation</p>
            </div>


          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

<?php include 'footer.php';?>