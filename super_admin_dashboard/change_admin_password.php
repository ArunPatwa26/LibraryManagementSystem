<?php
include('check_admin_session.php');
include '../db.php';
$admin_name="";
$admin_email = "";



$query="select * from Admins where EmailID = '$_SESSION[adminemail]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
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
    <title>change password</title>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
    <span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
    </span>
    <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Change Password</h1>
    <main-section class="column">
        <div class="column view-profile">
                <form action="update_admin_password.php" class="column" method="post">
                    <div class="form-group column ">
                        <label  class="font-light label-size left font-family  from-label">Enter Cureent Password:</label>
                        <input type="password" class="input-box font-family"  name="old_password" >
                    </div>
                    <div class="form-group column ">
                        <label  class="font-light label-size left font-family  from-label">Enter New Password:</label>
                        <input type="password" class="input-box font-family"  name="new_password" >
                    </div>
                    
                    <button type="submit"class="update-password-button font-family">Update Password</button>
                </form>
        </div>

    </main-section>
    <?php include "../user_dashboard/footer.php"; ?>

</body>
</html>