<?php

function generateToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $codeAlphabet .= "-_.~"; // Special characters allowed in url
    $max = strlen($codeAlphabet);

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max - 1)]; //random_int() -php7, rand() - php5
    }

    return $token;
}

function getuserclass($con, $x_userid)
{
    $x_userid = mysqli_real_escape_string($con, $x_userid);
    $sql = "SELECT us.x_userid FROM o_user us
            WHERE us.x_userid = '$x_userid'";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['x_userclass'];
    }
}
//box 1
function countTotalBookings()
{
    global $con;

    // Query to count the total number of bookings
    $sql = "SELECT COUNT(x_bookid) AS totalBookings FROM o_book WHERE x_status IN (0)";
    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the total number of bookings from the result
        $row = mysqli_fetch_assoc($result);
        $totalBookings = $row['totalBookings'];
        return $totalBookings;
    } else {
        // Query failed
        return false;
    }
}

function countCheckIn()
{
    global $con;

    // Query to count the total number of bookings
    // $sql = "SELECT COUNT(x_bookid) AS totalCheckIn
    //         FROM o_book
    //         WHERE x_status IN (1, 0)
    //         AND x_datein BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())";
    $sql = "SELECT COUNT(x_bookid) AS totalCheckIn
        FROM o_book
        WHERE x_status IN (1)
        AND x_datein = DATE_ADD(CURDATE(), INTERVAL 1 DAY)"; //offset +1 day due to webserver phpmyadmin is Yesterday date

    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the total number of bookings from the result
        $row = mysqli_fetch_assoc($result);
        $totalCheckIn = $row['totalCheckIn'];
        return $totalCheckIn;
    } else {
        // Query failed
        return false;
    }
}

function countCheckOut()
{
    global $con;

    // Query to count the total number of bookings - old
    // $sql = "SELECT COUNT(x_bookid) AS totalCheckOut
    //         FROM o_book
    //         WHERE x_status IN (1, 0)
    //         AND x_dateout BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())";

    $sql = "SELECT COUNT(x_bookid) AS totalCheckOut
            FROM o_book
            WHERE x_status IN (1)
            AND x_dateout = DATE_ADD(CURDATE(), INTERVAL 1 DAY)"; //offset +1 day due to webserver phpmyadmin is Yesterday date


    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the total number of bookings from the result
        $row = mysqli_fetch_assoc($result);
        $totalCheckOut = $row['totalCheckOut'];
        return $totalCheckOut;
    } else {
        // Query failed
        return false;
    }
}


function countStay()
{
    global $con;

    // Query to count the total number of bookings
    $sql = "SELECT COUNT(x_bookid) AS totalCheckOut
            FROM o_book
            WHERE x_status IN (1)
            AND x_dateout >= DATE_ADD(CURDATE(), INTERVAL 1 DAY);"; //offset +1 day due to webserver phpmyadmin is Yesterday date

    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the total number of bookings from the result
        $row = mysqli_fetch_assoc($result);
        $totalCheckOut = $row['totalCheckOut'];
        return $totalCheckOut;
    } else {
        // Query failed
        return false;
    }
}

function totalRevenueMonthly()
{
    global $con;

    // SQL query to calculate total revenue for the current month
    $sql = "SELECT SUM(x_totalfee) AS totalRevenue
                FROM o_book
                WHERE x_status = 1
                AND MONTH(x_createddate) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 DAY))"; //offset +1 day due to webserver phpmyadmin is Yesterday date

    // Execute the query
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Fetch the result row as an associative array
        $row = mysqli_fetch_assoc($result);

        // Get the total revenue
        $totalRevenue = $row['totalRevenue'];

        // Format the total revenue as currency style
        $formattedRevenue = number_format($totalRevenue, 2, '.', ',');

        // Return the formatted total revenue
        return $formattedRevenue;
    } else {
        // Handle query execution error
        return false;
    }

}

function totalRevenueDaily()
{
    global $con;

    // SQL query to calculate total revenue for the current month
    $sql = "SELECT SUM(x_totalfee) AS totalRevenue
                FROM o_book
                WHERE x_status = 1
                AND cast(x_createddate as date) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)"; //offset +1 day due to webserver phpmyadmin is Yesterday date

    // Execute the query
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Fetch the result row as an associative array
        $row = mysqli_fetch_assoc($result);

        // Get the total revenue
        $totalRevenue = $row['totalRevenue'];

        // Format the total revenue as currency style
        $formattedRevenue = number_format($totalRevenue, 2, '.', ',');

        // Return the formatted total revenue
        return $formattedRevenue;
    } else {
        // Handle query execution error
        return false;
    }
}

