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

if (isset($_POST['search_report'])) {
    $x_userclass = $_POST['x_userclass'];
    $checkindate = $_POST['checkindate'];
    $checkoutdate = $_POST['checkoutdate'];
    echo $checkindate;
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
                <a class="nav-link" href="manage.php">Home</a>
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
              <h1>Generate Report</h1>
              <p>Review report</p>
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
        <th class="mt-6 pt-3 text-center">Report</th>
    </tr>
    <tr>
        <td colspan="3">
          <form method="POST" name="search_report" id="searchForm" action="searchreport.php">
            <div class="row">
                <div class="col-sm-2 form-group">
                    <label for="chkin">Check In Date</label>
                    <div style="position: relative;">
                        <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span>
                        <input type='date' class="form-control" id='chkin' name='checkindate' required onchange="setMinCheckoutDate()" />
                    </div>
                </div>
                <div class="col-sm-2 form-group">
                    <label for="chkout">Check Out Date</label>
                    <div style="position: relative;">
                        <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span>
                        <input type='date' class="form-control" id='chkout' name='checkoutdate' required />
                    </div>
                </div>
               <div class="col-sm-2 form-group d-flex align-items-center pt-3">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Generate</button>
        </div>
        <div class="col-sm-2 form-group d-flex align-items-center pt-3">
            <button type="button" id="exportButton" class="btn btn-success btn-block"><i class="fa fa-download"></i> Export Data</button>
        </div>
            </div>
        </form>
        </td>
    </tr>
</thead>



            </table>
          </div>


            <div class="col-md-12 text-center">               
            <div id="reportTable"></div>
            </div>

        </div>
      </div>

    </section>

   <script type="text/javascript" src="js/sweetalert.js" language="javascript"></script>
   <?php include 'footer.php'; ?>
    <script>
          
                // Set the minimum check-out date to the selected check-in date
                document.getElementById("chkout").min = checkinDate.toISOString().split('T')[0];
            }
        </script>
      
<script>
    // Define a global variable to track whether the report is generated
var reportGenerated = false;

document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    var checkinDate = document.getElementById('chkin').value;
    var checkoutDate = document.getElementById('chkout').value;

    console.log("Check-in Date: " + checkinDate);
    console.log("Check-out Date: " + checkoutDate);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.error) {
                    // Display error message if there is an error
                    document.getElementById('reportTable').innerHTML = data.error;
                } else {
                    // Construct HTML table from data and append it to the reportTable div
                    var tableHtml = '<table class="table table-hover"><thead><tr><th>Reservation ID</th><th>Name</th><th>Contact</th><th>Room No.</th><th>Checkin Date</th><th>Checkout Date</th><th>Total Price (RM)</th><th>Status</th></tr></thead><tbody>';
                    data.forEach(function(row) {
                        tableHtml += '<tr>';
                        row.forEach(function(cell) {
                            tableHtml += '<td>' + cell + '</td>';
                        });
                        tableHtml += '</tr>';
                    });
                    tableHtml += '</tbody></table>';
                    document.getElementById('reportTable').innerHTML = tableHtml;
                    
                    // Set reportGenerated to true
                    reportGenerated = true;
                }
            } else {
                // Display error message if there is an error in the AJAX request
                document.getElementById('reportTable').innerHTML = 'Error in AJAX request.';
            }
        }
    };
    xhr.open('POST', 'searchreport.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(new URLSearchParams(formData).toString());
});

document.getElementById('exportButton').addEventListener('click', function() {
    // Check if the report is generated - true
    if (reportGenerated) {
        // Get the selected check-in and check-out dates
        var checkinDate = document.getElementById('chkin').value;
        var checkoutDate = document.getElementById('chkout').value;

        // Construct the URL with the selected dates
        var url = 'generate-reportPDF.php?checkindate=' + checkinDate + '&checkoutdate=' + checkoutDate;

        // Open the URL in a new tab
        window.open(url, '_blank');
    } else {
        // Prompt user to generate the report first
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please generate the report first!',
        });
    }
});

</script>




