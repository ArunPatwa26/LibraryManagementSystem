<?php
session_start();
//session_start(); // Start session at the beginning

include './db.php'; // Include your database connection

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = sha1($password);
//    $password= password_hash($password, PASSWORD_BCRYPT);
    $emailErr = "";
    //echo $password;

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } elseif ($email == "" || $password == "") {
        // Check if email or password fields are empty
        $emailErr = "Please Enter Email and Password";
    } else {
        // If no errors, proceed with database query
        $query = "SELECT * FROM Users WHERE EmailID = '$email'";
        $query_run = mysqli_query($connection, $query);
        
        if (mysqli_num_rows($query_run) > 0) {
            $row = mysqli_fetch_assoc($query_run);
            if ($row['EmailID'] == $email) {
               
                // Assuming passwords are stored in plaintext (not recommended)
                if ($row['password'] == $password) {
                    // Set session variables
                    $_SESSION['username'] = $row['FullName'];
                    $_SESSION['userid'] = $row['ID'];
                    $_SESSION['useremail'] = $row['EmailID'];
                    // Redirect to user dashboard
                    header("Location:user_dashboard/User_dashboard.php");
                    exit(); // Always exit after redirecting
                } else {
                    $emailErr = "Incorrect password";
                }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:ital,wght@0,200;0,300;0,400;0,700;0,800;1,400&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/style1.css">
    <title>Library Management System</title>

</head>
<body>
    <nav class="row">
    <div class="logo row">
            <div class="logo-text font-family row">
                <h2>
                    <a href="index.php" class="text-decoration">Library Management System(LMS)</a>
                </h2>
            </div>
        </div>
        <div class="navbar font-family row">
            <ul class="row">
                <li class="list-style"><a href="admin_dashboard\index.php" class="text-decoration">Admin Login</a></li>
                <li class="list-style"><a href="index.php" class="text-decoration">User Login</a></li>
                <li class="list-style"><a href="signup.php" class="text-decoration">Register</a></li>
            </ul>
        </div>
        <!-- Navbar content -->
    </nav>
    <br>
    <span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and closes at 8.00 PM 
        </marquee>
    </span>
    <br><br>
    <main-section class="row">
        <div class="main-section row">
            <div class="part part1 column ">
            <div class="one one1">

    <div class="heading font-family">
        
        <h3>Library Timing</h3>
    </div>
    <ul class="font-family-light">
        <li>Opening Timing: 8.00 AM</li>
        <li>Closing Timing: 8.00 PM</li>
        <li>(Sunday Off)</li>
    </ul>
    </div>
    <div class="one one2">

    <div class="heading font-family">
        
        <h3>What We Provide ?</h3>
    </div>
    <ul class="font-family-light">
        <li>Full furniture</li>
        <li>Free Wi-fi</li>
        <li>News Papers</li>
        <li>Discussion Room</li>
        <li>RO Water</li>
        <li>Peacefull Environment</li>
    </ul>
    </div>

                <!-- Other sections -->
            </div>
            <div class="part part2 column">
                <div class="login-form column">
                    <div class="text center">
                        <h2>User Login Form</h2>
                    </div>
                    <h4 style="text-align:center;">
                        <?php
                        if (!empty($emailErr)) {
                            echo $emailErr;
                        }
                        ?>
                    </h4>
                    <form action="" method="post" class="column">
                        <div class="form-group column">
                            <label for="email" class="label-size font-family">User Email ID:</label>
                            <input type="email" id="email" name="email" class="input-box font-family" required>
                        </div>
                        <div class="form-group column">
                            <label for="pass" class="label-size font-family">Password:</label>
                            <input type="password" id="pass" name="password" class="input-box font-family" required>
                        </div>
                        <div class="row font-family" style="margin:10px 80px; font-size:18px;">
                            <input type="checkbox" onclick="myFunction()" style="margin: 8px 3px;">Show Password
                        </div>
                        <span>
                            <button class="Register-button font-family" name="login">Login</button>
                            <a href="signup.php" class="text-decoration link font-family" style="color:blue; margin-left: 10px; font-size:20px;">| Not registered yet?</a>
                        </span>
                        <span style="display: block; text-align: center; margin-top: 10px;">
                            <a href="forgot_password.php" class="text-decoration link font-family" style="color:blue;">Forgot Password?</a>
                        </span>

                    </form>
                </div>
            </div>
        </div>
    </main-section>
    <?php include_once('./user_dashboard/footer.php'); ?>
    <script>
    function myFunction() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</body>
</html>
