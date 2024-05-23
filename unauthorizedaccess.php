<?php

include_once 'functions.php';

if (empty($_SESSION['x_userid'])) {
    header("Location: login.php");
}
$unauthToken = generateToken(32);
session_destroy();
header("Location: login.php?status=unauth&token=" . $unauthToken);
exit();
