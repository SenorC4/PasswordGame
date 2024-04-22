<!-- 
Password Game Website Project

insert.php
-->

<?php

// connect to db
$conn = new mysqli("passwordgame.chckq2ucaegk.us-east-1.rds.amazonaws.com", "admin", "dUDjAaAoQ9TMhiGac4vhQhABrVe4SR", "prompts");

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get the winning password from ajax call
$username = $_POST['username'];
$length = $_POST['length'];

// create insert query

$sql = "INSERT INTO leaderboard  VALUES ('$username', $length)";

$conn->query($sql);

// close connection
mysqli_close($conn);
