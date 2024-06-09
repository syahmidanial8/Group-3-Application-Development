<?php 
include('hrssession.php');
if (!session_id())
{
  session_start(); 
}
//include 'headeradmin.php';
include ('dbconnect.php');

$fid = $_SESSION['xuserid'];
if (isset($_POST['search'])) {
    $x_userclass = $_POST['x_userclass'];
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
          <?php


// Check if the userclass is set in the session
if (isset($_SESSION['x_userclass'])) {
    // Check if userclass is admin (0)
    if ($_SESSION['x_userclass'] == 0) {
        // Admin navigation menu
        echo '
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
          </div>';
    } elseif ($_SESSION['x_userclass'] == 1) {
        // Customer navigation menu
        echo '
          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customer.php">Room Reservation</a>
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
              <li class="nav-item cta">
                <a class="nav-link" href="logout.php"><span>Logout</span></a>
              </li>
            </ul>
          </div>';
    }
}
?>
        </div>
      </nav>
    </header>
    <!-- END header -->



    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Search Result</h1>
              <p></p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 text-right">  
            <table class="table table-hover">
                <thead>
                  <tr>
                       <form method="POST" name="search" action="searchresult.php"><br>
                      <input type="hidden" name="x_userid" value="<?php echo $_SESSION['x_userid']; ?>">
                       <input type="hidden" name="x_userclass" value="<?php echo $_SESSION['x_userclass']; ?>">
                      <input type="text" placeholder=" Reservation ID" name="search">
                      <button type="submit" value="search"><i class="fa fa-search"></i></button>
                      </form>
                  </tr>
                </thead>
            </table>
          </div>


            <div class="col-md-12 text-center">               
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Reservation ID</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Operation</th>
                  </tr>
                </thead>

                <tbody>
                  <?php              
                        // PROCESS SEARCH WHEN FORM SUBMITTED
                        if (isset($_POST['search'])) 
                        {
                          // SEARCH FOR USERS
                          require "searchprocess.php";

                          // DISPLAY RESULTS
                          if (count($results) > 0) 
                          {
                            foreach ($results as $row) 
                            {
                              //printf("<div>%s - %s</div>", $r['x_bookid'], $r['x_room']);
                              echo"<tr>";
                              echo "<td>".$row['x_bookid']."</td>";
                              echo "<td>".$row['x_roomid']."</td>";
                              echo "<td>".$row['x_roomtype']."</td>";
                              echo "<td>".$row['x_datein']."</td>";
                              echo "<td>".$row['x_dateout']."</td>";
                              echo "<td>".$row['x_totalfee']."</td>";
                              echo "<td>".$row['x_name']."</td>";
                              echo "<td>"; //for 'Operation'

                            // Check if the status is not 'Cancelled' (status 3) before displaying the Cancel button                  
                            if($row['x_status'] == 0){
                              echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation(event, this.href);' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                              echo "<a href='customermodify.php?id=" . $row['x_bookid'] . "' class ='btn btn-primary'>Modify</a>&nbsp";
                            }
                            else if($row["x_status"] == 1){
                              echo "<button class='btn btn-info' onclick='showReasonApprove(".htmlspecialchars(json_encode($row['x_approvalreason']), ENT_QUOTES, 'UTF-8').")'>Info</button>";
                            }
                            else if($row['x_status'] == 2){
                              echo "<button class='btn btn-info' onclick='showReasonReject(".htmlspecialchars(json_encode($row['x_approvalreason']), ENT_QUOTES, 'UTF-8').")'>Info</button>";
                            }
                            else if($row['x_status'] == 3){
                              //echo "<button class='btn btn-info' onclick='showReason(\"".$row['x_cancelreason']."\")'>Reason</button>&nbsp;";
                              echo "<button class='btn btn-info' onclick='showReason(".htmlspecialchars(json_encode($row['x_cancelreason']), ENT_QUOTES, 'UTF-8').")'>Info</button>";
                          }       

                              echo "</td>";
                              echo "</tr>";
                            }
                          } 
                          else 
                          { 
                            echo "<td colspan='9'>No results found</td>";                        
                          }
                        }
                    

                  ?>
                </tbody>
              </table>
            </div>


          
        </div>
      </div>
    </section>

    <script type="text/javascript" src="js/sweetalert.js" language="javascript"></script>
              <script type="text/javascript">
                function delConfirmation(event, url)
                {
                  event.preventDefault(); // Prevent the default link behavior
                  
                  // Swal.fire({
                  //   title: 'Are you sure?',
                  //   text: "You won't be able to revert this!",
                  //   icon: 'warning',
                  //   showCancelButton: true,
                  //   confirmButtonColor: '#3085d6',
                  //   cancelButtonColor: '#d33',
                  //   confirmButtonText: 'Yes, cancel it!'
                  // }).then((result) => {
                  //   if (result.isConfirmed) {
                  //     window.location.href = url;
                  //   }
                  // });

                  Swal.fire({
                    title: 'Cancellation Reason',
                    input: 'text',
                    inputLabel: 'Please enter the reason for cancellation:',
                    inputPlaceholder: 'Enter reason',
                    showCancelButton: true,
                    inputValidator: (value) => {
                      if (!value) {
                        return 'You need to write something!'
                      }
                    }
                  }).then((result) => {
                    if (result.isConfirmed) {
                      var reason = result.value;
                      Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, cancel it!'
                      }).then((confirmResult) => {
                        if (confirmResult.isConfirmed) {
                          // Redirect to customercancel.php with the reason as a query parameter
                          window.location.href = url + '&reason=' + encodeURIComponent(reason);
                        }
                      });
                    }
                  });
                }

                function showReasonRsv(reason) {
                  Swal.fire({
                    // title: 'Cancellation Reason',
                    // text: reason,
                    title: reason,
                    text: '[New Reservation]',
                    icon: 'info'
                  });
                }
                function showReason(reason) {
                  Swal.fire({
                    // title: 'Cancellation Reason',
                    // text: reason,
                    title: reason,
                    text: '[Cancelled]',
                    icon: 'info'
                  });
                }
                function showReasonApprove(reason) {
                  Swal.fire({
                    // title: 'Infomation:',
                    // text: reason,
                    title: reason,
                    text: '[Approved]',
                    icon: 'info'
                  });
                }
                function showReasonReject(reason) {
                  Swal.fire({
                    // title: 'Infomation:',
                    // text: reason,
                    title: reason,
                    text: '[Rejected]',
                    icon: 'info'
                  });
                }
              </script>
   
   <?php include 'footer.php'; ?>
  </body>
</html>