// Function to generate the progress bar HTML with room availability
function generateRoomAvailabilityProgressBar($totalRooms, $availableRooms)
{
    // Calculate the percentage
    $percentage = ($availableRooms / $totalRooms) * 100;

    // Set color based on the percentage
    $color = '';
    if ($percentage >= 70) {
        $color = 'bg-success'; // Green
    } elseif ($percentage >= 40) {
        $color = 'bg-info'; // Blue
    } elseif ($percentage >= 10) {
        $color = 'bg-primary'; // Orange
    } else {
        $color = 'bg-warning'; // Yellow
    }

    // Generate the progress bar HTML
    $progressBarHTML = '
    <div class="progress-card">
        <div class="d-flex justify-content-between mb-1">
            <span class="text-muted">Available Rooms (today)</span>
            <span class="text-muted fw-bold">' . $availableRooms . ' rooms / ' . $totalRooms . ' total rooms</span>
        </div>
        <div class="progress mb-2" style="height: 7px;">
            <div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $percentage . '%" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="' . $percentage . '%"></div>
        </div>
    </div>';

    return $progressBarHTML;
}
// Function to get total and available rooms from the database
function getRoomAvailabilityFromDatabase($con)
{
    // Query to get total and available rooms
    $query = "SELECT
                (
                    SELECT COUNT(*)
                    FROM o_room
                ) AS totalRooms,
                (
                    SELECT COUNT(*)
                    FROM o_book ob
                    RIGHT JOIN o_room oro ON ob.x_room = oro.x_roomid
                    WHERE ob.x_status IN (1) AND ob.x_datein = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
                ) AS bookedRoom,
                (
                    SELECT COUNT(*)
                    FROM o_room
                ) - (
                    SELECT COUNT(*)
                    FROM o_book ob
                    RIGHT JOIN o_room oro ON ob.x_room = oro.x_roomid
                    WHERE ob.x_status IN (1) AND ob.x_datein = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
                ) AS availableRooms;";
                //offset +1 day due to webserver phpmyadmin is Yesterday date
    // Execute the query
    $result = mysqli_query($con, $query);

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    return $row;
}

// Function to get total and available rooms from the database
function getRoomOccupiedFromDatabase($con)
{
    // Query to get total and available rooms
    $query = "SELECT
                (
                    SELECT COUNT(*)
                    FROM o_room
                ) AS totalRooms,
                (
                    SELECT COUNT(*)
                    FROM o_book ob
                    RIGHT JOIN o_room oro ON ob.x_room = oro.x_roomid
                    WHERE ob.x_status IN (1) AND ob.x_datein = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
                ) AS occupiedRooms;";
                ////offset +1 day due to webserver phpmyadmin is Yesterday date
    // Execute the query
    $result = mysqli_query($con, $query);

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    return $row;
}

// Function to generate the progress bar HTML with room availability
function generateRoomOccupiedProgressBar($totalRooms, $occupied)
{
    // Calculate the percentage
    $percentage = ($occupied / $totalRooms) * 100;

    // Determine the color based on the percentage
    $color = '';
    if ($percentage >= 70) {
        $color = 'bg-success'; // Green
    } elseif ($percentage >= 40) {
        $color = 'bg-info'; // Blue
    } elseif ($percentage >= 10) {
        $color = 'bg-primary'; // Orange
    } else {
        $color = 'bg-warning'; // Yellow
    }

    // Generate the progress bar HTML
    $progressBarHTML = '
    <div class="progress-card">
        <div class="d-flex justify-content-between mb-1">
            <span class="text-muted">Occupied Rooms (today)</span>
            <span class="text-muted fw-bold">' . $occupied . ' rooms / ' . $totalRooms . ' total rooms</span>
        </div>
        <div class="progress mb-2" style="height: 7px;">
            <div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $percentage . '%" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="' . $percentage . '%"></div>
        </div>
    </div>';

    return $progressBarHTML;
}
