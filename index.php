<!-- 
Password Game Website Project

Tommy Teschner: HTML/JavaScript/UI Design (6 hours)
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

   <!-- Various script elements -->
   <script type="text/javascript">
      // duck eats his food every 25 seconds
      duckEating = setInterval(function() {
         if (rule14Active == true) {


            var duckFood1 = "🌿";
            var duckFood2 = "🐛";
            var duckFood3 = "🐸";
            var duck = "🦆";

            var oldText = document.getElementById('autoresizing').value;
            var newText;

            newText = document.getElementById('autoresizing').value = document.getElementById('autoresizing').value.replace(duckFood1, "");;

            if (oldText != newText) {

               // check if food left, if no food left, you lose the game
               if ((/🌿🦆|🐛🦆|🐸🦆/).test(newText) == false) {
                  lose();
                  clearInterval(duckEating);
               }


               return;
            }

            newText = document.getElementById('autoresizing').value = document.getElementById('autoresizing').value.replace(duckFood2, "");;

            if (oldText != newText) {

               // check if food left, if no food left, you lose the game
               if ((/🌿🦆|🐛🦆|🐸🦆/).test(newText) == false) {
                  lose();
                  clearInterval(duckEating);
               }
               return;
            }

            newText = document.getElementById('autoresizing').value = document.getElementById('autoresizing').value.replace(duckFood3, "");;

            if (oldText != newText) {

               // check if food left, if no food left, you lose the game
               if ((/🌿🦆|🐛🦆|🐸🦆/).test(newText) == false) {
                  lose();
                  clearInterval(duckEating);
               }
               return;
            }



         }
      }, 5000); // Wait 5 seconds before eating again

      function lose() {
         //Clears screen
         const rules = document.querySelector("#rules");
         rules.style.display = "none";

         //Displays congratulations banner 
         const lose = document.querySelector("#lose");
         lose.style.display = "block";
         document.getElementById("lose").innerHTML = "<strong>You Lose!</strong> <br />Your duck ate all of its food.";
         document.getElementById("autoresizing").disabled = true;
      }

      var user;

      //Sets password box to not be visible until button is pressed
      const password = document.querySelector("#password");
      password.style.visibility = "none";

      //Submit button for username 
      $("#button")
         .on("click", function() {

            //removes username and button from screen
            const username = document.querySelector("#username");
            username.style.display = "none";
            const button = document.querySelector("#button");
            button.style.display = "none";

            //Sets password box to visible again 
            password.style.visibility = "visible";
            password.style.opacity = "1";
            user = $("#autoresizing2").val();
         });

      // text area height automatic adjuster based on input for username and password boxes 
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
      var rule11Done = false;
      var rule12Done = false;
      var rule13Done = false;
      var rule14Done = false;
      var rule15Done = false;

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
      var rule11Active = false;
      var rule12Active = false;
      var rule13Active = false;
      var rule14Active = false;
      var rule15Active = false;

      var win = false;

      // declare textarea variable so we can change them later in the code 
      const rule1 = document.querySelector("#rule1");
      const spanrule1 = document.querySelector("#spanRule1");
      const imgrule1 = document.querySelector("#imgRule1");

      const rule2 = document.querySelector("#rule2");
      const spanrule2 = document.querySelector("#spanRule2");
      const imgrule2 = document.querySelector("#imgRule2");

      const rule3 = document.querySelector("#rule3");
      const spanrule3 = document.querySelector("#spanRule3");
      const imgrule3 = document.querySelector("#imgRule3");

      const rule4 = document.querySelector("#rule4");
      const spanrule4 = document.querySelector("#spanRule4");
      const imgrule4 = document.querySelector("#imgRule4");

      const rule5 = document.querySelector("#rule5");
      const spanrule5 = document.querySelector("#spanRule5");
      const imgrule5 = document.querySelector("#imgRule5");

      const rule6 = document.querySelector("#rule6");
      const spanrule6 = document.querySelector("#spanRule6");
      const imgrule6 = document.querySelector("#imgRule6");

      const rule7 = document.querySelector("#rule7");
      const spanrule7 = document.querySelector("#spanRule7");
      const imgrule7 = document.querySelector("#imgRule7");

      const rule8 = document.querySelector("#rule8");
      const spanrule8 = document.querySelector("#spanRule8");
      const imgrule8 = document.querySelector("#imgRule8");

      const rule9 = document.querySelector("#rule9");
      const spanrule9 = document.querySelector("#spanRule9");
      const imgrule9 = document.querySelector("#imgRule9");

      const rule10 = document.querySelector("#rule10");
      const spanrule10 = document.querySelector("#spanRule10");
      const imgrule10 = document.querySelector("#imgRule10");

      const rule11 = document.querySelector("#rule11");
      const spanrule11 = document.querySelector("#spanRule11");
      const imgrule11 = document.querySelector("#imgRule11");

      const rule12 = document.querySelector("#rule12");
      const spanrule12 = document.querySelector("#spanRule12");
      const imgrule12 = document.querySelector("#imgRule12");

      const rule13 = document.querySelector("#rule13");
      const spanrule13 = document.querySelector("#spanRule13");
      const imgrule13 = document.querySelector("#imgRule13");

      const rule14 = document.querySelector("#rule14");
      const spanrule14 = document.querySelector("#spanRule14");
      const imgrule14 = document.querySelector("#imgRule14");

      const rule15 = document.querySelector("#rule15");
      const spanrule15 = document.querySelector("#spanRule15");
      const imgrule15 = document.querySelector("#imgRule15");

      //Random captcha
      const captchaID = Math.floor(Math.random() * 9) + 1;

      //Captcha anwsers 
      const captchaAns = [
         ["laughter.", "tackled"],
         ["and", "batervan"],
         ["huntress", "participated"],
         ["annoyance", "Oct"],
         ["0-5-0", "Hassam"],
         ["reign", "eveloost"],
         ["Levelers", "critics"],
         ["trieste", "modern-day"],
         ["fiery", "Church"],
         ["olcott", "have"]
      ];

      //Sets random captcha image 
      document.querySelector("#ruleimage10").src = "captchas/" + captchaID + "captcha.jpg";

      //painting anwsers 
      const paintingAns = [
         ["mona lisa"],
         ["Girl with a Pearl Earring"],
         ["Starry Night"]
      ];

      //Random painting
      const paintingID = Math.floor(Math.random() * 3) + 1;

      //Sets random painting image 
      document.querySelector("#ruleimage13").src = "images/" + paintingID + "painting.png";



      //president anwsers 
      const presidentAns = [
         ["george washington"],
         ["richard nixon"],
         ["thomas jefferson"],
         ["abraham lincoln"],
         ["barack obama"]
      ];

      //Random president
      const presidentID = Math.floor(Math.random() * 5) + 1;

      //Sets random president image 
      document.querySelector("#ruleimage15").src = "images/" + presidentID + "president.png";

      // this section of code is run every time there is a new text value
      $("#autoresizing").on("input", function() {

         // update the character counter
         document.getElementById("count").innerHTML = this.value.length;

         // get text of textarea
         var text = $("#autoresizing").val();

         //Displays the first rule 
         rule1.style.display = "block";

         // rule 1, checks if the password is longer than 8 characters 
         if (text != null && text.length >= 8) {

            //Changes CSS class to show good rule 
            rule1.classList.remove('rulebad');
            rule1.classList.add('rulegood');
            spanrule1.classList.remove('topbad');
            spanrule1.classList.add('topgood');
            imgrule1.src = "images/check.png";

            // display the next rule (because the rule we are in is true)
            rule2.style.display = "block";

            //Sets the rule to be done 
            rule1Done = true;
            rule1Active = true;
            rule1.style.order = "1";
         } else {

            //Changes css class to show bad rule 
            rule1.style.display = "block";
            rule1.classList.remove('rulegood');
            rule1.classList.add('rulebad');
            spanrule1.classList.remove('topgood');
            spanrule1.classList.add('topbad');
            imgrule1.src = "images/x.png";

            rule1.style.order = "";

            //Sets the rule to not be done 
            rule1Active = false;
         }

         // rule 2, checks if the user has a number in their password 
         function hasNumber(myString) {
            return /\d/.test(myString);
         }

         //If the user has a number and has completed rule 1 
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

            rule2.style.order = "1";
         } else {

            if (rule1Done == true) {
               rule2.style.display = "block";
               rule2.classList.remove('rulegood');
               rule2.classList.add('rulebad');
               spanrule2.classList.remove('topgood');
               spanrule2.classList.add('topbad');
               imgrule2.src = "images/x.png";
            }
            rule2Active = false;
            rule2.style.order = "";
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
            rule3.style.order = "1";
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
            rule3.style.order = "";
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
            rule4.style.order = "1";
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
            rule4.style.order = "";
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
            rule5.style.order = "1";
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
            rule5.style.order = "";
         }

         // rule 6, checks if the password contains a month 
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
            rule6.style.order = "1";
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
            rule6.style.order = "";
         }

         // rule 7, checks if the user has the name of a location in PLNU 
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
            rule7.style.order = "1";
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
            rule7.style.order = "";
         }

         // rule 8, checks if the user has a faculty name 
         function hasFaculty(myString) {
            return (/Mood|Leih|Jimenez/i).test(myString);
         }

         if (hasFaculty(text) && rule7Done) {
            rule8.classList.remove('rulebad');
            rule8.classList.add('rulegood');
            spanrule8.classList.remove('topbad');
            spanrule8.classList.add('topgood');
            imgrule8.src = "images/check.png";

            rule9.style.display = "block";
            rule8Done = true;
            rule8Active = true;
            rule8.style.order = "1";
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
            rule8.style.order = "";
         }

         // rule 9, checks if the password adds up to 68 
         function sum(str) {
            let nums = []
            let sum = 0;

            for (let i = 0; i < str.length; i++) {
               if (!isNaN(parseInt(str[i]))) {
                  sum += parseInt(str[i])
               }
            }
            return sum;
         }

         if ((sum(text) == 30) && rule8Done) {
            rule9.classList.remove('rulebad');
            rule9.classList.add('rulegood');
            spanrule9.classList.remove('topbad');
            spanrule9.classList.add('topgood');
            imgrule9.src = "images/check.png";

            rule10.style.display = "block";

            rule9Done = true;
            rule9Active = true;
            rule9.style.order = "1";
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
            rule9.style.order = "";
         }

         // rule 10 captcha (case sensitive)
         function checkCaptcha() {
            var lowerText = text.toLowerCase();
            var lowerCap1 = captchaAns[captchaID - 1][0];
            var lowerCap2 = captchaAns[captchaID - 1][1];

            return (text.includes(lowerCap1) && text.includes(lowerCap2));
         }

         if (checkCaptcha() && rule9Done) {
            rule10.classList.remove('rulebad');
            rule10.classList.add('rulegood');
            spanrule10.classList.remove('topbad');
            spanrule10.classList.add('topgood');
            imgrule10.src = "images/check.png";

            rule11.style.display = "block";

            rule10Done = true;
            rule10Active = true;
            rule10.style.order = "1";
         } else {
            if (rule9Done == true) {
               rule10.style.display = "block";
               rule10.classList.remove('rulegood');
               rule10.classList.add('rulebad');
               spanrule10.classList.remove('topgood');
               spanrule10.classList.add('topbad');
               imgrule10.src = "images/x.png";
            }
            rule10Active = false;
            rule10.style.order = "";
         }

         // rule 11 duck emoji
         function hasDuck(myString) {
            return (/🦆/i).test(myString);
         }

         if (hasDuck(text) == true && rule10Done) {
            rule11.classList.remove('rulebad');
            rule11.classList.add('rulegood');
            spanrule11.classList.remove('topbad');
            spanrule11.classList.add('topgood');
            imgrule11.src = "images/check.png";

            rule12.style.display = "block";

            rule11Done = true;
            rule11Active = true;
            rule11.style.order = "1";
         } else {
            if (rule10Done == true) {
               rule11.style.display = "block";
               rule11.classList.remove('rulegood');
               rule11.classList.add('rulebad');
               spanrule11.classList.remove('topgood');
               spanrule11.classList.add('topbad');
               imgrule11.src = "images/x.png";
            }
            rule11Active = false;
            rule11.style.order = "";
         }

         // rule 12 diameter of earth
         function hasDiameter(myString) {
            return (/7926/).test(myString);
         }

         if (hasDiameter(text) == true && rule11Done) {
            rule12.classList.remove('rulebad');
            rule12.classList.add('rulegood');
            spanrule12.classList.remove('topbad');
            spanrule12.classList.add('topgood');
            imgrule12.src = "images/check.png";

            rule13.style.display = "block";

            rule12Done = true;
            rule12Active = true;
            rule12.style.order = "1";
         } else {
            if (rule11Done == true) {
               rule12.style.display = "block";
               rule12.classList.remove('rulegood');
               rule12.classList.add('rulebad');
               spanrule12.classList.remove('topgood');
               spanrule12.classList.add('topbad');
               imgrule12.src = "images/x.png";
            }
            rule12Active = false;
            rule12.style.order = "";
         }

         // rule 13 painting
         function checkPainting() {
            var lowerText = text.toLowerCase();
            var lowerCap1 = paintingAns[paintingID - 1][0].toLowerCase();

            return (lowerText.includes(lowerCap1));
         }

         if (checkPainting() == true && rule12Done) {
            rule13.classList.remove('rulebad');
            rule13.classList.add('rulegood');
            spanrule13.classList.remove('topbad');
            spanrule13.classList.add('topgood');
            imgrule13.src = "images/check.png";

            rule14.style.display = "block";

            rule13Done = true;
            rule13Active = true;
            rule13.style.order = "1";
         } else {
            if (rule12Done == true) {
               rule13.style.display = "block";
               rule13.classList.remove('rulegood');
               rule13.classList.add('rulebad');
               spanrule13.classList.remove('topgood');
               spanrule13.classList.add('topbad');
               imgrule13.src = "images/x.png";
            }
            rule13Active = false;
            rule13.style.order = "";
         }

         // rule 14 keep duck fed
         function checkFed(myString) {
            return (/🌿🦆/i).test(myString) || (/🐛🦆/i).test(myString) || (/🐸🦆/i).test(myString);
         }

         if (checkFed(text) == true && rule13Done) {
            rule14.classList.remove('rulebad');
            rule14.classList.add('rulegood');
            spanrule14.classList.remove('topbad');
            spanrule14.classList.add('topgood');
            imgrule14.src = "images/check.png";

            rule15.style.display = "block";

            rule14Done = true;
            rule14Active = true;
            rule14.style.order = "1";
         } else {
            if (rule13Done == true) {
               rule14.style.display = "block";
               rule14.classList.remove('rulegood');
               rule14.classList.add('rulebad');
               spanrule14.classList.remove('topgood');
               spanrule14.classList.add('topbad');
               imgrule14.src = "images/x.png";
            }
            rule14Active = false;
            rule14.style.order = "";
         }

         // rule 15 president (case insensitive)
         function checkPresident() {
            var lowerText = text.toLowerCase();
            var lowerCap1 = presidentAns[presidentID - 1][0].toLowerCase();

            return (lowerText.includes(lowerCap1));
         }

         if (checkPresident() == true && rule14Done) {
            rule15.classList.remove('rulebad');
            rule15.classList.add('rulegood');
            spanrule15.classList.remove('topbad');
            spanrule15.classList.add('topgood');
            imgrule15.src = "images/check.png";

            //rule16.style.display = "block";

            rule15Done = true;
            rule15Active = true;
            rule15.style.order = "1";
         } else {
            if (rule14Done == true) {
               rule15.style.display = "block";
               rule15.classList.remove('rulegood');
               rule15.classList.add('rulebad');
               spanrule15.classList.remove('topgood');
               spanrule15.classList.add('topbad');
               imgrule15.src = "images/x.png";
            }
            rule15Active = false;
            rule15.style.order = "";
         }

         // check if player has won
         if (rule1Active && rule2Active && rule3Active && rule4Active && rule5Active && rule6Active && rule7Active && rule8Active && rule9Active && rule10Active && rule11Active && rule12Active && rule13Active && rule14Active && rule15Active) {

            //Clears screen
            const rules = document.querySelector("#rules");
            rules.style.display = "none";

            //Displays congratulations banner 
            const congrats = document.querySelector("#congrats");
            congrats.style.display = "block";
            document.getElementById("congrats").innerHTML = "<strong>Congratulations!</strong> <br />You have chosen a valid password with " + this.value.length + " characters.<br />Your password was written to the database!";
            document.getElementById("autoresizing").disabled = true;

            //Sets win to be true 
            win = true;

            clearInterval(duckEating);
         }

      });
   </script>

</body>

</html>