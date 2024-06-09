<?php
include('hrssession.php');
if (!session_id()) {
    session_start(); 
}
include 'dbconnect.php';
include 'functions.php'; // Include the file where the getroleid function is defined

// Check if the user is logged in
if (!isset($_SESSION['userislogged']) || $_SESSION['userislogged'] != 1) {
    header("Location: index.php");
    exit;
}

// Check if the necessary session variables are set
if (!isset($_SESSION['x_userid']) || empty($_SESSION['x_userid'])) {
    header("Location: index.php");
    exit;
}

$alloweduserclass = array(0);
if (!in_array($_SESSION['x_userclass'], $alloweduserclass)) {
    header("Location: index.php");
}

// Proceed with retrieving data
$sql = "SELECT * FROM o_book
        LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
        LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
        LEFT JOIN o_status ON o_book.x_status = o_status.x_id
        WHERE x_status in ('0','1', '2', '3')";  //to display all reservations

$result = mysqli_query($con, $sql);



if (isset($_POST['search'])) {
    $x_userclass = $_POST['x_userclass'];
}

?>


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
              <h1>All Reservations</h1>
              <p>Reservation list</p>
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
                  <tr style="background-color: #f8f9fa;">
                      <!-- <th class="mt-6 pt-3 text-center">New Reservation</th> -->
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
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Room No.</th>
                    <th>Checkin Date</th>
                    <th>Checkout Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Operation</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    while($row=mysqli_fetch_array($result))
                    {
                      echo"<tr>";
                      echo "<td>".$row['x_bookid']."</td>";
                      echo "<td>".$row['x_user']."</td>";
                      echo "<td>".$row['x_tel']."</td>";
                      echo "<td>".$row['x_roomid']."</td>";
                      echo "<td>".$row['x_datein']."</td>";
                      echo "<td>".$row['x_dateout']."</td>";
                      echo "<td>".$row['x_totalfee']."</td>";
                      // echo "<td>".$row['x_name']."</td>";
                      echo "<td>";
                      if ($row['x_status'] == 0) {
                        $escapedReason = htmlspecialchars($row['x_comment'], ENT_QUOTES, 'UTF-8');
                        echo "<a href='#' class='reason-link' onclick='showReasonRsv(\"$escapedReason\")'>".$row['x_name']."</a>";
                        }
                        else if ($row['x_status'] == 1) {
                        $escapedReason = htmlspecialchars($row['x_approvalreason'], ENT_QUOTES, 'UTF-8');
                        echo "<a href='#' class='reason-link' onclick='showReasonApprove(\"$escapedReason\")'>".$row['x_name']."</a>";
                        }
                        else if ($row['x_status'] == 2) {
                          $escapedReason = htmlspecialchars($row['x_approvalreason'], ENT_QUOTES, 'UTF-8');
                          echo "<a href='#' class='reason-link' onclick='showReasonReject(\"$escapedReason\")'>".$row['x_name']."</a>";
                          }
                        else if ($row['x_status'] == 3) {
                          $escapedReason = htmlspecialchars($row['x_cancelreason'], ENT_QUOTES, 'UTF-8');
                          echo "<a href='#' class='reason-link' onclick='showReason(\"$escapedReason\")'>".$row['x_name']."</a>";
                        } else {
                          echo $row['x_name'];
                        }
                      echo "<td>"; //for 'Operation'
                        // echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation(event, this.href);' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                        // // echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation();' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                        
                        //Original Logic
                        // Check if the status is not 'Cancelled' (status 3) before displaying the Cancel button
                        // if ($row['x_status'] != 3) {
                        //   echo "<a href='customercancel.php?id=" . $row['x_bookid'] . "' onClick='return delConfirmation(event, this.href);' class='btn btn-secondary'>Cancel</a>&nbsp;";
                        // } else {
                        //   // echo "<button class='btn btn-info' onclick='s howReason(\"".$row['x_cancelreason']."\")'>Reason</button>&nbsp;";
                        //   echo "<button class='btn btn-info' onclick='showReason(".htmlspecialchars(json_encode($row['x_cancelreason']), ENT_QUOTES, 'UTF-8').")'>Reason</button>&nbsp;";
                        // }
                        // echo "<a href='manageapproval.php?id=".$row['x_bookid']."' class ='btn btn-primary'>Modify</a>";

                        //Second Original Logic
                        // if($row['x_status'] == 0){
                        //   echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation(event, this.href);' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                        // }
                        // else if($row["x_status"] == 1){
                        //   echo "<button class='btn btn-info' onclick='showReasonApproval(".htmlspecialchars(json_encode($row['x_approvalreason']), ENT_QUOTES, 'UTF-8').")'>Reason</button>&nbsp;";
                        // }
                        // else if($row['x_status'] == 2){
                        //   echo "<button class='btn btn-info' onclick='showReasonApproval(".htmlspecialchars(json_encode($row['x_approvalreason']), ENT_QUOTES, 'UTF-8').")'>Reason</button>&nbsp;";
                        // }
                        // else if($row['x_status'] == 3){
                        //   // echo "<button class='btn btn-info' onclick='showReason(\"".$row['x_cancelreason']."\")'>Reason</button>&nbsp;";
                        //   echo "<button class='btn btn-info' onclick='showReason(".htmlspecialchars(json_encode($row['x_cancelreason']), ENT_QUOTES, 'UTF-8').")'>Reason</button>&nbsp;";
                        // }     
                        // echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation(event, this.href);' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                        
                        if ($row['x_status'] != 3) {
                          echo "<a href='customercancel.php?id=".$row['x_bookid']. "' onClick='return delConfirmation(event, this.href);' class ='btn btn-secondary'>Cancel</a>&nbsp;";
                        } else { //set disable hover mouse
                          echo "<a href='#' class ='btn btn-secondary' style='pointer-events: none; opacity: 0.5; cursor: not-allowed;' disabled>Cancel</a>&nbsp;";
                        }
                        echo "<a href='manageapproval.php?id=" . $row['x_bookid'] . "' class ='btn btn-primary'>Modify</a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>

        </div>
      </div>

        </div>
      </div>
    </section>

   
   <?php include 'footer.php'; ?>
<!-- 
<script type="text/javascript">
                function delConfirmation()
                {
                  var x = confirm("Are you sure you want to delete?");
                  if (x == true)
                  {
                    return true;
                  }
                  else
                  {
                    return false;
                  }
                }
</script>    -->
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