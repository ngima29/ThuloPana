<?php require_once('includes/dbcon.rec.php'); ?>
<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/head.inc.php"); ?>
</head>

<body>
     <?php include_once("includes/navbar.inc.php"); ?>
     <div class="container section-all">
          <?php
          if (isset($_GET['id']) && !empty($_GET['id'])) {
               $bid = $_GET['id'];
               $query = "SELECT * FROM `book` WHERE `b_id`=:id";
               $stmt = $pdo->prepare($query);
               $stmt->bindParam(':id', $bid);
               $stmt->execute();
               $book = $stmt->fetch();
               if (!$book) {
                    echo '<h2>No Book found with id = ' . $bid . '</h2>';
               } else {
                    $q = "SELECT c.c_name FROM book b LEFT JOIN category c ON b.category = c.c_id WHERE b.b_id = :bookid";
                    $stmt = $pdo->prepare($q);
                    $stmt->bindParam(':bookid', $bid);
                    $stmt->execute();
                    $category = $stmt->fetch();
          ?>
                    <div class="book__details">
                         <div class="book__image">
                              <?php echo '<img class="view-book" src="images/' . $book['image'] . '" />'; ?>
                         </div>
                         <div class="book__info">
                              <div>
                                   <ul class="heading__info-list">
                                        <li>
                                             <h2 class="heading__all"> <?php echo '" ' . ucwords(strtolower($book['title'])) . ' "' ?> </h2>
                                        </li>
                                        <li> <span> ISBN: </span> <?php echo $book['isbn'] ?> </li>
                                        <li> <span> Category: </span> <?php echo $category['c_name'] ?> </li>
                                        <li> <span> Published Year: </span> <?php echo $book['published_year'] ?> </li>
                                        <li> <span> Type: </span> <?php echo ucwords($book['type']) ?> </li>
                                        <li> <span> Pages: </span> <?php echo $book['pages'] ?> </li>
                                        <li> <span> Price: </span> Rs. <?php echo $book['price'] ?> </li>
                                        <li style="margin-top:10px;">
                                             <a href="seller-details.php?id=<?php echo $book['user_id']; ?>" style="color:#fff;" class="btn-all lsnone"> View Seller Details</a>
                                        </li>
                                   </ul>
                              </div>
                         </div>
                         <div class="book__description">
                              <h2 class="heading__all">Book Descriptions</h2>
                              <p>
                                   &nbsp;&nbsp;&nbsp;
                                   <?php echo $book['description'] ?>
                              </p>
                         </div>
                    </div>
          <?php }
          } ?>


          <?php
          if ($book) {
               $bcategory = $book['category'];
          }
          $query = "SELECT `b_id`, `image`, `type` FROM `book` WHERE `category` = :bcategory AND `b_id` != :bid limit 5";
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':bcategory', $bcategory);
          $stmt->bindParam(':bid', $bid);
          $stmt->execute();
          $books = $stmt->fetchAll();
          if ($books) {
          ?>
               <section class="main__container">
                    <div class="container">
                         <h2 class="heading__all">Similar Books</h2>
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
                    </div>
               </section>
          <?php } ?>
     </div>
</body>

</html>