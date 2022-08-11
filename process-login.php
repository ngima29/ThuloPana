<?php
require_once("includes/dbcon.rec.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $email = $_POST['username'];
     $username = $_POST['username'];
     $password = md5($_POST['password']);

     $query = "SELECT `uid`, `username`, `email` FROM user WHERE email=:email AND password=:pwd";
     $stmt = $pdo->prepare($query);
     $stmt->bindParam(':email', $email);
     $stmt->bindParam(':pwd', $password);
     $stmt->execute();
     $user = $stmt->fetch();

     if (!empty($user)) {
          $username = $user['username'];
          $uid = $user['uid'];
          $_SESSION['logged_user'] = $username;
          $_SESSION['uid'] = $uid;
          $email = $user['email'];
          $q = "SELECT * FROM user u LEFT JOIN role r ON u.role = r.rid WHERE u.email = :email";
          $stmt = $pdo->prepare($q);
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          $result = $stmt->fetch();
          $role = $result['role'];
          $_SESSION['role'] = $role;
          if ($result['role'] === 'admin') {
               header('location:admin/dashboard.php');
          } else if ($result['role'] === "seller") {
               header('location:dashboard.php?id=' . $user['uid']);
          } else {
               header('location:index.php');
          }
     } else {
          echo '<h2>Invalid Email or password !!! Try again !!!</h2>';
          header('Refresh: 1; URL = login.php');
     }
}
