<?php require_once("includes/dbcon.rec.php"); ?>

<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/head.inc.php"); ?>
</head>

<body>
     <?php include_once("includes/navbar.inc.php"); ?>
     <div class="container">
          <?php
          $search = isset($_GET['q']) ? $_GET['q'] : '';
          if ($search === "") {
               header('location: index.php');
          }

          $query = "SELECT * FROM `book` WHERE `title` LIKE '%$search%' OR `author` LIKE '%$search%' OR `isbn` LIKE '%$search%' LIMIT 10";

          $stmt = $pdo->prepare($query);
          $stmt->execute();
          $books = $stmt->fetchAll();
          if ($books) {
          ?>
               <div style="overflow-x:auto;">
                    <input type="text" class="searchField" name="" id="searchBook" placeholder="Search in table..." onkeyup="searchBook();">
                    <table class="userdetails__table" id="bookTable">
                         <tr>
                              <th>SN</th>
                              <th>Image</th>
                              <th>Title</th>
                              <th>Author</th>
                              <th>Category</th>
                              <th>Type</th>
                              <th>Price</th>
                              <th>Uploaded At</th>
                              <th>Action</th>
                         </tr>
                         <?php $i = 1;
                         foreach ($books as $book) { ?>
                              <?php
                              $q = "SELECT c.c_name FROM book b LEFT JOIN category c ON b.category = c.c_id WHERE b.b_id = :bookid";
                              $stmt = $pdo->prepare($q);
                              $stmt->bindParam(':bookid', $book['b_id']);
                              $stmt->execute();
                              $category = $stmt->fetch();
                              ?>
                              <tr>
                                   <td><?php echo $i++; ?></td>
                                   <td class="table__image"><?php echo '<img src="images/' . $book['image'] . '" />'; ?></td>
                                   <td class="ws__normal"><?php echo ucwords(strtolower($book['title'])) ?></td>
                                   <td class="ws__normal"><?php echo ucwords(strtolower($book['author'])) ?></td>
                                   <td class="ws__normal"><?php echo ucwords(strtolower($category['c_name'])) ?></td>
                                   <td><?php echo ucwords(strtolower($book['type'])) ?></td>
                                   <td><?php echo "Rs. " . $book['price'] ?></td>
                                   <td><?php echo $book['uploaded_at'] ?></td>
                                   <td>
                                        <a class="icon" href="view-book.php?id=<?php echo $book['b_id']; ?>">
                                             <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                  <path fill="currentColor" d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" />
                                             </svg>
                                        </a>
                                   </td>
                              </tr>
                         <?php } ?>
                    </table>
               </div>
          <?php } else {
               echo "<h1> No data found !!!</h1>";
               header('Refresh: 1.5; URL = index.php');
          }
          ?>
          <?php require_once("includes/footer.inc.php"); ?>
          <script src="js/script.js"></script>
     </div>
</body>

</html>