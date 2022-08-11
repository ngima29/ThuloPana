<?php
require_once("includes/dbcon.rec.php");
require_once("includes/auth.php");
?>
<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/head.inc.php"); ?>
</head>

<body>
     <?php include_once("includes/navbar.inc.php") ?>
     <div class="container seller">
          <h1>Seller Details</h1>
          <div class="seller__info">
               <?php
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
               ?>
                         <ul class="heading__info-list">
                              <li> <span> ID: </span> <?php echo $user['uid']; ?> </li>
                              <li> <span> Name: </span> <?php echo $user['username']; ?> </li>
                              <li> <span> Email: </span>
                                   <a href="mailto:<?php echo $user['email']; ?>">
                                        <?php echo $user['email']; ?>
                                   </a>
                              </li>
                              <li> <span> Phone Number: </span>
                                   <a href="tel:<?php echo $user['phone']; ?>">
                                        <?php echo $user['phone']; ?>
                                   </a>
                              </li>
                         </ul>
               <?php       }
               }
               ?>
          </div>
          <?php
          if ($user) {
               $query = "SELECT * FROM `book` WHERE `user_id` = :usid";
               $stmt = $pdo->prepare($query);
               $stmt->bindParam(':usid', $uid);
               $stmt->execute();
               $books = $stmt->fetchAll();
               if ($books) {
          ?>
                    <h2 class="heading__all">Other Books From the Seller</h2>
                    <div class="hr__scroll">
                         <?php
                         foreach ($books as $book) {
                              echo '<a href="view-book.php?id=' . $book['b_id'] . '">';
                              $type = ($book['type'] === 'new') ? 'New' : 'Used';
                              echo '<span class="book__type">' . $type . '</span>';
                              echo '<img class="view-book" src="images/' . $book['image'] . '" />';
                              echo '</a>';
                         }
                         ?>
                    </div>
          <?php }
          } ?>

          <?php require_once("includes/footer.inc.php"); ?>
     </div>
</body>

</html>