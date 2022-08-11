<?php
require_once("includes/dbcon.rec.php");

$query = "SELECT * FROM `book` ORDER BY `uploaded_at` DESC limit 10";
$stmt = $pdo->prepare($query);
$stmt->execute();
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/head.inc.php"); ?>
</head>

<body>
     <?php include_once("includes/navbar.inc.php"); ?>
     <div class="main">
          <form class="main__area" method="GET" action="search.php?search=">
               <h2>Unlimited books, magazines <br />newspapers, and more.</h2>
               <div class="search">
                    <input type="search" name="q" class="search__box" value="<?php echo isset($_GET['q']) ? str_replace(' ', '%', strtolower(trim($_GET['q']))) : '' ?>" placeholder="i.e. Rich Dad Poor Dad" required />
                    <input class="btn-all" type="submit" value="Search" name="" style="padding: 18px; cursor:pointer; border:none">
               </div>
               <h4>Search Books by Title / Author / ISBN</h4>
          </form>
     </div>
     <!-- Home Section Ended -->
     <section class="main__container">
          <div class="container">
               <h2 class="heading__all">New Arrival</h2>
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
     <?php require_once("includes/footer.inc.php") ?>
</body>

</html>