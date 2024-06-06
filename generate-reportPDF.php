<?php
require_once 'dompdf/autoload.inc.php';
include "dbconnect.php";

// reference the Dompdf namespace
use Dompdf\Dompdf;

if (isset($_GET['checkindate'], $_GET['checkoutdate'])) {
    $startDate = $_GET['checkindate'];
    $endDate = $_GET['checkoutdate'];

    // Get the current date and time for the unique filename
    $timestamp = date('YmdHis');

    // Prepare and execute the SQL query
    // $sql = "SELECT * FROM o_book WHERE DATE(x_datein) >= ? AND DATE(x_dateout) <= ?";
    $sql = "SELECT ob.*, ou.x_name FROM o_book ob JOIN o_user ou ON ou.x_userid = ob.x_user WHERE DATE(x_datein) >= ? AND DATE(x_dateout) <= ? ";
    $stmt = $con->prepare($sql);

    // Check if the statement preparation succeeded
    if ($stmt) {
        // Bind the parameters and execute the statement
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Instantiate and use dompdf
        $dompdf = new Dompdf();

     // Convert logo image to base64
     $logoPath = 'C:/xampp/htdocs/hrs/images/logo.png';
     $logoData = base64_encode(file_get_contents($logoPath));
     $logoSrc = 'data:image/png;base64,' . $logoData;


        // Load HTML content for the PDF
        $html = '<html><head><style>
            body {
                font-family: Arial, sans-serif;
            }
            h2 {
                color: #333;
                text-align: center;
                margin-bottom: 20px;
            }
            .info {
                text-align: right;
                margin-bottom: 10px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
                color: #333;
            }
            .odd {
                background-color: #f9f9f9;
            }
            .even {
                background-color: #ffffff;
            }
            .header {
                text-align: center;
                margin-bottom: 10px;
            }
            .header img {
                width: 180px; /* Adjust the width of the logo as needed */
                margin: 0 auto;
            }
       
        </style></head><body>';
        $html .= '<div class="header">  <img src="' . $logoSrc . '" alt="Logo"> </div>';
        $html .= '<div class="header">Report Generated on: ' . date('Y-m-d H:i:s') . '</div><br>';
        // $html .= '<h3>Booking Report</h3>';
        $html .= '<table>
            <tr>
                <th>Reservation ID</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Room No.</th>
                <th>Checkin Date</th>
                <th>Checkout Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>';

        // Add data rows
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            $html .= '<tr class="' . ($count % 2 == 0 ? 'even' : 'odd') . '">';
            $html .= '<td>' . $row['x_bookid'] . '</td>';
            $html .= '<td>' . $row['x_name'] . '</td>';
            $html .= '<td>' . $row['x_telnum'] . '</td>';
            $html .= '<td>' . $row['x_room'] . '</td>';
            $html .= '<td>' . $row['x_datein'] . '</td>';
            $html .= '<td>' . $row['x_dateout'] . '</td>';
            $html .= '<td>RM ' . $row['x_totalfee'] . '</td>';
            if( $row['x_status'] == 0)
            {
                $status = "Received";
            }
            else if ( $row['x_status'] == 1)
            {
                $status = "Approved";
            }
            else if ( $row['x_status'] == 2)
            {
                $status = "Rejected";
            }
            else if ( $row['x_status'] == 3)
            {
                $status = "Cancelled";
            }
            else{
                $status = "Unknown";

            }
            $html .= '<td>' . $status . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table></body></html>';

        // Load HTML to dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser with a unique filename
        $dompdf->stream('booking_report_' . $timestamp . '.pdf');
    } else {
        // Error in preparing the SQL statement
        echo json_encode(['error' => 'Error in preparing SQL statement.']);
    }
} else {
    // Missing GET parameters
    echo json_encode(['error' => 'Missing check-in and/or check-out dates.']);
}
