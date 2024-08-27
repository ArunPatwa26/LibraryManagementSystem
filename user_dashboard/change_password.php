<?php
 include('../check_session.php');
 include '../db.php';

$id = $_SESSION['id'];

$user_name="";
$user_email = "";
$user_mobile="";
$user_address="";

$query="select * from Users where EmailID = '$_SESSION[email]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $user_name=$row['FullName'];
    $user_email=$row['EmailID'];
    $user_mobile=$row['MobileNo'];
    $user_address=$row['Address'];
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
<?php include_once('user_nav.php'); ?>
    <main-section class="column">
        <div class="column view-profile">
                <form action="update_password.php" class="column" method="post">
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

</body>
</html>