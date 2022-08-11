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
     <?php include_once("includes/navbar.inc.php"); ?>
     <div class="container">
          <div>
               <h1 style="margin: 10px 0;">Seller Dashboard /
                    <?php if (isset($_SESSION)) {
                         echo ucwords(strtolower($_SESSION['logged_user']));
                    }  ?>
               </h1>
          </div>
          <div class="dashboard__heading">
               <a class="btn-all" href="add-book.php"> Add Book </a>
          </div>

          <div style="overflow-x:auto;">
               <input type="text" class="searchField" name="" id="searchBook" placeholder="Search in table..." onkeyup="searchBook();">
               <?php include("includes/pagination.inc.php"); ?>
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
                    foreach ($res_data as $book) { ?>
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
                                   <a class="icon" href="edit-book.php?id=<?php echo $book['b_id']; ?>">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M6 20H11V22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V10.3C19.78 10.42 19.57 10.56 19.39 10.74L18 12.13V4H13V12L10.5 9.75L8 12V4H6V20M22.85 13.47L21.53 12.15C21.33 11.95 21 11.95 20.81 12.15L19.83 13.13L21.87 15.17L22.85 14.19C23.05 14 23.05 13.67 22.85 13.47M13 19.96V22H15.04L21.17 15.88L19.13 13.83L13 19.96Z" />
                                        </svg>
                                   </a>
                                   <?php echo "<a class='icon' onClick=\"javascript: return confirm('Are you sure you want to delete this user ?');\" href='delete-book.php?id=" . $book['b_id'] . "'>"
                                        . '<svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                     <path fill="currentColor" d="M14.12,10.47L12,12.59L9.87,10.47L8.46,11.88L10.59,14L8.47,16.12L9.88,17.53L12,15.41L14.12,17.53L15.53,16.12L13.41,14L15.53,11.88L14.12,10.47M15.5,4L14.5,3H9.5L8.5,4H5V6H19V4H15.5M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19M8,9H16V19H8V9Z" />
                                                     </svg>' .
                                        "</a>"; ?>
                              </td>
                         </tr>
                    <?php } ?>
               </table>
               <?php include("includes/pagination.inc.php"); ?>
          </div>
     </div>
     <?php require_once("includes/footer.inc.php"); ?>
     <script src="js/script.js"></script>
</body>

</html>