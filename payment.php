<?php
// include 'hrssession.php';
// if (!session_id()) {
//     session_start();
// }
session_start();

include 'dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['userislogged']) || $_SESSION['userislogged'] != 1) {
    header("Location: index.php?");
    exit;
}
// Check if the necessary session variables are set
if (!isset($_SESSION['x_userid']) || empty($_SESSION['x_userid'])) {
    header("Location: index.php?");
    exit;
}

$alloweduserclass = array(1);
if (!in_array($_SESSION['x_userclass'], $alloweduserclass)) {
    header("Location: index.php?");
}

//Retrieve data from form and session
// Data from $_POST and $_SESSION
$froom = $_POST['froom'];
$checkindate = $_POST['checkindate'];
$checkoutdate = $_POST['checkoutdate'];
$guestnum = $_POST['guestnum'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$comment = mysqli_real_escape_string($con, $_POST['comment']);

$fid = $_SESSION['xuserid'];

// Constructing new data array
$newData = array(
    'froom' => $froom,
    'checkindate' => $checkindate,
    'checkoutdate' => $checkoutdate,
    'guestnum' => $guestnum,
    'email' => $email,
    'tel' => $tel,
    'comment' => $comment,
    'fid' => $fid,
);

// Convert the data to JSON format
$encodedData = json_encode($newData); // for customerbookingprocess

//Calculate total rent
$sqlp = "SELECT x_price FROM o_room WHERE x_roomid='$froom'";
$resultp = mysqli_query($con, $sqlp);
$rowp = mysqli_fetch_array($resultp);

$start = date('Y-m-d H:i:s', strtotime($checkindate));
$end = date('Y-m-d H:i:s', strtotime($checkoutdate));
$daydiff = abs(strtotime($start) - strtotime($end));
$daynum = $daydiff / (60 * 60 * 24);
$totalprice = $daynum * ($rowp['x_price']);
$x_user = $_SESSION['xuserid'];
// $sql = "INSERT INTO o_book (x_user, x_room, x_datein, x_dateout, x_totalfee, x_status, x_guestnum, x_emailaddr, x_telnum, x_comment) VALUES ('$fid', '$froom', '$checkindate', '$checkoutdate', '$totalprice', '0', '$guestnum', '$email', '$tel', '$comment')";

//var_dump($sql);

?>
<!doctype html>
<html lang="en">
   <head>
      <title>Online Hotel Reservation</title>
 <meta http-equiv="Content-Security-Policy" content="connect-src 'self' https://merchant-ui-api.stripe.com https://merchant-ui-api.stripe.com/link/set-cookie;">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
      <style>
    /* Customize the form background and card element */
    #payment-form {
        background-color: #f8f9fa; /* Light gray background */
        padding: 20px;
        border-radius: 10px;
    }

    #card-element {
        margin-bottom: 20px;
    }

    /* Customize the submit button */
    #submit-button {
        background-color: #007bff; /* Blue submit button */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #submit-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    /* Customize error messages */
    #card-errors {
        color: #dc3545; /* Red error messages */
        margin-top: 10px;
    }
