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

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = sha1($password);
$mobile  =$_POST['phoneno'];
$age=$_POST['age'];
$gender=$_POST['gender'];
//print_r($_POST); die;
$query="insert into Admins(FullName,EmailID,MobileNo,age,gender,password) values('$name','$email',$mobile,'$age','$gender','$password')";
// echo $query; die;
$query_run=mysqli_query($connection,$query);
if ($query_run) {
    echo "<script type='text/javascript'>
            alert('Admin Add Successfully..');
            window.location.href='view_admins.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($connection) . "');
            window.location.href='view_admins.php';
          </script>";
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
    
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('super_addmin_navbar.php'); ?>

<span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
        <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Add New Admin</h1>

        <main-section class="column">
        <div class="column view-profile">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="column" method="post" enctype="multipart/form-data">
                        <div class="form-group column">
                            <label for="name" class=" label-size font-family">FullName:</label>
                            <input type="text" id="name" name="name" class="input-box font-family" required>
                        </div>
                        <div class="form-group column">
                            <label for="email" class=" label-size font-family">Email ID:</label>
                            <input type="email" id="email" name="email" class="input-box font-family" required>
                        </div>
                        <div class="form-group column" style="margin:0px 0px">
                            <label for="pass" class=" label-size font-family">Password:</label>
                            <input type="password" id="pass" name="password" class="input-box font-family" required>
                            <img src="../public/assests/show.png" alt="" width="40px" onclick="showPassword()"  style="position: relative; bottom: 34px; left: 49vw; height: 30px; width:30px">
                        </div>
                        <div class="form-group column">
                            <label for="phoneno" class=" label-size font-family">Mobile Number:</label>
                            <input type="text" id="phoneno" name="phoneno" class="input-box font-family" required>
                        </div>
                        <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Age:</label>
                        <input type="text" class="input-box font-family"  name="age">
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Gender:</label>
                        <input type="text" class="input-box font-family" name="gender">
                    </div>
                        <button class="update-button font-family" style="width:125px; ">Add User</button>
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