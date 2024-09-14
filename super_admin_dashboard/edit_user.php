<?php 
include('check_admin_session.php');
include '../db.php';
$admin_name="";
$admin_email = "";

// echo $user_id;



$query="select * from Admins where EmailID = '$_SESSION[adminemail]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
}

$regid ="";
if(isset($_GET['bn'])){
    $regid = $_GET['bn'];
    // echo $user_email;
}
// echo $_GET['bn'];
$user_query="select * from myprofile where id='$regid'";
$user_query_run=mysqli_query($connection,$user_query); 
while($row =mysqli_fetch_assoc($user_query_run)){
   $name=$row['FullName'];
   $email=$row['EmailID'];
   $mobileno=$row['MobileNo'];
   $address=$row['Address'];
   $state=$row['State'];
   $country=$row['Country'];
   $dob=$row['DateOfBirth'];
   $age=$row['Age'];
   $gender=$row['Gender'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $regid = $_POST['regid'];
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $mobile = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $state = mysqli_real_escape_string($connection, $_POST['state']);
    $country = mysqli_real_escape_string($connection, $_POST['country']);
    $age = (int)$_POST['age'];
    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']); 
// echo $user_id;
// print_r($_POST); die;
$reg_query = "UPDATE myprofile SET FullName='$name', EmailID='$email', MobileNo='$mobile', Address='$address', State='$state', Country='$country', Gender='$gender', DateOfBirth='$dob', Age=$age WHERE id='$regid'";

if (mysqli_query($connection, $reg_query)){
    $last_id = $connection->insert_id;
    $update_query="update Users set  FullName='$name', EmailID='$email', MobileNo='$mobile', Address='$address' where RegID='$regid'";
    mysqli_query($connection,$update_query);
    echo '<script type="text/javascript">
        alert("User Update Successfully.... ");
        window.location.href="register_users.php";
    </script>';
}
else {
    echo "Error: " . mysqli_error($connection);
}

// Close the connection
mysqli_close($connection);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/user_dashboard.css">
    <title>Library Management System</title>
    <style>
        
        .main-section {
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 30px;
            gap: 20px;
        }
        .main-section form{
            width: 90%;
        }
       
        
        .login-form h2 {
            color: #34495e;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }
        
        .form-group {
            margin-bottom: 15px;
            position: relative;
            width: 100%;
        }
        
        .label-size {
            font-weight: bold;
            color: #34495e;
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
        }
        
        .input-box {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            color: #34495e;
            transition: border 0.3s ease;
        }
        
        .input-box:focus {
            border-color: #1abc9c;
            outline: none;
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.3);
        }
        
        .Register-button {
            background: linear-gradient(90deg, #1abc9c, #16a085);
            color: #ffffff;
            /* padding: 15px; */
            border: none;
            border-radius: 12px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 90%;
            height: 40px;
            margin-top: 20px;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
        }
        
        .Register-button:hover {
            background: linear-gradient(90deg, #16a085, #1abc9c);
        }
        
        #error-message, #pass-message {
            color: red;
            font-size: 14px;
            display: none;
            position: absolute;
            bottom: -20px;
            left: 0;
        }
        
        .input-with-icon {
            position: relative;
            width: 100%;
        }
        
        .input-with-icon img {
            position: absolute;
            right: 18px;
            top: 77%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        
            </style>
    
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('super_addmin_navbar.php'); ?>
<span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
        <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Edit Users</h1>

        <main-section class="column">
        <div class="column view-profile">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="column" method="post" enctype="multipart/form-data">
                <input type="hidden" id="regid" value="<?=$regid ?>" name="regid">
        <div class="form-group column">
                        <label for="name" class="label-size font-family">Full Name:</label>
                        <input type="text" id="name" name="name" class="input-box font-family" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="form-group column">
                        <label for="email" class="label-size font-family">Email ID:</label>
                        <input type="email" id="email" name="email" class="input-box font-family" value="<?php echo $email; ?>" required>
                    </div>
                    
                    <div class="row">
                    <div class="form-group column">
                        <label for="phoneno" class="label-size font-family">Mobile Number:</label>
                        <input type="text" id="phoneno" name="phoneno" class="input-box font-family" value="<?php echo $mobileno; ?>" required>
                    </div>
                    <div class="form-group column">
                        <label for="country" class="label-size font-family">Country:</label>
                        <select id="country" name="country" class="input-box font-family" required>
                            <option value="<?php echo $country; ?>" disabled selected><?php echo $country; ?></option>
                            <option value="United States">United States</option>
                            <option value="Canada">Canada</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Australia">Australia</option>
                            <option value="India">India</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group column">
                        <label for="dob" class="label-size font-family">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="input-box font-family" value="<?php echo $dob; ?>" required>
                    </div>
                    <div class="form-group column">
                        <label for="age" class="label-size font-family">Age:</label>
                        <input type="number" id="age" name="age" class="input-box font-family" value="<?php echo $age; ?>" required>
                    </div>
                </div>

                <div class="form-group column">
                    <label for="gender" class="label-size font-family">Gender:</label>
                    <select id="gender" name="gender" class="input-box font-family" required>
                        <option value="<?php echo $gender; ?>" disabled selected><?php echo $gender; ?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group column">
                    <label for="state" class="label-size font-family">State:</label>
                    <input type="text" id="state" name="state" class="input-box font-family"value="<?php echo $state; ?>" required>
</div>

                    <div class="form-group column">
                        <label for="address" class="label-size font-family">Address:</label>
                        <textarea rows="6"  cols="30" name="address" class="font-family textarea input-box"><?php echo $address; ?></textarea>
                    </div>
                        <button class="update-button font-family" style="width:125px; ">Update</button>
                    </form>
               
        </div>

    </main-section>
    <?php include "../user_dashboard/footer.php"; ?>

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