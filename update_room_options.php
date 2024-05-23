<?php
include 'dbconnect.php';

$checkinDate = $_GET['checkindate'];
$checkoutDate = $_GET['checkoutdate'];

$sql = "SELECT oro.*
        FROM o_room oro
        LEFT JOIN (
            SELECT DISTINCT x_room
            FROM o_book
            WHERE x_status IN (0,1,2)
              AND '$checkoutDate' >= x_datein
              AND '$checkinDate' <= x_dateout
        ) ob ON oro.x_roomid = ob.x_room
        WHERE ob.x_room IS NULL;";

$result = mysqli_query($con, $sql);

$options = "";
while ($row = mysqli_fetch_array($result)) {
    $options .= "<option value='" . $row['x_roomid'] . "'>" . $row['x_roomid'] . " - " . $row['x_roomtype'] . "</option>";
}
echo $options;
