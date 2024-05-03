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
          <div class="col-md-6 text-center">

            <div class="mb-5 element-animate">
              <br>
			<!-- Enclose the form inside a div with a white background -->
			<div class="white-box">  
			<br>
              <h1 style ="color: grey;">Registration</h1><br>

                <form method="POST" action="signupprocess.php">

                  <div class="form-group">
                    <!--<label for="email" style="color: white;">Username:</label>-->
                    <input type="text" class="form-control" id="email" placeholder="Username" name="fid" required>
                  </div>
                  <div class="form-group">
                    <!--<label for="pwd" style="color: white;">Create your Password:</label>-->
                    <input type="password" class="form-control" id="pwd" placeholder="Password" name="fpwd" required>
                  </div>

                  <div class="form-group">
                    <!--<label for="email" style="color: white;">Full Name:</label>-->
                    <input type="text" class="form-control" id="uname" placeholder="Full name" name="funame" required>
                  </div>

                  <div class="form-group">
                    <!--<label for="email" style="color: white;">Identity Card:</label>-->
                    <input type="text" class="form-control" id="email" placeholder="Identity Card number" name="fic" required>
                  </div>

                  <div class="form-group">
                    <!--<label for="email" style="color: white;">Contact Number:</label>-->
                    <input type="text" class="form-control" id="cnum" placeholder="Phone number - Format : [3]-[7 or 8] digit, eg : 012-3456789" pattern="[0-9]{3}-[0-9]{7}|[0-9]{3}-[0-9]{8}" name="ftel" required>
                  </div>

                  <div class="form-group">
                    <!--<label for="email" style="color: white;">License:</label>-->
                    <input type="text" class="form-control" id="lnum" placeholder="Email address" name="fmail" required>
                  </div>
                  
                  <div class="checkbox">
                      <label style="color: grey;"><input type="checkbox" name="remember"> Remember me</label>
                  </div>
                  <button type="reset" class="btn btn-default">Reset</button>
                  <button type="submit" class="btn btn-primary">Register</button>
                </form><br>
          </div>
          <!-- End white box -->
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

 <?php include 'footer.php';?>