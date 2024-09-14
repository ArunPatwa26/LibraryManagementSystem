<?php 
include('check_admin_session.php');
include '../db.php';
$book_id="";
 if(isset($_GET['bn'])){
    $book_id = $_GET['bn'];
}
echo $book_id;

$query="DELETE FROM books WHERE id=".$book_id;
$query_run=mysqli_query($connection,$query); 


if ($query_run) {
    echo "<script type='text/javascript'>
            alert('Books Delete Successfully..');
            window.location.href='view_manage_books.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($connection) . "');
            window.location.href='view_manage_books.php';
          </script>";
}
?>