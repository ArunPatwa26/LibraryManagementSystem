<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/style1.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:ital,wght@0,200;0,300;0,400;0,700;0,800;1,400&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    
    <script src="public/bootstrap/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="public/bootbox/bootbox.min.js"></script>
    <script src="public/bootbox/bootbox.locales.min.js"></script>
   
    <title>Library Management System</title>
    <script>
        $(document).on("click", function() {
            // bootbox.alert({
            //                     message: 'This is an alert with a callback!',
            //                     callback: function () {
            //                    window.location.href= 'index.php';                                }
            //                     });
        });
    </script>
    
</head>

<body>

    <nav>
        <div class="logo">
            <div class="logo-text font-family">
                <h2>
                    <a href="index.php" class="text-decoration">Library Management System (LMS)</a>
                </h2>
            </div>
        </div>
        <div class="navbar font-family">
            <ul>
                <li class="list"><a href="admin_dashboard/index.php" class="text-decoration">Admin Login</a></li>
                <li class="list"><a href="index.php" class="text-decoration">User Login</a></li>
                <li class="list"><a href="signup.php" class="text-decoration">Register</a></li>
            </ul>
        </div>
    </nav>
    <br>
    <section class="flex-row main-section">
   
        <div class="part part1 column">
            <div class="heading font-family">
                <h3>Library Timing</h3>
            </div>
            <ul class="font-family-light">
                <li>Opening Timing: 8.00 AM</li>
                <li>Closing Timing: 8.00 PM</li>
                <li>(Sunday Off)</li>
            </ul>
            <div class="heading font-family">
                <h3>What We Provide?</h3>
            </div>
            <ul class="font-family-light">
                <li>Full furniture</li>
                <li>Free Wi-Fi</li>
                <li>Newspapers</li>
                <li>Discussion Room</li>
                <li>RO Water</li>
                <li>Peaceful Environment</li>
            </ul>
        </div>
        <div class="part part2 row">
            <div class="login-form column">
                <div class="text center">
                    <h2>User Registration Form</h2>
                </div>
                <form action="register.php" method="post" class="column" onsubmit="return validateForm()">
                    <div class="form-group column">
                        <label for="name" class="label-size font-family">Full Name:</label>
                        <input type="text" id="name" name="name" class="input-box font-family" required>
                    </div>
                    <div class="form-group column">
                        <label for="email" class="label-size font-family">Email ID:</label>
                        <input type="email" id="email" name="email" class="input-box font-family" required>
                    </div>
                    <div class="flex-row">
                        <div class="form-group column input-with-icon">
                            <label for="pass" class="label-size font-family">Password:</label>
                            <input type="password" id="pass" name="password" class="input-box font-family" required>
                            <img src="public/assests/show.png" alt="Show Password" onclick="showPassword('pass')" style="height: 30px; width:30px">
                           
                        </div>
                        <div class="form-group column input-with-icon">
                            <label for="confirm-pass" class="label-size font-family">Confirm Password:</label>
                            <input type="password" id="confirm-pass" name="confirm-password" class="input-box font-family" required>
                            <img src="public/assests/show.png" alt="Show Password" onclick="showPassword('confirm-pass')" style="height: 30px; width:30px">
                            <span id="error-message">Passwords do not match!</span>
                        </div>
                    </div>
                    <div class="flex-row">
                    <div class="form-group column">
                        <label for="phoneno" class="label-size font-family">Mobile Number:</label>
                        <input type="text" id="phoneno" name="phoneno" class="input-box font-family" required>
                    </div>
                    <div class="form-group column">
                        <label for="country" class="label-size font-family">Country:</label>
                        <select id="country" name="country" class="input-box font-family" required>
                            <option value="" disabled selected>Select your country</option>
                            <option value="United States">United States</option>
                            <option value="Canada">Canada</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Australia">Australia</option>
                            <option value="India">India</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                </div>

                <div class="flex-row">
                    <div class="form-group column">
                        <label for="dob" class="label-size font-family">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="input-box font-family" required>
                    </div>
                    <div class="form-group column">
                        <label for="age" class="label-size font-family">Age:</label>
                        <input type="number" id="age" name="age" class="input-box font-family" required>
                    </div>
                </div>

                <div class="form-group column">
                    <label for="gender" class="label-size font-family">Gender:</label>
                    <select id="gender" name="gender" class="input-box font-family" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                    <div class="form-group column">
                        <label for="state" class="label-size font-family">State:</label>
                        <input type="text" id="state" name="state" class="input-box font-family" required>
                    </div>

                    <div class="form-group column">
                        <label for="address" class="label-size font-family">Address:</label>
                        <textarea rows="6" cols="20" name="address" class="font-family textarea input-box"></textarea>
                    </div>
                    <button class="Register-button font-family">Register</button>
                </form>
            </div>
        </div>
    </section>
    <?php include_once('./user_dashboard/footer.php'); ?>
    <script>
        function showPassword(id) {
            var x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function validateForm() {
            var password = document.getElementById("pass").value;
            var confirmPassword = document.getElementById("confirm-pass").value;
            var errorMessage = document.getElementById("error-message");
            var passMessage = document.getElementById("pass-message");

    

            // Password match validation
            if (password !== confirmPassword) {
                errorMessage.style.display = "block";
                return false;
            } else {
                errorMessage.style.display = "none";
            }

            return true;
        }
    </script>
</body>

</html>
