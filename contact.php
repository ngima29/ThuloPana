<?php
require('includes/dbcon.rec.php');
?>
<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/head.inc.php"); ?>
     <style>
          .detail,
          h2 {
               color: #fff;
          }

          .detail a {
               color: #fff;
          }

          .detail a:hover {
               color: #a30810;
          }
     </style>
</head>

<body>
     <?php include_once("includes/navbar.inc.php"); ?>
     <div class="login">
          <div class="login__card">
               <h2>Admin Details</h2>
               <hr>
               <br>
               <p class="detail"><span> Name: </span> Sajan Kc </p>
               <p class="detail"><span> Email: </span><a href="mailto:sajanofficial123@gmail.com"> sajanofficial123@gmail.com </a></p>
               <br>
               <p class="detail"><span> Name: </span> Ngima Sherpa </p>
               <p class="detail"><span> Email: </span><a href="mailto:ngima.sherpa35@gmail.com"> ngima.sherpa35@gmail.com </a></p>
          </div>
     </div>
</body>

</html>