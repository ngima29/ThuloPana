<?php
$uid = $_SESSION['uid'];
if (isset($_GET['pageno'])) {
     $pageno = $_GET['pageno'];
} else {
     $pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno - 1) * $no_of_records_per_page;

if ($_SESSION['role'] === "seller") {
     $total_pages_sql = "SELECT COUNT(*) FROM book where `user_id` = :u_id";
     $stmt = $pdo->prepare($total_pages_sql);
     $stmt->bindParam(':u_id', $_SESSION['uid']);
     $stmt->execute();
     $result = $stmt->fetch();
     $total_rows = $result[0];
     $total_pages = ceil($total_rows / $no_of_records_per_page);
     $sql = "SELECT * FROM book WHERE `user_id` = :u_id ORDER BY `uploaded_at` DESC LIMIT $offset, $no_of_records_per_page ";
} else {
     $total_pages_sql = "SELECT COUNT(*) FROM book";
     $stmt = $pdo->prepare($total_pages_sql);
     $stmt->execute();
     $result = $stmt->fetch();
     $total_rows = $result[0];
     $total_pages = ceil($total_rows / $no_of_records_per_page);
     $sql = "SELECT * FROM book LIMIT $offset, $no_of_records_per_page";
}

$statement = $pdo->prepare($sql);
$statement->bindParam(':u_id', $uid);
$statement->execute();
$res_data = $statement->fetchAll();
?>

<ul class="pagination">
     <li><a href="?pageno=1" title="First">
               <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M22,12A10,10 0 0,0 12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12M20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12M14,7L9,12L14,17V7Z" />
               </svg>
          </a></li>
     <li class="<?php if ($pageno <= 1) {
                         echo 'disabled';
                    } ?>">
          <a href="<?php if ($pageno <= 1) {
                         echo '#';
                    } else {
                         echo "?pageno=" . ($pageno - 1);
                    } ?>" title="Previous">
               <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20,10V14H11L14.5,17.5L12.08,19.92L4.16,12L12.08,4.08L14.5,6.5L11,10H20Z" />
               </svg>
          </a>
     </li>
     <li class="<?php if ($pageno >= $total_pages) {
                         echo 'disabled';
                    } ?>">
          <a href="<?php if ($pageno >= $total_pages) {
                         echo '#';
                    } else {
                         echo "?pageno=" . ($pageno + 1);
                    } ?>" title="Next">
               <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,10V14H13L9.5,17.5L11.92,19.92L19.84,12L11.92,4.08L9.5,6.5L13,10H4Z" />
               </svg>
          </a>
     </li>
     <li><a href="?pageno=<?php echo $total_pages; ?>" title="Last">
               <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2A10,10 0 0,0 2,12M4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12M10,17L15,12L10,7V17Z" />
               </svg>
          </a></li>
</ul>