</style>

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
                        <a class="nav-link" href="mailto:support@megahjaya.com">Contact</a>
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
                  <div class="mb-5 pt-5 element-animate">
                     <h1 style= "color:white" >Payment</h1>
                     <p>Pay and secure your reservation now</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- END section -->
      <!-- DataTables CSS -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
      <div class="col-md-12 pt-4 text-right">
      </div>
      <div class="col-md-12 text-center">
         <div class="row row-card-no-pd">
            <div class="col-md-4">
               <div class="card">
                  <div class="card-body">
                     <h3>
                        <p class="fw-bold mt-1">Price Summary</p>
                     </h3>
                     <h6 class="card-title" style="font-family: Arial, sans-serif;">Room Type:<?php echo $froom; ?></h6>
                     <h6 class="card-title" style="font-family: Arial, sans-serif;">Check In Date: <?php echo $checkindate;?></h6>
                     <h6 class="card-title" style="font-family: Arial, sans-serif;">Check Out Date: <?php echo $checkoutdate;?></h6>
                     <h6 class="card-title" style="font-family: Arial, sans-serif;">Total Price: RM <?php echo $totalprice;?></h6>
                                          <h6 class="card-title" style="font-family: Arial, sans-serif;">Name: <?php echo $x_user;?></h6>
                     <!-- <a href="#" class="btn btn-primary btn-full text-left mt-3 mb-3"><i class="la la-plus"></i> Add Balance</a> -->
                  </div>
                  <div class="card-footer">
                     <ul class="nav">
                        <li class="nav-item"><a class="btn btn-default btn-link" href="manage.php"><i class="la la-history"></i> Details</a></li>
                        <li class="nav-item ml-auto"><a class="btn btn-default btn-link" href="#"><i class="la la-refresh"></i> Refresh</a></li>
                     </ul>
                  </div>
               </div>
            </div>
        <div class="col-md-8">
          <div class="card" style="height: 325px;">
              <div class="card-body">
                  <br>
                  <h2>Payment Details</h2>
                  <form id="payment-form">
                     <div class="payment-icons">
        <i class="fab fa-cc-visa"></i> <!-- Visa credit card icon -->
        <i class="fab fa-cc-mastercard"></i> <!-- Mastercard credit card icon -->
        <i class="fab fa-cc-amex"></i> <!-- American Express credit card icon -->
        <i class="fab fa-cc-discover"></i> <!-- Discover credit card icon -->
        <i class="fab fa-cc-paypal"></i> <!-- PayPal icon -->
        <i class="fas fa-money-check-alt"></i> <!-- Debit card icon -->
    </div>
                      <div id="card-element">
                          <!-- Stripe Element for card details -->
                      </div>
                      <!-- Used to display form errors -->
                      <div id="card-errors" role="alert"></div>
                      <button id="submit-button" type="submit">Pay Now</button>
                  </form>
              </div>
          </div>
      </div>

          </div>

         </div>
      </div>
      </div>
      <br>
      <div class="container-fluid">
        <div class="row">
      </div>
      </section>

      <?php include 'footer.php'?>
      <!-- Include Stripe.js -->
      <script src="https://js.stripe.com/v3/"></script>
 
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('pk_test_51PGNx2J9ml5ZL2Dpmj5hlh39BluOO4H8ZjlwjNZq2WkJL6CvdKPYSeOYxMMnwU9yXUD8usW1AZtW8Jq9eGzCnS5t007kQ53ZSU');
    var elements = stripe.elements();

    var style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            '::placeholder': {
                color: '#aab7c4'
            },
            backgroundColor: '#f8f9fa',
            padding: '10px',
            borderRadius: '5px'
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var card = elements.create('card', { style: style });
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        document.getElementById('submit-button').disabled = true;

        stripe.createPaymentMethod({
            type: 'card',
            card: card,
            billing_details: {
                // Add additional billing details here if required
            }
        }).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                document.getElementById('submit-button').disabled = false;
            } else {

                var paymentMethodId = result.paymentMethod.id;
                var totalPrice = <?php echo json_encode($totalprice); ?>; // Get the total price from PHP
                var x_room = <?php echo json_encode($froom); ?>;
                var x_user = <?php echo json_encode($_SESSION['x_user']); ?>;

                // data to be send to stripeprocess - for stripe server and transacation tbl
                var data = {
                    payment_method_id: paymentMethodId,
                    total_price: totalPrice,
                    payment_currency: "myr",
                    payment_status: "Success",
                    x_user:  x_user,
                    x_room: x_room,
                    payment_timestamp: new Date().toISOString(),
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString(),
                };
                
              fetch('stripeprocess.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
                    })
                    .then(function(response) {
                        // Log the raw response data
                        console.log('Raw Response:', response);
                        // window.location.href = 'customerbookingprocess.php?stype=sucesspaid';
                        return response.json();
                          
                    })
                    .then(function(data) { //received status 200 return success - so redirect
                        // Handle parsed JSON data
                        console.log('Parsed Data:', data);
                                            
                        // alert(data.message);
                      
                        var newData = {
                                froom: '<?php echo $froom; ?>',
                                checkindate: '<?php echo $checkindate; ?>',
                                checkoutdate: '<?php echo $checkoutdate; ?>',
                                guestnum: '<?php echo $guestnum; ?>',
                                email: '<?php echo $email; ?>',
                                tel: '<?php echo $tel; ?>',
                                comment: '<?php echo $comment; ?>',
                                fid: '<?php echo $fid; ?>'
                            };

                            // Function to convert object to query string
                            function objectToQueryString(obj) {
                                return Object.keys(obj).map(key => key + '=' + encodeURIComponent(obj[key])).join('&');
                            }

                            var queryString = objectToQueryString(newData);

                            // Redirect to customerbookingprocess.php with additional data in the URL
                            window.location.href = 'customerbookingprocess.php?stype=successfuly-paid&' + queryString;
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                    });

                        }
                    });
              });
</script>
