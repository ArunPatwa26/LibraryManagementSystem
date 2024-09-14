<?php
date_default_timezone_set('Asia/Kolkata');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Include your database connection
include './db.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $emailErr = "";

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        // Query the database to find the user by email
        $query = "SELECT * FROM Users WHERE EmailID = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Fetch the user details
            $user = mysqli_fetch_assoc($result);
            
            // Generate a unique token
            $token = sha1($email); // Generate a secure token
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Set expiry to 1 hour from now (adjust as needed)
            
            $query = "UPDATE Users SET reset_token=?, token_expiry=? WHERE EmailID=?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $token, $expiry, $email);
            mysqli_stmt_execute($stmt);
            

            // Create the password reset link
            $reset_link = "http://localhost:5000/librarymanagementsystem/reset_password.php?token=$token";

            // Initialize PHPMailer and set up SMTP settings
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'arunpatwa2605@gmail.com';
                $mail->Password   = 'qouy qvmx bizz lyyt';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom('arunpatwa2605@gmail.com', 'Library Management System');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hello " . $user['FullName'] . ",<br><br>Click the following link to reset your password: <a href='$reset_link'>$reset_link</a><br><br>This link will expire in one hour.";

                // Send the email
                $mail->send();
                echo "Password reset link has been sent to your email.";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $emailErr = "Email not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Enter your registered email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>
        <?php
        if (!empty($emailErr)) {
            echo '<p class="error">' . htmlspecialchars($emailErr) . '</p>';
        }
        ?>
    </div>
</body>
</html>