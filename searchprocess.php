<?php
// (A) DATABASE CONFIG
define('DB_HOST', 'localhost');
define('DB_NAME', 'hrs');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// (B) CONNECT TO DATABASE
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
        DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (Exception $ex) {exit($ex->getMessage());}
$x_userclass = $_POST['x_userclass'];

if ($x_userclass === "0") {
    // (D) PDO1 QUERY
    $stmt = $pdo->prepare("SELECT * FROM o_book
          LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
          LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
          LEFT JOIN o_status ON o_book.x_status = o_status.x_id
    WHERE `x_bookid` LIKE ?");

    $stmt->execute(["%" . $_POST['search'] . "%"]);
    $results = $stmt->fetchAll();

}
 elseif ($x_userclass === "1") // CUSTOMER
{
// (C) SEARCH CUSTOMER WITH FID
//$stmt = $pdo->prepare("SELECT * FROM `o_book` WHERE `x_bookid` LIKE ? OR `x_room` LIKE ?");
    $stmt = $pdo->prepare("SELECT * FROM o_book
        LEFT JOIN o_user ON o_book.x_user = o_user.x_userid
        LEFT JOIN o_room ON o_book.x_room = o_room.x_roomid
        LEFT JOIN o_status ON o_book.x_status = o_status.x_id
        WHERE (`x_bookid` LIKE ?) AND o_user.x_userid = ?");
        $stmt->execute(["%" . $_POST['search'] . "%", $fid]);
        $results = $stmt->fetchAll();
} else {
    echo "User does not have the required class.";
    exit;
}
if (isset($_POST['ajax'])) {echo json_encode($results);}
