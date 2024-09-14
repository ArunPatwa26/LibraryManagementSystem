<?php 
include('check_admin_session.php');
include '../db.php';
$event_id="";
 if(isset($_GET['bn'])){
    $event_id = $_GET['bn'];
}
// echo $user_id;

$query="DELETE FROM notification_box WHERE id=".$event_id;
$query_run=mysqli_query($connection,$query); 


if ($query_run) {
    echo "<script type='text/javascript'>
            alert('Event Delete Successfully..');
            window.location.href='view_events.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($connection) . "');
            window.location.href='view_events.php';
          </script>";
}
?>