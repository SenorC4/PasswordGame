<!-- 
Password Game Website Project

insert.php
-->

<?php
// connect to db
$conn = new mysqli("passwordgame.cf66ggecobxs.us-east-1.rds.amazonaws.com", "passgameadmin", "VYysgdfgWWzvSzq82Ubq", "passwordgame");

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get the winning password from ajax call
$password =  $_POST['password'];

// create insert query
$sql = "INSERT INTO WINNING_PASSWORDS  VALUES ('$password')";

// query it
mysqli_query($conn, $sql);

// close connection
mysqli_close($conn);
