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
                <a class="nav-link" href="signup.php"><span>Sign Up</span></a>
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
          <div class="col-md-5 text-center">
		  
			<!-- Enclose the form with a white background -->
			<div class="white-box">   
			<br>
            <div class="mb-5 element-animate">
              <h1 style ="color: grey;">Log In</h1>
              <p style ="color: grey;">Login to make your reservation</p>
			
              <form method="POST" action="loginprocess.php">
                <div class="form-group">
                  <label for="email" style="color: grey;">Username:</label>
                  <input type="text" class="form-control" id="uid" placeholder="Enter your username" name="fid" >
                </div>
                <div class="form-group">
                  <label for="pwd" style="color: grey;">Password:</label>
                  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="fpwd" >
                </div>
                <div class="checkbox">
                  <label style="color: grey;"><input type="checkbox" name="remember"> Remember me</label>
                </div>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary">Proceed</button>
				
				<br>
			   <!-- DISABLED - Continue as Visitor button 
				<button type="button" class="btn btn-primary" onclick="continueAsVisitor()">Continue as Visitor</button>
					
              </form>
				<script>
				  function continueAsVisitor() {
					// Set the value of the username field to "visitor"
					document.getElementById("uid").value = "visitor";
					// Submit the form
					document.querySelector("form").submit();
				  }
				</script>			  
				-->
			  </div>
			  <!-- End white box -->	
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

<?php include 'footer.php';?>

<script type="text/javascript" src="js/sweetalert.js" language="javascript"></script>
<?php
if (isset($_GET["stype"]) && $_GET["stype"] == 'invalid-pass') {
    echo '
        <script>
            // Use SweetAlert
            Swal.fire({
                icon: "warning",
                title: "Failed to login",
                text: "User not found or password incorrect",
            });
        </script>
    ';
}
else if  (isset($_GET["stype"]) && $_GET["stype"] == 'user-notfound') {
    echo '
        <script>
            // Use SweetAlert
            Swal.fire({
                icon: "warning",
                title: "Failed to login",
                text: "User not found.",
            });
        </script>
    ';
}
else if  (isset($_GET["stype"]) && $_GET["stype"] == 'loggedout') {
    echo '
        <script>
            // Use SweetAlert
            Swal.fire({
                icon: "success",
                title: "Logout Success",
                text: "See you again !",
            });
        </script>
    ';
}

