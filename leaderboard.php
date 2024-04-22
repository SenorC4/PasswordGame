<?php
$conn = new mysqli("passwordgame.chckq2ucaegk.us-east-1.rds.amazonaws.com", "admin", "dUDjAaAoQ9TMhiGac4vhQhABrVe4SR", "prompts");

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// php to handle all of the rule divs and pull the data from database

// create query, pulls prompts from DB in reverse order 
$sql = "SELECT username, password_length FROM leaderboard ORDER BY password_length";

// save query result into $result
$result = $conn->query($sql);
$leaderboard = [];

while ($r = mysqli_fetch_assoc($result)) {
    $leaderboard[] = ["username" => $r["username"], "password_length" => $r["password_length"]];
}

header('Content-type: application/json');
echo json_encode($leaderboard);
// loop and echo the html with query result 
// uses RULE_NUM and RULE_DESC values in the database to build html identically to original index.html
