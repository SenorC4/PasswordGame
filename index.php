<!-- 
Password Game Website Project

Tommy Teschner: HTML/JavaScript/UI Design (6 hours)
Josiah Gansky:
Luke LeCain:
Kyle Johnson: 

index.html
-->

<!-- For connecting to the DB using php -->
<?php
// connect to the db
$conn = new mysqli("passwordgame.cf66ggecobxs.us-east-1.rds.amazonaws.com", "passgameadmin", "VYysgdfgWWzvSzq82Ubq", "passwordgame");

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
   <script>
      $(document).ready(function() {
         // check after every input if the player has won
         $("textarea").on("input", function() {
            if (win == true) {
               // get winning password
               var text = $("textarea").val();

               // call insert.php file, passing through the winning password to be inserted into db
               $.ajax({
                  type: "POST",
                  url: "insert.php",
                  data: {
                     password: text
                  },
                  success: function(data) {}
               });
            }
         });
      });
   </script>
</head>

<body>
   <!-- for displaying the header -->
   <div class="passwordgame">
      <h1>* The Password Game</h1>
   </div>

   <!-- for displaying the text box-->
   <div class="textbox">
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

   <div class="rules" id="rules">
      <?php
      // php to handle all of the rule divs and pull the data from database

      // create query
      $sql = "SELECT RULE_NUM, RULE_DESC FROM RULES";

      // save query result into $result
      $result = $conn->query($sql);

      // loop and echo the html with query result 
      // uses RULE_NUM and RULE_DESC values in the database to build html identically to original index.html
      while ($row = $result->fetch_assoc()) {

         // rule bad
         echo "<div id=\"rule" . $row["RULE_NUM"] . "bad\" class=\"rulebad\" style=\"display: none\">";
         echo "<span class=\"topbad\">";
         echo "<img class=\"smallimg\" src=\"images/x.png\" alt=\"img\" />";
         echo "<div style=\"padding: 2px\">";
         echo "<p2>Rule " . $row["RULE_NUM"] . "</p2>";
         echo "</div>";
         echo "</span>";
         echo "<span class=\"bottom\">";
         echo "<p2>" . $row["RULE_DESC"] . "</p2>";
         echo "</span>";
         echo "</div>";

         // rule good
         echo "<div id=\"rule" . $row["RULE_NUM"] . "good\" class=\"rulegood\" style=\"display: none\">";
         echo "<span class=\"topgood\">";
         echo "<img class=\"smallimg\" src=\"images/check.png\" alt=\"img\" />";
         echo "<div style=\"padding: 2px\">";
         echo "<p2>Rule " . $row["RULE_NUM"] . "</p2>";
         echo "</div>";
         echo "</span>";
         echo "<span class=\"bottom\">";
         echo "<p2>" . $row["RULE_DESC"] . "</p2>";
         echo "</span>";
         echo "</div>";
      }
      ?>
   </div>

   <!-- Various script elements -->
   <script type="text/javascript">
      // text area height automatic adjuster based on input
      $("textarea")
         .each(function() {
            this.setAttribute("style", "height:" + this.scrollHeight + "px;overflow-y:hidden;");
         })
         .on("input", function() {
            this.style.height = 0;
            this.style.height = this.scrollHeight + "px";
         });

      // for checking if a rule has been completed once before or not
      var rule1Done = false;
      var rule2Done = false;
      var rule3Done = false;
      var rule4Done = false;
      var rule5Done = false;

      // for checking at the end if all rules are enabled
      var rule1Active = false;
      var rule2Active = false;
      var rule3Active = false;
      var rule4Active = false;
      var rule5Active = false;

      var win = false;

      // this section of code is run every time there is a new text value
      $("textarea").on("input", function() {
         // update the character counter
         document.getElementById("count").innerHTML = this.value.length;

         // get text of textarea
         var text = $("textarea").val();

         // declare textarea variable
         const rule1bad = document.querySelector("#rule1bad");
         const rule1good = document.querySelector("#rule1good");

         const rule2bad = document.querySelector("#rule2bad");
         const rule2good = document.querySelector("#rule2good");

         const rule3bad = document.querySelector("#rule3bad");
         const rule3good = document.querySelector("#rule3good");

         const rule4bad = document.querySelector("#rule4bad");
         const rule4good = document.querySelector("#rule4good");

         const rule5bad = document.querySelector("#rule5bad");
         const rule5good = document.querySelector("#rule5good");

         rule1bad.style.display = "block";

         // rule 1 (we neeed to convert this so it pulls the rules from the database)
         if (text != null && text.length > 4) {
            rule1bad.style.display = "none";
            rule1good.style.display = "block";

            // display the next rule (because the rule we are in is true)
            rule2bad.style.display = "block";

            rule1Done = true;
            rule1Active = true;
         } else {
            rule1bad.style.display = "block";
            rule1good.style.display = "none";

            rule1Active = false;
         }

         // rule 2
         function hasNumber(myString) {
            return /\d/.test(myString);
         }

         if (hasNumber(text) && rule1Done) {
            rule2bad.style.display = "none";
            rule2good.style.display = "block";

            // display the next rule (because the rule we are in is true)
            rule3bad.style.display = "block";

            rule2Done = true;
            rule2Active = true;
         } else {
            rule2good.style.display = "none";
            if (rule1Done == true) {
               rule2bad.style.display = "block";
            }
            rule2Active = false;
         }

         // rule 3 (check if text contains an uppercase letter)
         function hasUpperCase(str) {
            return str !== str.toLowerCase();
         }

         if (hasUpperCase(text) && rule2Done) {
            rule3bad.style.display = "none";
            rule3good.style.display = "block";

            rule4bad.style.display = "block";

            rule3Done = true;
            rule3Active = true;
         } else {
            rule3good.style.display = "none";
            if (rule2Done == true) {
               rule3bad.style.display = "block";
            }
            rule3Active = false;
         }

         // rule 4 (check if a special character)
         function hasSpecial(myString) {
            return /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(myString);
         }

         if (hasSpecial(text) && rule3Done) {
            rule4bad.style.display = "none";
            rule4good.style.display = "block";

            rule5bad.style.display = "block";
            rule4Done = true;
            rule4Active = true;
         } else {
            rule4good.style.display = "none";
            if (rule3Done == true) {
               rule4bad.style.display = "block";
            }
            rule4Active = false;
         }

         // rule 5 (check if a text contains duck)
         let found = text.match(/duck/i);

         if (found && rule4Done) {
            rule5bad.style.display = "none";
            rule5good.style.display = "block";

            //rule6bad.style.display = "block";
            rule5Done = true;
            rule5Active = true;
         } else {
            rule5good.style.display = "none";
            if (rule4Done == true) {
               rule5bad.style.display = "block";
            }
            rule5Active = false;
         }

         // check if player has won
         if (rule1Active == true && rule2Active == true && rule3Active == true && rule4Active == true && rule5Active == true) {
            const rules = document.querySelector("#rules");
            rules.style.display = "none";

            const congrats = document.querySelector("#congrats");
            congrats.style.display = "block";

            document.getElementById("congrats").innerHTML = "<strong>Congratulations!</strong> <br />You have chosen a valid password with " + this.value.length + " characters.<br />Your password was written to the database!";
            document.getElementById("autoresizing").disabled = true;

            win = true;

         }
      });
   </script>
</body>

</html>