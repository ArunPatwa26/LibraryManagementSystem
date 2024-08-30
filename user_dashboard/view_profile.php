<?php
 include('../check_session.php');
 include '../db.php';
$id = $_SESSION['id'];
// echo $_SESSION['email'];

$user_name="";
$display_user_name="";
$user_email = "";
$user_mobile="";
$user_address="";
$user_state="";
$user_country="";
$user_dob="";
$user_age="";
$user_gender="";

$query="select * from users where ID = '$id'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $user_name=$row['FullName'];
    $user_email=$row['EmailID'];
}


$form_query="select * from myprofile where EmailID ='$user_email'";
$form_query_run=mysqli_query($connection,$form_query); 
while($row =mysqli_fetch_assoc($form_query_run)){
    $display_user_name=$row['FullName'];
    $display_user_email=$row['EmailID'];
    $user_mobile=$row['MobileNo'];
    $user_address=$row['Address'];
    $user_state=$row['State'];
    $user_country=$row['Country'];
    $user_dob=$row['DateOfBirth'];
    $user_gender=$row['Gender'];
    $user_age=$row['Age'];
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
    <title>User Dashboard</title>
    <style>
          .main-container {
            padding: 20px;
            max-width: 900px;
            margin: 20px auto;
        }

        .profile-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
            box-sizing: border-box;
            /* background-color: #fff; */
        }

        .form-input:disabled, .form-select:disabled {
            background-color: #f0f0f0;
            /* color: #999; */
        }

        .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
            resize: vertical;
            box-sizing: border-box;
            background-color: #fff;
        }

        .form-textarea:disabled {
            background-color: #f0f0f0;
            /* color: #999; */
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-column {
            flex: 1;
        }

        .form-row > .form-group {
            flex: 1;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }

            .form-row > .form-group {
                flex: none;
            }
        }

        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }
    </style>
    
</head>
<body>
    <?php include_once('user_nav.php'); ?>
    <div class="main-container">
        <div class="profile-card">
            <h1 style="text-align:center" class="font-family">View Profile</h1>
            <form class="form font-family">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" id="name" name="name" class="form-input font-family" value="<?php echo $display_user_name?>" disabled>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email ID:</label>
                    <input type="email" id="email" name="email" class="form-input font-family" value="<?php echo $display_user_email?>" disabled>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phoneno" class="form-label">Mobile Number:</label>
                        <input type="text" id="phoneno" name="phoneno" class="form-input font-family" value="<?php echo $user_mobile?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="country" class="form-label">Country:</label>
                        <select id="country" name="country" class="form-select font-family" disabled>
                            <option value="<?php echo $user_country?>"><?php echo $user_country?></option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="form-input font-family" value="<?php echo $user_dob?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="age" class="form-label">Age:</label>
                        <input type="number" id="age" name="age" class="form-input font-family" value="<?php echo $user_age?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="form-label">Gender:</label>
                    <select id="gender" name="gender" class="form-select font-family" disabled>
                        <option value="<?php echo $user_gender?>" selected><?php echo $user_gender?></option>
                        <!-- Add more gender options if needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="state" class="form-label">State:</label>
                    <input type="text" id="state" name="state" class="form-input font-family" value="<?php echo $user_state?>" disabled>
                </div>
                <div class="form-group">
                    <label for="address" class="form-label">Address:</label>
                    <textarea rows="6" name="address" class="form-textarea font-family" disabled><?php echo $user_address?></textarea>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
