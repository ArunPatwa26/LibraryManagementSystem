<?php 
include('check_admin_session.php');
include '../db.php';

if (isset($_GET['bn'])) {
    $user_id = mysqli_real_escape_string($connection, $_GET['bn']);

    // Delete from Users table
    $query1 = "DELETE FROM Users WHERE RegID='$user_id'";
    $query_run1 = mysqli_query($connection, $query1);

    // Delete from myprofile table
    $query2 = "DELETE FROM myprofile WHERE id='$user_id'";
    $query_run2 = mysqli_query($connection, $query2);

    if ($query_run1 && $query_run2) {
        echo "<script type='text/javascript'>
                alert('User deleted successfully.');
                window.location.href='register_users.php';
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Error: " . mysqli_error($connection) . "');
                window.location.href='register_users.php';
              </script>";
    }
} else {
    echo "<script type='text/javascript'>
            alert('Error: User ID not provided.');
            window.location.href='register_users.php';
          </script>";
}

// Close the connection
mysqli_close($connection);
?>
