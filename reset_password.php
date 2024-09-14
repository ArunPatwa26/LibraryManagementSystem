<?php
include './db.php'; // Include your database connection

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Debugging: Print the received token
   // echo 'Received token: ' . htmlspecialchars($token) . '<br>';

    // Fetch the user with the provided token and validate expiry
    $query = "SELECT * FROM Users WHERE reset_token=? AND token_expiry > CURRENT_TIMESTAMP";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    
    

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        //print_r($row);
        $user_id = $row['ID'];
        $stored_expiry = $row['token_expiry']; // Debugging: print expiry time
        echo 'Stored token expiry: ' . htmlspecialchars($stored_expiry) . '<br>';

        if (isset($_POST['submit'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password === $confirm_password) {
                // Hash the new password before storing it
                $hashed_password = sha1($new_password);

                // Update the user's password
                $update_query = "UPDATE Users SET password=?, reset_token=NULL, token_expiry=NULL WHERE ID=?";
                $stmt = mysqli_prepare($connection, $update_query);
                mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $user_id);
                $success = mysqli_stmt_execute($stmt);

                if ($success) {
                    echo "Your password has been reset successfully.";
                    header("refresh:3;url=index.php"); // Redirect to login or home page
                    exit();
                } else {
                    echo "Failed to update the password. Please try again.";
                }
            } else {
                echo "Passwords do not match.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!-- Reset Password HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style1.css"> <!-- Verify the path to your CSS file -->
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="" method="post">
            <div class="form-group column">
                <label for="new_password" class="label-size font-family">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="input-box font-family" required>
            </div>
            <div class="form-group column">
                <label for="confirm_password" class="label-size font-family">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="input-box font-family" required>
            </div>
            <button type="submit" name="submit" class="Register-button font-family">Reset Password</button>
        </form>
    </div>
</body>
</html>
