<?php 
include('../check_session.php');
include '../db.php';
$user_email="";
 if(isset($_GET['bn'])){
    $user_email = $_GET['bn'];
}

$query="DELETE FROM Users WHERE EmailID=".$user_id;
$query="DELETE FROM myprofile WHERE EmailID=".$user_id;
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