<?php 
include('../check_session.php');
include '../db.php';
$book_id="";
 if(isset($_GET['bn'])){
    $user_id = $_GET['bn'];
}

$query="DELETE FROM Users WHERE id=".$user_id;
$query_run=mysqli_query($connection,$query); 


if ($query_run) {
    echo "<script type='text/javascript'>
            alert('Books Delete Successfully..');
            window.location.href='register_users.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($connection) . "');
            window.location.href='register_users.php';
          </script>";
}
?>