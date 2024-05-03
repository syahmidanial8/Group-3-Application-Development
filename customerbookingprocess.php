<?php 
include('hrssession.php');
if (!session_id())
{
	session_start(); 
}

include ('dbconnect.php');

//Retrieve data from form and session
$froom = $_POST['froom'];
$checkindate = $_POST['checkindate'];
$checkoutdate = $_POST['checkoutdate'];
$guestnum = $_POST['guestnum'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$comment = $_POST['comment'];
$fid = $_SESSION['xuserid'];

//Calculate total rent
$sqlp = "SELECT x_price FROM o_room WHERE x_roomid='$froom'";
$resultp = mysqli_query($con,$sqlp);
$rowp = mysqli_fetch_array($resultp);

$start = date('Y-m-d H:i:s', strtotime($checkindate));
$end = date('Y-m-d H:i:s', strtotime($checkoutdate));
$daydiff = abs(strtotime($start)-strtotime($end));
$daynum = $daydiff/(60*60*24);
$totalprice = $daynum*($rowp['x_price']);

$sql = "INSERT INTO o_book (x_user, x_room, x_datein, x_dateout, x_totalfee, x_status, x_guestnum, x_emailaddr, x_telnum, x_comment) VALUES ('$fid', '$froom', '$checkindate', '$checkoutdate', '$totalprice', '0', '$guestnum', '$email', '$tel', '$comment')";

//var_dump($sql);

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
          <a class="navbar-brand" href="home.php">Hotel Sunshine</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              <li class="nav-item">
                <a class="nav-link active" href="home.php">Home</a>
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
              </li>
               <li class="nav-item cta">
                <a class="nav-link" href="logout.php"><span>Logout</span></a>
              </li>
            </ul>
            
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->

    <section class="site-section" data-stellar-background-ratio="0.5" style="background-color:#40826D"><!--style="background-image: url(images/big_image_1.jpg);"-->
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-6 text-center">

            <div class="mb-5 element-animate">
				<h1 style="color:white;">Thank your for your reservation</h1>
              	<p style="color:white;">Here's your reservation details</p>
	              	<div class="col-md-12 text-center" style="color:white;">
		              	<table class="table table-hover">
			              	<tr>
			              		<td>Username: </td>
			              		<td><?php echo $fid;?></td>
			              	</tr>
			              	<tr>
			              		<td>Telephone: </td>
			              		<td><?php echo $tel;?></td>
			              	</tr>
			              	<tr>
			              		<td>Email: </td>
			              		<td><?php echo $email;?></td>
			              	</tr>
			              	<tr>
			              		<td>Room No.: </td>
			              		<td><?php echo $froom;?></td>
			              	</tr>
			              	<tr>
			              		<td>Guests: </td>
			              		<td><?php echo $guestnum;?></td>
			              	</tr>
			              	<tr>
			              		<td>Check In Date: </td>
			              		<td><?php echo $checkindate;?></td>
			              	</tr>
			              	<tr>
			              		<td>Check Out Date: </td>
			              		<td><?php echo $checkoutdate;?></td>
			              	</tr>
			              	<tr>
			              		<td>Duration: </td>
			              		<td><?php echo $daynum;?></td>
			              	</tr>
			              	<tr>
			              		<td>Total Price: </td>
			              		<td><?php echo $totalprice;?></td>
			              	</tr>
			              	<tr>
			              		<td>Reservation Status: </td>
			              		<td>Received</td>
			              	</tr>    
			              	<tr>
			              		<td></td>
			              		<td></td>
			              	</tr>          		
						</table>
					</div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

<?php include 'footer.php' ?>