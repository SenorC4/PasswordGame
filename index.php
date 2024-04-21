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
   <script>
      $(document).ready(function() {
         // check after every input if the player has won
         $("#autoresizing").on("input", function() {
            if (win == true) {

               // get winning password
               var pass = $("#autoresizing").val();
               var lengthOfPass = this.value.length;

               // call insert.php file, passing through the winning password to be inserted into db
               $.ajax({
                  type: "POST",
                  url: "insert.php",
                  data: {
                     password: pass,
                     username: user,
                     length: lengthOfPass
                  },
                  success: function(result) {}
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

   <div class="rules" id="rules">
      <?php
      // php to handle all of the rule divs and pull the data from database

      // create query
      $sql = "SELECT title, info FROM prompts ORDER BY title DESC";

      // save query result into $result
      $result = $conn->query($sql);

      // loop and echo the html with query result 
      // uses RULE_NUM and RULE_DESC values in the database to build html identically to original index.html
      while ($row = $result->fetch_assoc()) {

         // rule bad
         echo "<div id=\"rule" . $row["title"] . '"class="rulebad" style="display: none">';
         echo "<span id=\"spanRule" . $row["title"] . '"class="topbad">';
         echo "<img id=\"imgRule" . $row["title"] . '"class="smallimg" src="images/x.png" alt="img">';
         echo "<div style=\"padding: 2px\">";
         echo "<p2>Rule " . $row["title"] . "</p2>";
         echo "</div>";
         echo "</span>";
         echo "<span class=\"bottom\">";
         echo "<p2>" . $row["info"] . "</p2>";
         echo "</span>";
         echo "</div>";
      }
      ?>
   </div>

   <!-- Various script elements -->
   <script type="text/javascript">
      var user;

      $("#button")
         .on("click", function() {
            const username = document.querySelector("#username");
            username.style.display = "none";
            const button = document.querySelector("#button");
            button.style.display = "none";


            const password = document.querySelector("#password");
            password.style.visibility = "visible";
            password.style.opacity = "1";

            user = $("#autoresizing2").val();
         });

      // text area height automatic adjuster based on input
      $("#autoresizing")
         .each(function() {
            this.setAttribute("style", "height:" + this.scrollHeight + "px;overflow-y:hidden;");
         })
         .on("input", function() {
            this.style.height = 0;
            this.style.height = this.scrollHeight + "px";
         });

      $("#autoresizing2")
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
      var rule6Done = false;
      var rule7Done = false;
      var rule8Done = false;
      var rule9Done = false;
      var rule10Done = false;

      // for checking at the end if all rules are enabled
      var rule1Active = false;
      var rule2Active = false;
      var rule3Active = false;
      var rule4Active = false;
      var rule5Active = false;
      var rule6Active = false;
      var rule7Active = false;
      var rule8Active = false;
      var rule9Active = false;
      var rule10Active = false;

      var win = false;

      // this section of code is run every time there is a new text value
      $("#autoresizing").on("input", function() {

         // update the character counter
         document.getElementById("count").innerHTML = this.value.length;

         // get text of textarea
         var text = $("#autoresizing").val();

         // declare textarea variable
         const rule1 = document.querySelector("#rule1");
         const spanrule1 = document.querySelector("#spanRule1");
         const imgrule1 = document.querySelector("#imgRule1");
         //const rule1good = document.querySelector("#rule1good");

         const rule2 = document.querySelector("#rule2");
         const spanrule2 = document.querySelector("#spanRule2");
         const imgrule2 = document.querySelector("#imgRule2");
         // const rule2good = document.querySelector("#rule2good");

         const rule3 = document.querySelector("#rule3");
         const spanrule3 = document.querySelector("#spanRule3");
         const imgrule3 = document.querySelector("#imgRule3");
         //const rule3good = document.querySelector("#rule3good");

         const rule4 = document.querySelector("#rule4");
         const spanrule4 = document.querySelector("#spanRule4");
         const imgrule4 = document.querySelector("#imgRule4");
         //const rule4good = document.querySelector("#rule4good");

         const rule5 = document.querySelector("#rule5");
         const spanrule5 = document.querySelector("#spanRule5");
         const imgrule5 = document.querySelector("#imgRule5");
         //const rule5good = document.querySelector("#rule5good");

         const rule6 = document.querySelector("#rule6");
         const spanrule6 = document.querySelector("#spanRule6");
         const imgrule6 = document.querySelector("#imgRule6");
         // const rule6good = document.querySelector("#rule6good");

         const rule7 = document.querySelector("#rule7");
         const spanrule7 = document.querySelector("#spanRule7");
         const imgrule7 = document.querySelector("#imgRule7");
         //const rule7good = document.querySelector("#rule7good");

         const rule8 = document.querySelector("#rule8");
         const spanrule8 = document.querySelector("#spanRule8");
         const imgrule8 = document.querySelector("#imgRule8");
         // const rule8good = document.querySelector("#rule8good");

         const rule9 = document.querySelector("#rule9");
         const spanrule9 = document.querySelector("#spanRule9");
         const imgrule9 = document.querySelector("#imgRule9");
         // const rule9good = document.querySelector("#rule9good");

         const rule10 = document.querySelector("#rule10");
         const spanrule10 = document.querySelector("#spanRule10");
         const imgrule10 = document.querySelector("#imgRule10");
         //  const rule10good = document.querySelector("#rule10good");

         rule1.style.display = "block";

         // rule 1 (we neeed to convert this so it pulls the rules from the database)
         if (text != null && text.length >= 8) {
            rule1.classList.remove('rulebad');
            rule1.classList.add('rulegood');
            spanrule1.classList.remove('topbad');
            spanrule1.classList.add('topgood');
            imgrule1.src = "images/check.png";

            //rule1good.style.display = "block";

            // display the next rule (because the rule we are in is true)
            rule2.style.display = "block";

            rule1Done = true;
            rule1Active = true;
         } else {
            rule1.style.display = "block";
            rule1.classList.remove('rulegood');
            rule1.classList.add('rulebad');
            spanrule1.classList.remove('topgood');
            spanrule1.classList.add('topbad');
            imgrule1.src = "images/x.png";
            //rule1good.style.display = "none";

            rule1Active = false;
         }

         // rule 2
         function hasNumber(myString) {
            return /\d/.test(myString);
         }

         if (hasNumber(text) && rule1Done) {
            rule2.classList.remove('rulebad');
            rule2.classList.add('rulegood');
            spanrule2.classList.remove('topbad');
            spanrule2.classList.add('topgood');
            imgrule2.src = "images/check.png";

            // display the next rule (because the rule we are in is true)
            rule3.style.display = "block";

            rule2Done = true;
            rule2Active = true;
         } else {
            //rule2good.style.display = "none";
            if (rule1Done == true) {
               rule2.style.display = "block";
               rule2.classList.remove('rulegood');
               rule2.classList.add('rulebad');
               spanrule2.classList.remove('topgood');
               spanrule2.classList.add('topbad');
               imgrule2.src = "images/x.png";
            }
            rule2Active = false;
         }

         // rule 3 (check if text contains an uppercase letter)
         function hasUpperCase(str) {
            return str !== str.toLowerCase();
         }

         if (hasUpperCase(text) && rule2Done) {
            rule3.classList.remove('rulebad');
            rule3.classList.add('rulegood');
            spanrule3.classList.remove('topbad');
            spanrule3.classList.add('topgood');
            imgrule3.src = "images/check.png";

            rule4.style.display = "block";

            rule3Done = true;
            rule3Active = true;
         } else {
            //rule3good.style.display = "none";
            if (rule2Done == true) {
               rule3.style.display = "block";
               rule3.classList.remove('rulegood');
               rule3.classList.add('rulebad');
               spanrule3.classList.remove('topgood');
               spanrule3.classList.add('topbad');
               imgrule3.src = "images/x.png";
            }
            rule3Active = false;
         }

         // rule 4 (check if a special character)
         function hasSpecial(myString) {
            return /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(myString);
         }
         if (hasSpecial(text) && rule3Done) {
            rule4.classList.remove('rulebad');
            rule4.classList.add('rulegood');
            spanrule4.classList.remove('topbad');
            spanrule4.classList.add('topgood');
            imgrule4.src = "images/check.png";

            rule5.style.display = "block";
            rule4Done = true;
            rule4Active = true;
         } else {
            if (rule3Done == true) {
               rule4.style.display = "block";
               rule4.classList.remove('rulegood');
               rule4.classList.add('rulebad');
               spanrule4.classList.remove('topgood');
               spanrule4.classList.add('topbad');
               imgrule4.src = "images/x.png";
            }
            rule4Active = false;
         }

         // rule 5 (check if a text contains plnu)
         let found = text.match(/plnu/i);

         if (found && rule4Done) {
            rule5.classList.remove('rulebad');
            rule5.classList.add('rulegood');
            spanrule5.classList.remove('topbad');
            spanrule5.classList.add('topgood');
            imgrule5.src = "images/check.png";

            rule6.style.display = "block";
            rule5Done = true;
            rule5Active = true;
         } else {
            //rule5good.style.display = "none";
            if (rule4Done == true) {
               rule5.style.display = "block";
               rule5.classList.remove('rulegood');
               rule5.classList.add('rulebad');
               spanrule5.classList.remove('topgood');
               spanrule5.classList.add('topbad');
               imgrule5.src = "images/x.png";
            }
            rule5Active = false;
         }

         // rule 6
         function hasMonths(myString) {
            return (/January|February|March|April|May|June|July|August|September|October|November|December/i).test(myString);
         }

         if (hasMonths(text) == true && rule5Done) {
            rule6.classList.remove('rulebad');
            rule6.classList.add('rulegood');
            spanrule6.classList.remove('topbad');
            spanrule6.classList.add('topgood');
            imgrule6.src = "images/check.png";

            rule7.style.display = "block";
            rule6Done = true;
            rule6Active = true;
         } else {
            //rule5good.style.display = "none";
            if (rule5Done == true) {
               rule6.style.display = "block";
               rule6.classList.remove('rulegood');
               rule6.classList.add('rulebad');
               spanrule6.classList.remove('topgood');
               spanrule6.classList.add('topbad');
               imgrule6.src = "images/x.png";
            }
            rule6Active = false;
         }

         // rule 7
         function hasBuilding(myString) {
            return (/Bond|Cabrillo|Hendricks|Klassen|Cooper|Cunningham|Fermanian|Goodwin|Greek|Smee|Flex|Nease|Nicholson|Wiley|Rohr|Ryan|Sator|Latter|Keller|Colt|Salomon|Brown|Mieras|Evans|Taylor|Starkey|Young/i).test(myString);
         }

         if (hasBuilding(text) == true && rule6Done) {
            rule7.classList.remove('rulebad');
            rule7.classList.add('rulegood');
            spanrule7.classList.remove('topbad');
            spanrule7.classList.add('topgood');
            imgrule7.src = "images/check.png";

            rule8.style.display = "block";
            rule7Done = true;
            rule7Active = true;
         } else {
            if (rule6Done == true) {
               rule7.style.display = "block";
               rule7.classList.remove('rulegood');
               rule7.classList.add('rulebad');
               spanrule7.classList.remove('topgood');
               spanrule7.classList.add('topbad');
               imgrule7.src = "images/x.png";
            }
            rule7Active = false;
         }

         // rule 8
         function hasFaculty(myString) {
            return (/Mood|Leih|Zack|Alcorn|Jimenez|Crockett|Crow|Havens|Triebold/i).test(myString);
         }

         if (hasFaculty(text) == true && rule7Done) {
            rule8.classList.remove('rulebad');
            rule8.classList.add('rulegood');
            spanrule8.classList.remove('topbad');
            spanrule8.classList.add('topgood');
            imgrule8.src = "images/check.png";

            rule9.style.display = "block";
            rule8Done = true;
            rule8Active = true;
         } else {
            if (rule7Done == true) {
               rule8.style.display = "block";
               rule8.classList.remove('rulegood');
               rule8.classList.add('rulebad');
               spanrule8.classList.remove('topgood');
               spanrule8.classList.add('topbad');
               imgrule8.src = "images/x.png";
            }
            rule8Active = false;
         }

         // rule 9
         function sum(str) {
            let nums = []
            let sum = 0

            for (let i = 0; i < str.length; i++) {
               if (!isNaN(parseInt(str[i]))) {
                  sum += parseInt(str[i])
               }
            }
            return sum
         }

         if ((sum(text) == 68) && rule8Done) {
            rule9.classList.remove('rulebad');
            rule9.classList.add('rulegood');
            spanrule9.classList.remove('topbad');
            spanrule9.classList.add('topgood');
            imgrule9.src = "images/check.png";

            //rule10.style.display = "block";
            rule9Done = true;
            rule9Active = true;
         } else {
            if (rule8Done == true) {
               rule9.style.display = "block";
               rule9.classList.remove('rulegood');
               rule9.classList.add('rulebad');
               spanrule9.classList.remove('topgood');
               spanrule9.classList.add('topbad');
               imgrule9.src = "images/x.png";
            }
            rule9Active = false;
         }

         // check if player has won
         if (rule1Done && rule2Done && rule3Done && rule4Done && rule5Done && rule6Done && rule7Done && rule8Done && rule9Done) {
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