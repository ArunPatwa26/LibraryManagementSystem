<?php
include './db.php';
if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $emailErr="";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
        if($email =="" && $password == ""){
            $emailErr = "Please Enter Email and Password";
        }
        
       # $connection = mysqli_connect("localhost","root","root");
       # $db =mysqli_select_db($connection,"library");
        
        $query="select * from Users where EmailID = '$email'";
        $query_run=mysqli_query($connection,$query);    
        while($row =mysqli_fetch_assoc($query_run)){
        $email_id=$row['EmailID'];
        $password_1=$row['password'];
            if($row['EmailID']== $email){
                if($row['password']== $password){
                    session_start();
                    $_SESSION['name']=$row['FullName'];
                    $_SESSION['id']=$row['ID'];
                    $_SESSION['email']=$row['EmailID'];
                    header("Location:user_dashboard\User_dashboard.php");          
                    
                }
                else{
                
                    
                }
            }
        }
    }
                                //else{
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
    </nav>
    <br>
    <span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
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
            </div>
            <div class="part part2 column">
                <div class="login-form column">
                    <div class="text center">
                        <h2 >User Login Form</h2>
                    </div>
                    <h4  style="text-align:center;">
                        <?php
                            if(!empty($emailErr)){
                                    print $emailErr;
                            } 
                        ?>
                    </h4>
                    <form action="" method="post" class="column">
                    
                        <div class="form-group column">
                            <label for="email" class=" label-size font-family"> User Email ID:</label>
                            <input type="email" id="email" name="email" class="input-box font-family" >
                        </div>
                        <div class="form-group column">
                            <label for="pass" class=" label-size font-family">Password:</label>
                            <input type="password" id="pass" name="password" class="input-box font-family">
                        </div>
                            <div class="row font-family" style="margin:10px 80px; font-size:18px;">

                                <input type="checkbox" onclick="myFunction()" style="margin: 8px 3px;">Show Password
                            </div>
                        
                        <span><button class="Register-button font-family " name="login">Login</button><a href="signup.php" class="text-decoration link font-family" style="color:blue; margin-left: 10px; font-size:20px;">| Not registered yet ?</a></span>
                    </form>
                   
                </div>
            </div>
        </div>
    </main-section>
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