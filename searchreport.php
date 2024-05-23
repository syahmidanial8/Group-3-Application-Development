<?php
// Include the database connection
include 'dbconnect.php';

// Check if the necessary POST parameters are set
if (isset($_POST['checkindate'], $_POST['checkoutdate'])) {
    // Prepare and execute the SQL query
    $sql = "SELECT ob.*, ou.x_name FROM o_book ob JOIN o_user ou ON ou.x_userid = ob.x_user WHERE DATE(x_datein) >= ? AND DATE(x_dateout) <= ? ";
    $stmt = $con->prepare($sql);

    // Check if the statement preparation succeeded
    if ($stmt) {
        // Bind the parameters and execute the statement
        $stmt->bind_param("ss", $_POST['checkindate'], $_POST['checkoutdate']);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Initialize an array to hold the formatted data
            $data = [];

            // Fetch data and format it as required
            while ($row = $result->fetch_assoc()) {
                // Create an inner array for each row
                if ($row['x_status'] == 0) {
                    $status = "Received";
                } else if ($row['x_status'] == 1) {
                    $status = "Approved";
                } else {
                    $status = "Rejected";

                }

                $rowData = [
                    $row['x_bookid'],
                    $row['x_name'],
                    $row['x_telnum'],
                    $row['x_room'],
                    $row['x_datein'],
                    $row['x_dateout'],
                    $row['x_totalfee'],
                    $status,
                ];

                // Add the inner array to the data array
                $data[] = $rowData;
            }

            // Output data as JSON for DataTable
            echo json_encode($data);
        } else {
            // No data found for the given date range
            echo json_encode(['error' => 'No bookings found for the specified date range.']);
        }
    } else {
        // Error in preparing the SQL statement
        echo json_encode(['error' => 'Error in preparing SQL statement.']);
    }
} else {
    // Missing POST parameters
    echo json_encode(['error' => 'Missing check-in and/or check-out dates.']);
}
