<?php 
include('../check_session.php');
include '../db.php';
$book_id="";
 if(isset($_GET['bn'])){
    $category_id = $_GET['bn'];
}
// echo $user_id;

$query="DELETE FROM Category WHERE Cat_ID=".$category_id;
$query_run=mysqli_query($connection,$query); 


if ($query_run) {
    echo "<script type='text/javascript'>
            alert('Books Delete Successfully..');
            window.location.href='manage_category.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($connection) . "');
            window.location.href='manage_category.php';
          </script>";
}
?>