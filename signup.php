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
    <nav>
        <div class="logo">
            <div class="logo-text font-family">
                <h2>
                    <a href="index.php" class="text-decoration">Library Management System(LMS)</a>
                </h2>
            </div>
        </div>
        <div class="navbar font-family">
            <ul>
                <li class="list"><a href="admin_dashboard\index.php" class="text-decoration">Admin Login</a></li>
                <li class="list"><a href="index.php" class="text-decoration">User Login</a></li>
                <li class="list"><a href="signup.php" class="text-decoration">Register</a></li>
            </ul>
        </div>
    </nav>
    <br>
    <span>
        <marquee behavior="" direction="" class="text">This is Library Management System Library opens at 8.00 AM and close at 8.00 PM </marquee>
    </span>
    <br><br>
    <main-section class="row">

        <div class="main-section row">
            <div class="part part1 column ">
                <div class="heading font-family">

                    <h3>Library Timing</h3>
                </div>
                <ul class="font-family-light">
                    <li>Opening Timing: 8.00 AM</li>
                    <li>Closing Timing: 8.00 PM</li>
                    <li>(Sunday Off)</li>
                </ul>
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
            <div class="part part2 column">
                <div class="login-form column">
                    <div class="text center">
                        <h2 >User Registration Form</h2>
                    </div>
                    <form action="register.php" method="post" class="column">
                        <div class="form-group column">
                            <label for="name" class=" label-size font-family">Full Name:</label>
                            <input type="text" id="name" name="name" class="input-box font-family" required>
                        </div>
                        <div class="form-group column">
                            <label for="email" class=" label-size font-family">Email ID:</label>
                            <input type="email" id="email" name="email" class="input-box font-family" required>
                        </div>
                        <div class="form-group column">
                            <label for="pass" class=" label-size font-family">Password:</label>
                            <input type="password" id="pass" name="password" class="input-box font-family" required>
                            <img src="public/assests/show.png" alt="" width="40px" onclick="showPassword()"  style="position: relative; bottom: 34px; left: 49vw; height: 30px; width:30px">
                        </div>
                        <div class="form-group column">
                            <label for="phoneno" class=" label-size font-family">Mobile Number:</label>
                            <input type="text" id="phoneno" name="phoneno" class="input-box font-family" required>
                        </div>
                        <div class="form-group column">
                            <label for="address" class=" label-size font-family">Address:</label>
                           <textarea rows="4" cols="20" name="address" class="font-family textarea"></textarea>
                        </div>
                        <button class="Register-button font-family ">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </main-section>
    <script>
    function showPassword() {
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