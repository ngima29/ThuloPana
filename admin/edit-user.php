<?php
require_once("../includes/dbcon.rec.php");
require_once("includes/auth.php");
?>
<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/head.inc.php"); ?>
</head>

<body>
     <?php include_once("includes/navbar.inc.php") ?>
     <?php
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $uid = $_POST['uid'];
          $username = $_POST['username'];
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $role = $_POST['role'];
          $pass = $_POST['password'];
          $password = md5($pass);
          if ($pass == '') {
               $query = "UPDATE `user` SET `username`=:username, `email`=:email, `phone`=:phone, `role`=:roles, `updated_at`= now() WHERE `uid`=:uid";
          } else {
               $query = "UPDATE `user` SET `username`=:username, `email`=:email, `phone`=:phone, `role`=:roles, `password`=:pwd, `updated_at` = now() WHERE `uid`=:uid";
          }

          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':uid', $uid);
          $stmt->bindParam(':username', $username);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':phone', $phone);
          $stmt->bindParam(':roles', $role);

          if ($pass != '') {
               $stmt->bindParam(':pwd', $password);
          }

          $stmt->execute();

          echo '<h2>User Updated Successfully</h2>';
          header('Refresh: 1; URL = dashboard.php');
     } else {
          if (isset($_GET['id']) && !empty($_GET['id'])) {
               $uid = $_GET['id'];
               $query = "SELECT * FROM user WHERE `uid`=:id";
               $stmt = $pdo->prepare($query);
               $stmt->bindParam(':id', $uid);
               $stmt->execute();
               $user = $stmt->fetch();
               if (!$user) {
                    echo '<h2>No user found with given id</h2>';
               } else {
                    $q = "SELECT r.rid, r.role FROM user u LEFT JOIN role r ON u.role = r.rid WHERE u.uid = :id";
                    $stmt = $pdo->prepare($q);
                    $stmt->bindParam(':id', $user['uid']);
                    $stmt->execute();
                    $role = $stmt->fetch();
     ?>
                    <div class="login">
                         <form class="login__card" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                              <div class="form__heading">
                                   <h2 class="card__heading">Edit User Of</h2>
                                   <p class="card__subheading">
                                        <a href="../index.php"> ThuloPana </a>
                                   </p>
                              </div>
                              <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>" />
                              <div class="input__group">
                                   <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z" />
                                   </svg>
                                   <input class="input-field" type="text" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required />
                              </div>
                              <div class="input__group">
                                   <svg style="width: 24px; height: 24px" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" />
                                   </svg>
                                   <input class="input-field" type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required />
                              </div>
                              <div class="input__group">
                                   <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M17,19H7V5H17M17,1H7C5.89,1 5,1.89 5,3V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V3C19,1.89 18.1,1 17,1Z" />
                                   </svg>
                                   <input class="input-field" type="text" maxlength="10" name="phone" placeholder="Phone Number" value="<?php echo $user['phone']; ?>" required />
                              </div>
                              <div class="input__group">
                                   <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M5,9.5L7.5,14H2.5L5,9.5M3,4H7V8H3V4M5,20A2,2 0 0,0 7,18A2,2 0 0,0 5,16A2,2 0 0,0 3,18A2,2 0 0,0 5,20M9,5V7H21V5H9M9,19H21V17H9V19M9,13H21V11H9V13Z" />
                                   </svg>
                                   <select class="input-field" name="role" id="role" required>
                                        <option value="<?php echo $role['rid'] ?>" selected disabled hidden> <?php echo $role['role']; ?> </option>
                                        <option value="1"> Admin </option>
                                        <option value="2"> Buyer </option>
                                        <option value="3"> Seller </option>
                                   </select>
                              </div>
                              <div class="input__group">
                                   <svg class="icon" style="width: 24px; height: 24px" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                                   </svg>
                                   <input class="input-field" type="text" name="password" placeholder="Password" />
                              </div>

                              <input type="submit" class="btn btn-all register_btn" value="Update">
                              <input type="reset" class="btn btn-all register_btn" value="Reset">
                              <input type="button" class="btn btn-all register_btn" value="Cancel" onclick="return cancel();">
                         </form>
                    </div>
     <?php
               }
          } else {
               echo '<h2>No record specified to update.</h2>';
          }
     }
     ?>
</body>
<!-- custom script -->
<script>
     function cancel() {
          window.location.assign('dashboard.php');
     }
</script>

</html>