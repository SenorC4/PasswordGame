$(document).ready(function () {
   // check after every input if the player has won
   $("#confirmbutton").on("click", function () {
      if (win == true) {
         // get winning password
         var pass = $("#autoresizing").val();
         var lengthOfPass = document.getElementById("autoresizing").value.length;

         // call insert.php file, passing through the winning password to be inserted into db
         $.ajax({
            type: "POST",
            url: "insert.php",
            data: {
               username: user,
               length: lengthOfPass,
            },
            success: function (result) {
               $.getJSON("leaderboard.php", function (filler) {
                  leaderboardJSON = filler;
                  setLeaderboard();
               });
            },
         });
      }
   });
});
