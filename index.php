<!-- 
Password Game Website Project

Tommy Teschner: HTML/JavaScript/UI Design (20 hours)
Josiah Gansky: DB/Prompt Integration (6 hours)
Luke LeCain: 
Kyle Johnson: 

index.html
-->

<!-- For connecting to the DB using php -->
<?php
// connect to the db
$conn = new mysqli("passwordgame.chckq2ucaegk.us-east-1.rds.amazonaws.com", "admin", "dUDjAaAoQ9TMhiGac4vhQhABrVe4SR", "prompts");

// check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <!-- set title -->
   <title>Password Game</title>

   <!-- set favicon -->
   <link rel="icon" type="image/x-icon" href="images/password.png" />

   <!-- get various fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link href="https://fonts.googleapis.com/css2?family=Gideon+Roman&display=swap" rel="stylesheet" />

   <!-- define .css file to be used in the html page -->
   <link rel="stylesheet" href="css/main.css" />

   <!-- jquery -->
   <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

   <!-- This script writes the winning password to the database using ajax -->
   <script src="passToDB.js"></script>
</head>

<body>
   <!-- for displaying the header -->
   <div class="passwordgame">
      <h1>* The Password Game</h1>
   </div>

   <!-- for displaying the text box-->
   <div id="username" class="textbox">
      <label for="autoresizing2">
         <p>Please choose a username</p>
      </label>
      <textarea type="text" id="autoresizing2"></textarea>
   </div>

   <button class="button" id="button">
      <p>Continue</p>
   </button>

   <!-- for displaying the text box-->
   <div id="password" class="textbox">
      <label for="autoresizing">
         <p>Please choose a password</p>
      </label>
      <textarea type="text" id="autoresizing"></textarea>
   </div>

   <!-- for displaying the character counter-->
   <div class="textbox">
      <p1 id="count"></p1>
   </div>

   <!-- for displaying the congratsulations menu -->
   <div id="congrats" style="display: none"></div>

   <!-- for displaying the lose menu -->
   <div id="lose" style="display: none"></div>

   <div class="rules" id="rules">
      <?php
      // php to handle all of the rule divs and pull the data from database

      // create query, pulls prompts from DB in reverse order 
      $sql = "SELECT title, info, image FROM prompts ORDER BY title DESC";

      // save query result into $result
      $result = $conn->query($sql);

      // loop and echo the html with query result 
      // uses RULE_NUM and RULE_DESC values in the database to build html identically to original index.html
      while ($row = $result->fetch_assoc()) {

         // rule blocks
         echo "<div id=\"rule" . $row["title"] . '"class="rulebad" style="display: none">';
         echo "<span id=\"spanRule" . $row["title"] . '"class="topbad">';
         echo "<img id=\"imgRule" . $row["title"] . '"class="smallimg" src="images/x.png" alt="img">';
         echo "<div style=\"padding: 2px\">";
         echo "<p2>Rule " . $row["title"] . "</p2>";
         echo "</div>";
         echo "</span>";
         echo "<span class=\"bottom\">";
         echo "<p2>" . $row["info"] . "</p2>";

         // if image
         if ($row["image"] != NULL) {
            echo "<img id=\"ruleimage" . $row["title"] . "\" src=\"" . $row["image"] . "\"width = 100% height = 100%>";
         }
         if ($row["title"] == 14) {
            echo "<p2>Feed your duck with the 🌿, 🐛, or 🐸 emojis.</p2>";
         }

         echo "</span>";
         echo "</div>";
      }
      ?>
   </div>

   <!-- for displaying the text box-->
   <div id="confirm" class="textbox">
      <label for="autoresizing3">
         <p>Please confirm your password</p>
      </label>
      <textarea type="text" id="autoresizing3"></textarea>
   </div>

   <div style="padding-bottom: 80px">
      <button id="confirmbutton" style="display: none">
         <p>Confirm</p>
      </button>
   </div>
   <!-- Various script elements -->
   <script type="text/javascript" src="passwordChecker.js"></script>

</body>

</html>