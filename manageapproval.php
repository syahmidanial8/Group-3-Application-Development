<?php
session_start(); 
//Prevent modify ID on the URL - eg usage: customermodify?id=3
if (!isset($_SERVER['HTTP_REFERER'])) {
  session_unset();
  session_destroy();
  echo '<script>alert("Access Denied! This screen is protected and not available to the public.")</script>';
  echo '<script>window.location = "index.php"</script>';
  exit;
}

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
                <a class="nav-link" href="home.php">Home</a>
              </li>
              
             <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
              </li>
             <li class="nav-item">
                <a class="nav-link" href="manageall.php">All Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manage.php">Reservation Approval</a>
              </li>
               <li class="nav-item">
                <a class="nav-link" href="report.php">Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mailto:support@hotelsunshine.com">Contact</a>
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

    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Approval</h1>
              <p>Reservation pending approval</p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section">
      <div class="container">
        <div class="row">

            <div class="col-md-12 text-center">


				<?php 
				include('hrssession.php');
				if (!session_id())
				{
					session_start(); 
				}

				//Retrieve ID from URL
				if(isset($_GET['id']))
				{
				    $bid = $_GET['id'];
				}

				include ('dbconnect.php');

	
				$sql = "SELECT * FROM o_book 
						LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
						LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid 
						LEFT JOIN o_status ON o_book.x_status = o_status.x_id
						WHERE x_bookid='$bid'";
				$result = mysqli_query($con,$sql);
				$row = mysqli_fetch_array($result);

				$sqllist = "SELECT * FROM o_status";
				$resultlist = mysqli_query($con,$sqllist);

				echo "<div class='container'>";
				echo "<form method = 'POST' action='manageapprovalprocess.php'>";
				echo "<table class='table table-hover'>";

				echo "<tr>";
				echo "<td>Booking ID :</td>";
				echo "<td>".$row['x_bookid']."<input type='hidden' name='fbid' value='".$row['x_bookid']."'></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Customer :</td>";
				echo "<td>".$row['x_user']."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Contact :</td>";
				echo "<td>".$row['x_telnum']."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Room :</td>";
				echo "<td>".$row['x_room']."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Pickup Date :</td>";
				echo "<td>".$row['x_datein']."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Return Date :</td>";
				echo "<td>".$row['x_dateout']."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Total Price :</td>";
				echo "<td>".$row['x_totalfee']."</td>";
				echo "</tr>";

        echo "<tr>";
				echo "<td>Customer Note :</td>";
				echo "<td>".$row['x_comment']."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>Approval </td>";
				echo "<td><select name='stat'>";
				while ($rowlist = mysqli_fetch_array($resultlist))
				{
					//filter out Status=0 (Received) from list of option values
					if ($rowlist['x_id'] == '0') 
					{
						echo"<option value='".$rowlist['x_id']."'></option>";
					}
          else if ($rowlist['x_id'] == '3') 
					{
						//Do nothing (hide it)
					}
					else
					{
				    	echo"<option value='".$rowlist['x_id']."'>".$rowlist['x_name']."</option>";
				    }
				}
				echo "</select></td>";
				echo "</tr>";

				echo "</table><br><br>";
				echo "<button type='submit' onClick='return savConfirmation();' class='btn btn-primary'>Save</button>";
				echo "</form>";
				echo "</div>";
				?>

               <script type="text/javascript">
                function savConfirmation()
                {
                  var x = confirm("Are you sure you want to save?");
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

<?php include 'footer.php'; ?>
