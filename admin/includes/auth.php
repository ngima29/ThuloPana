<?php
if (!isset($_SESSION['logged_user']) || empty($_SESSION['logged_user'])) {
     header('Location: ../login.php');
}
