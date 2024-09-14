<?php
include '../db.php'; // Include your database connection

// Set the timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Fetch the user with the provided token and validate expiry
    $query = "SELECT * FROM admins WHERE reset_token=? AND token_expiry > NOW()";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $admin_id = $row['ID'];
        $stored_expiry = $row['token_expiry'];

        // Debugging: print expiry time and current time
        $current_time = date('Y-m-d H:i:s');
        echo 'Current Time: ' . htmlspecialchars($current_time) . '<br>';
        echo 'Stored Token Expiry: ' . htmlspecialchars($stored_expiry) . '<br>';

        if (isset($_POST['submit'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password === $confirm_password) {
                // Hash the new password before storing it
                $hashed_password = sha1($new_password);

                // Update the user's password
                $update_query = "UPDATE admins SET password=?, reset_token=NULL, token_expiry=NULL WHERE ID=?";
                $stmt = mysqli_prepare($connection, $update_query);
                mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $admin_id);
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
        // More detailed debugging information
        $query_check_token = "SELECT reset_token, token_expiry FROM admins WHERE reset_token=?";
        $stmt_check = mysqli_prepare($connection, $query_check_token);
        mysqli_stmt_bind_param($stmt_check, 's', $token);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            $row_check = mysqli_fetch_assoc($result_check);
            echo "Stored Token: " . htmlspecialchars($row_check['reset_token']) . "<br>";
            echo "Token Expiry: " . htmlspecialchars($row_check['token_expiry']) . "<br>";
        } else {
            echo "Token does not exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style1.css"> <!-- Verify the path to your CSS file -->
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }

        .form-group input[type="password"] {
            /* width: calc(100% - 24px);    */
            /* display: block; */
            width: 325px;
            height: 40px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
            /* transition: border-color 0.3s; */
        }

        .form-group input[type="password"]:focus {
            border-color: #6e8efb;
        }

        .show-password {
            display: flex;
            margin-left: 5px;
            font-size: 14px;
            color: #555;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6e8efb;
            border: none;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background: #5a7ce0;
        }

        .error {
            color: #ff0000;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form id="resetForm" action="" method="post">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" style="width:325px; height:40px; padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 14px;
    outline: none;" required>
                <img src="../public/assests/show.png" alt="Show Password" onclick="togglePassword('new_password')" style="height: 30px; width:30px;position: relative;
    bottom: 34px;
    left: 18vw;">
            </div>
            <div class="form-group" style="    position: relative;
    bottom: 14px;">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" style="width:325px; height:40px; padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 14px;
    outline: none;" required>
                <img src="../public/assests/show.png" alt="Show Password" onclick="togglePassword('confirm_password')" style="height: 30px; width:30px;position: relative;
    bottom: 34px;
    left: 18vw;">
            </div>
            <div class="error" id="error-message" style="    position: relative;
    bottom: 30px;"></div>
            <button type="submit" name="submit" style="    position: relative;
    bottom: 20px;">Reset Password</button>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            var x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }


        document.getElementById('resetForm').addEventListener('submit', function(event) {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var errorMessage = document.getElementById('error-message');

            if (newPassword !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match.';
                event.preventDefault(); // Prevent form submission
            } else {
                errorMessage.textContent = ''; // Clear error message
            }
        });
    </script>
</body>

</html>