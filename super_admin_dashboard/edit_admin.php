<?php
include('check_admin_session.php');
include '../db.php';
$id = $_SESSION['adminid'];

$admin_name="";
$admin_email = "";
$admin_mobile="";
$admin_age="";
$admin_gender="";
$admin_id = 0;
if(isset($_GET['bn'])){
    $admin_id = $_GET['bn'];
}

$query="select * from Admins where ID=$_SESSION[adminid]";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
}

$query="select * from Admins where ID=".$admin_id;
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_names=$row['FullName'];
    $admin_emails=$row['EmailID'];
    $admin_mobile=$row['MobileNo'];
    $admin_dob=$row['dateofbirth'];
    $admin_age=$row['age'];
    $admin_gender=$row['gender'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

   
  
    // Check the connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile  =$_POST['mobile'];
    $dob  =$_POST['dob'];
    $age  =$_POST['age'];
    $gender  =$_POST['gender'];
    $admin_id =$_POST['admin_id'];

  
   
  
    // Correct SQL query syntax
    $query ="update Admins set FullName='$name',EmailID='$email',MobileNo='$mobile',dateofbirth='$dob'age='$age',gender='$gender' where id=".$admin_id; 

#    echo $query; die;            
  
    $_query_run = mysqli_query($connection, $query);
  
    if ($_query_run) {
        echo "<script type='text/javascript'>
                alert('Admin Update Successfully..');
                window.location.href='view_admins.php';
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Error: " . mysqli_error($connection) . "');
                window.location.href='view_manage_books.php';
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
    <title>edit Admin Profile</title>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('super_addmin_navbar.php'); ?>
    <span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
    </span>
    <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Edit Admin</h1>
    <main-section class="column">
        <div class="column view-profile">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="column" method="post" enctype="multipart/form-data">
                <input type="hidden" id="admin_id" value="<?=$admin_id ?>" name="admin_id">
                    <div class="form-group column ">
                        <label  class="font-light label-size left font-family  from-label">Name:</label>
                        <input type="text" class="input-box font-family" value="<?php echo $admin_names; ?>" name="name" >
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">EmailID:</label>
                        <input type="text" class="input-box font-family" value="<?php echo $admin_emails ?>" name="email" disabled>
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Phone No:</label>
                        <input type="text" class="input-box font-family" value="<?php echo $admin_mobile ?>" name="mobile">
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Date of Birth:</label>
                        <input type="date" class="input-box font-family" value="<?php echo $admin_dob ?>" name="dob">
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Age:</label>
                        <input type="text" class="input-box font-family" value="<?php echo $admin_age ?>" name="age">
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Gender:</label>
                        <input type="text" class="input-box font-family" value="<?php echo $admin_gender ?>" name="gender">
                    </div>
                   
                    <button class="update-button font-family">Update</button>
                </form>
        </div>

    </main-section>
    <?php include "../user_dashboard/footer.php"; ?>

</body>
</html>