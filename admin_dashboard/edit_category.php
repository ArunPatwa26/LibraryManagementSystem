<?php 
include('../check_session.php');
include '../db.php';
$admin_name="";
$admin_email = "";

// echo $user_id;



$query="select * from Admins where EmailID = '$_SESSION[email]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
}

$category_id =0;
if(isset($_GET['bn'])){
    $category_id = $_GET['bn'];
}
// echo $_GET['bn'];
$query="select * from Category where Cat_ID=".$category_id;
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
  $name=$row['Cat_Name'];
}

$error_name="";
if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
    $name = trim($_POST['name']);
    if($name ==""){
        $error_name ="Enter Valid Book Category.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $category_id = $_POST['category_id'];
$connection = mysqli_connect("localhost","root","root");
$db =mysqli_select_db($connection,"library");
$name = $_POST['name'];

// echo $user_id;
// print_r($_POST); die;
$query="update Category set Cat_Name='$name'where Cat_ID=".$category_id; 
echo $query;
$query_run=mysqli_query($connection,$query);
if ($query_run) {
    echo "<script type='text/javascript'>
            alert('Category Update Successfully..');
            window.location.href='manage_category.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($connection) . "');
            window.location.href='manage_category.php';
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
<?php include_once('admin_dash_nav.php'); ?>
<span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
        <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Edit Category</h1>

        <main-section class="column">
        <div class="column view-profile">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="column" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="category_id" value="<?=$category_id ?>" name="category_id">
                       
                    <div class="form-group column ">
                        <label  class="font-light label-size left font-family  from-label">Enter Book Category:</label>
                        <input type="text" class="input-box font-family" name="name" value="<?php echo $name;?>">
                        <span style="color:red; "><?php echo $error_name; ?></span>
                    </div>
                        <button class="update-button font-family" style="width:125px; ">Update</button>
                    </form>
               
        </div>

    </main-section>

   

   
</body>
</html>