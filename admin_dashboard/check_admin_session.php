<?php
session_start();
if(!isset($_SESSION['adminid']) && !$_SESSION['adminid']>0) {
    //session is set
    header('Location:index.php');
}
// if (!isset($_SESSION['adminid']) || $_SESSION['adminid'] == 0) {
//     // session is not set or adminid is invalid
//     header('Location: index.php');
//     exit(); // it's good practice to exit after a redirect
// }
?>
