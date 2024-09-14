<?php
include('check_admin_session.php');
include '../db.php';
$name="";
$email = "";
$mobile="";

$admin_name = "";
$admin_email = "";



$query = "select * from Admins where EmailID = '$_SESSION[adminemail]'";
$query_run = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query_run)) {
    $admin_name = $row['FullName'];
    $admin_email = $row['EmailID'];
}

$query="select * from Admins where EmailID = '$_SESSION[adminemail]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $name=$row['FullName'];
    $email=$row['EmailID'];
    $mobile=$row['MobileNo'];
    $age=$row['age'];
    $gender=$row['gender'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/user_dashboard.css">
    <title>Admin Profile</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            background-color: #17a2b8;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .profile-info .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .profile-info .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-info .form-group input {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            background-color: #f1f1f1;
            color: #333;
            cursor: not-allowed;
        }

        .profile-info .form-group input:disabled {
            background-color: #e9ecef;
            color: #6c757d;
        }

        .back-link {
            text-decoration: none;
            color: #17a2b8;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include_once('admin_navbar.php'); ?>

    <div class="container">
        <a href="admin_dashboard.php" class="back-link"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        <div class="header">
            <h1>Admin Profile</h1>
        </div>
        <div class="profile-info">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" value="<?php echo $name; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email ID:</label>
                <input type="text" value="<?php echo $email; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Phone No:</label>
                <input type="text" value="<?php echo $mobile; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Age:</label>
                <input type="text" value="<?php echo $age; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <input type="text" value="<?php echo $gender; ?>" disabled>
            </div>
        </div>
    </div>
    <?php include "../user_dashboard/footer.php"; ?>
</body>
</html>
