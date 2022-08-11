<?php
require_once("../includes/dbcon.rec.php");
require_once("includes/auth.php");
?>
<!DOCTYPE html>
<html>

<head>
     <?php include_once("../includes/head.inc.php"); ?>
</head>

<body>
     <?php include_once("includes/navbar.inc.php"); ?>
     <?php
     if ($_SESSION['role'] === "seller" || $_SESSION['role'] === "admin") {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
               $user_id = $_POST['user_id'];
               $b_id = $_POST['b_id'];
               $isbn = $_POST['isbn'];
               $title = $_POST['title'];
               $description = $_POST['description'];
               $author = $_POST['author'];
               $category = $_POST['category'];
               $type = $_POST['type'];
               $pages = $_POST['pages'];
               $price = $_POST['price'];
               $publishedYear = $_POST['publishedYear'];

               $imageFile = $_FILES['imageFile'];
               $fileName = $_FILES['imageFile']['name'];
               $fileTmpName = $_FILES['imageFile']['tmp_name'];
               $fileSize = $_FILES['imageFile']['size'];
               $fileError = $_FILES['imageFile']['error'];
               $fileType = $_FILES['imageFile']['type'];

               $fileExtention = explode('.', $fileName);
               // end returns the last piece of data
               $fileActualExtention = strtolower(end($fileExtention));
               echo $fileActualExtention;
               $allowed = array('jpg', 'jpeg', 'png', 'svg');

               if (in_array($fileActualExtention, $allowed)) {
                    if ($fileError === 0) {
                         if ($fileSize < 5242880) {
                              $fileNameNew = uniqid('', false) . "." . $fileActualExtention;
                              $fileDestination = '../images/upload_image/' . $fileNameNew;
                              $dbDestination = 'upload_image/' . $fileNameNew;
                              $query = "UPDATE `book` SET `user_id`=:userid, `isbn`=:isbn, `title`=:title, `description`=:descriptions, `author`=:author, `category`=:category,
                              `type`=:types, `pages`=:pages, `price`=:price, `image`=:images, `published_year`=:pubyear, `uploaded_at`=now(), `updated_at`=now() WHERE `b_id`=:b_id";
                              $stmt = $pdo->prepare($query);
                              $stmt->bindParam(':userid', $user_id);
                              $stmt->bindParam(':b_id', $b_id);
                              $stmt->bindParam(':isbn', $isbn);
                              $stmt->bindParam(':title', $title);
                              $stmt->bindParam(':descriptions', $description);
                              $stmt->bindParam(':author', $author);
                              $stmt->bindParam(':category', $category);
                              $stmt->bindParam(':types', $type);
                              $stmt->bindParam(':pages', $pages);
                              $stmt->bindParam(':price', $price);
                              $stmt->bindParam(':images', $dbDestination);
                              $stmt->bindParam(':pubyear', $publishedYear);
                              $stmt->execute();
                              // moving file from temp location to new destination
                              move_uploaded_file($fileTmpName, $fileDestination);
                              echo '<h2>Book updated successfully</h2>';
                              header('Refresh: 1; URL = dashboard.php');
                         } else {
                              echo "<h1> Your file is too big!!! </h1>";
                         }
                    } else {
                         echo "<h1> There was an error uploading your file!!! </h1> ";
                    }
               } else {
                    echo "<h1> You cannot upload files of this type!!! </h1>";
               }
          } else {
               if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $b_id = $_GET['id'];
                    $qry = "SELECT * FROM `book` WHERE `b_id`=:b_id";
                    $stmt = $pdo->prepare($qry);
                    $stmt->bindParam(':b_id', $b_id);
                    $stmt->execute();
                    $book = $stmt->fetch();
                    if (!$book) {
                         echo '<h2>No book found with given id</h2>';
                    } else {
                         $q = "SELECT * FROM `book` b LEFT JOIN `category` c ON b.category = c.c_id WHERE b.b_id = :bid";
                         $stmt = $pdo->prepare($q);
                         $stmt->bindParam(':bid', $book['b_id']);
                         $stmt->execute();
                         $newbook = $stmt->fetch();
     ?>
                         <div class="login">
                              <form class="login__card" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                   <div class="form__heading">
                                        <h2 class="card__heading">Edit Book Of</h2>
                                        <p class="card__subheading">
                                             <a href="../index.php"> ThuloPana </a>
                                        </p>
                                   </div>
                                   <input type="hidden" name="b_id" value="<?php echo $newbook['b_id']; ?>" />
                                   <input type="hidden" name="user_id" value="<?php echo $newbook['user_id']; ?>" />
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M22 3H2A2.07 2.07 0 0 0 0 5V19A2.07 2.07 0 0 0 2 21H22A2.07 2.07 0 0 0 24 19V5A2.07 2.07 0 0 0 22 3M22 19H2V5H22M14 17V15.75C14 14.09 10.66 13.25 9 13.25S4 14.09 4 15.75V17H14M9 7A2.5 2.5 0 1 0 11.5 9.5A2.5 2.5 0 0 0 9 7M15 10V13H19V10H15" />
                                        </svg>
                                        <input class="input-field" type="text" autofocus maxlength="25" name="isbn" placeholder="ISBN" value="<?php echo $newbook['isbn']; ?>" required />
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M18,2A2,2 0 0,1 20,4V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2H18M18,4H13V12L10.5,9.75L8,12V4H6V20H18V4Z" />
                                        </svg>
                                        <input class="input-field" type="text" maxlength="50" name="title" placeholder="Title" value="<?php echo $newbook['title']; ?>" required />
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M19 2A2 2 0 0 1 21 4V16A2 2 0 0 1 19 18H9A2 2 0 0 1 7 16V4A2 2 0 0 1 9 2H19M19 4H16V10L13.5 7.75L11 10V4H9V16H19M3 20A2 2 0 0 0 5 22H17V20H5V6H3Z" />
                                        </svg>
                                        <textarea class="input-field" placeholder="Description" name="description" cols="5" rows="3"><?php echo $newbook['description']; ?></textarea>
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z" />
                                        </svg>
                                        <input class="input-field" type="text" name="author" placeholder="Author" value="<?php echo $newbook['author']; ?>" required />
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M5,9.5L7.5,14H2.5L5,9.5M3,4H7V8H3V4M5,20A2,2 0 0,0 7,18A2,2 0 0,0 5,16A2,2 0 0,0 3,18A2,2 0 0,0 5,20M9,5V7H21V5H9M9,19H21V17H9V19M9,13H21V11H9V13Z" />
                                        </svg>
                                        <select class="input-field" name="category" id="category" required>
                                             <option value="<?php echo $newbook['c_id']; ?>" selected hidden> <?php echo $newbook['c_name'] ?> </option>
                                             <?php
                                             $q = "SELECT * FROM `category` ORDER BY `c_name` ASC";
                                             $stmt = $pdo->prepare($q);
                                             $stmt->execute();
                                             $category = $stmt->fetchAll();
                                             foreach ($category as $cat) {  ?>
                                                  <option value="<?php echo $cat['c_id']; ?>"> <?php echo $cat['c_name'] ?> </option>
                                             <?php } ?>
                                        </select>
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M5,9.5L7.5,14H2.5L5,9.5M3,4H7V8H3V4M5,20A2,2 0 0,0 7,18A2,2 0 0,0 5,16A2,2 0 0,0 3,18A2,2 0 0,0 5,20M9,5V7H21V5H9M9,19H21V17H9V19M9,13H21V11H9V13Z" />
                                        </svg>
                                        <select class="input-field" name="type" id="type" required>
                                             <option value="<?php echo $newbook['type']; ?>" selected hidden> <?php echo  ucwords($newbook['type']); ?> </option>
                                             <option value="new"> New </option>
                                             <option value="used"> Used </option>
                                        </select>
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M19 1L14 6V17L19 12.5V1M21 5V18.5C19.9 18.15 18.7 18 17.5 18C15.8 18 13.35 18.65 12 19.5V6C10.55 4.9 8.45 4.5 6.5 4.5C4.55 4.5 2.45 4.9 1 6V20.65C1 20.9 1.25 21.15 1.5 21.15C1.6 21.15 1.65 21.1 1.75 21.1C3.1 20.45 5.05 20 6.5 20C8.45 20 10.55 20.4 12 21.5C13.35 20.65 15.8 20 17.5 20C19.15 20 20.85 20.3 22.25 21.05C22.35 21.1 22.4 21.1 22.5 21.1C22.75 21.1 23 20.85 23 20.6V6C22.4 5.55 21.75 5.25 21 5M10 18.41C8.75 18.09 7.5 18 6.5 18C5.44 18 4.18 18.19 3 18.5V7.13C3.91 6.73 5.14 6.5 6.5 6.5C7.86 6.5 9.09 6.73 10 7.13V18.41Z" />
                                        </svg>
                                        <input class="input-field" type="text" maxlength="5" name="pages" placeholder="Pages" value="<?php echo $newbook['pages']; ?>" required />
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M2,5H22V20H2V5M20,18V7H4V18H20M17,8A2,2 0 0,0 19,10V15A2,2 0 0,0 17,17H7A2,2 0 0,0 5,15V10A2,2 0 0,0 7,8H17M17,13V12C17,10.9 16.33,10 15.5,10C14.67,10 14,10.9 14,12V13C14,14.1 14.67,15 15.5,15C16.33,15 17,14.1 17,13M15.5,11A0.5,0.5 0 0,1 16,11.5V13.5A0.5,0.5 0 0,1 15.5,14A0.5,0.5 0 0,1 15,13.5V11.5A0.5,0.5 0 0,1 15.5,11M13,13V12C13,10.9 12.33,10 11.5,10C10.67,10 10,10.9 10,12V13C10,14.1 10.67,15 11.5,15C12.33,15 13,14.1 13,13M11.5,11A0.5,0.5 0 0,1 12,11.5V13.5A0.5,0.5 0 0,1 11.5,14A0.5,0.5 0 0,1 11,13.5V11.5A0.5,0.5 0 0,1 11.5,11M8,15H9V10H8L7,10.5V11.5L8,11V15Z" />
                                        </svg>
                                        <input class="input-field" type="text" maxlength="10" name="price" placeholder="Price" value="<?php echo $newbook['price']; ?>" required />
                                   </div>
                                   <div class="input__group">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                             <path fill="currentColor" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z" />
                                        </svg>
                                        <input class="input-field" type="text" maxlength="4" name="publishedYear" placeholder="Published Year" value="<?php echo $newbook['published_year']; ?>" required />
                                   </div>
                                   <div class="input__group" style="color: #fff;">
                                        <span>Upload Image</span>
                                        <input class="input-field" type="file" name="imageFile" placeholder="Upload Image" required />
                                   </div>

                                   <input type="submit" name="submit" class="btn btn-all register_btn" value="Update">
                                   <input type="reset" class="btn btn-all register_btn" value="Reset">
                                   <input type="button" class="btn btn-all register_btn" value="Cancel" onclick="return cancel();">
                              </form>
                         </div>

     <?php }
               } else {
                    echo "<h2> No record specified to update.</h2>";
               }
          }
     } else {
          header('location: ../index.php');
     } ?>
     <!-- custom script -->
     <script>
          function cancel() {
               window.location.assign('dashboard.php');
          }
     </script>
</body>

</html>