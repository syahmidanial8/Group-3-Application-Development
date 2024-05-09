<?php 
include('hrssession.php');
if (!session_id())
{
	session_start(); 
}
//include 'headercustomer.php';
include ('dbconnect.php');

$fid = $_SESSION['xuserid'];
$sqlb = "SELECT x_name FROM o_user WHERE x_userid = '$fid'";
$resultb = mysqli_query($con,$sqlb);
$rowb = mysqli_fetch_array($resultb);
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

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
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

            <div class="mb-5 element-animate">
              <h1>Welcome <?php echo $rowb['x_name']; ?></h1>
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
                <form method="POST" action="customerbookingprocess.php" >
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          
                          <label for="chkin">Check In Date</label>
                          <div style="position: relative;">
                            <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span>
                            <input type='date' class="form-control" id='chkin' name='checkindate' required />
                          </div>
                      </div>

                      <div class="col-sm-6 form-group">
                          
                          <label for="chkout">Check Out Date</label>
                          <div style="position: relative;">
                            <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span>
                            <input type='date' class="form-control" id='chkout' name='checkoutdate' required />
                          </div>
                      </div>
                      
                  </div>


                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="sel1">Room</label>
                        <?php
                            $sql = "SELECT * FROM o_room";
                            $result = mysqli_query($con, $sql);


                            echo "<select class='form-control' id='sel1' name='froom'>";//fvec
                            while ($row=mysqli_fetch_array($result))
                            {
                                echo "<option value='".$row['x_roomid']."'>".$row['x_roomid']. " - " .$row['x_roomtype']."</option>";
                                
                            }
                            echo "</select>";
                        ?>
                      <!--
                      <select name="" id="room" class="form-control">
                        <
                        <option value="">1 Room</option>
                        <option value="">2 Rooms</option>
                        <option value="">3 Rooms</option>
                        <option value="">4 Rooms</option>
                        <option value="">5 Rooms</option>
                      </select>
                      -->
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
                      <label for="tel">Telephone Failed</label>
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
                      <input type="reset" value="Clear Information" class="btn btn-default">
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


<?php include 'footer.php'; ?>