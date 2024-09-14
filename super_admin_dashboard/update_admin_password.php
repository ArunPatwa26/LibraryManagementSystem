<?php
include('check_admin_session.php');
include '../db.php';

// Get the logged-in admin ID
$id = $_SESSION['adminid'];

// Get old and new passwords from the form
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
// $hashed_old_password=$old_password;
// Hash the old password using sha1 to match the stored hash
$hashed_old_password = sha1($old_password);

// Fetch the current password from the database
$query = "SELECT password FROM Admins WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    // Check if the old password matches
    if ($hashed_old_password == $stored_password) {
        // Hash the new password using sha1
        $hashed_new_password = sha1($new_password);

        // Update the password in the database
        $update_query = "UPDATE Admins SET password = ? WHERE id = ?";
        $update_stmt = $connection->prepare($update_query);
        $update_stmt->bind_param("si", $hashed_new_password, $id);

        if ($update_stmt->execute()) {
            echo '<script type="text/javascript">
                    alert("Password updated successfully.");
                    window.location.href="admin_dashboard.php";
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    alert("Failed to update password. Please try again.");
                  </script>';
        }
    } else {
        echo '<script type="text/javascript">
                alert("Incorrect old password.");
              </script>';
    }
} else {
    echo '<script type="text/javascript">
            alert("User not found.");
          </script>';
}

$stmt->close();
$connection->close();
?>
