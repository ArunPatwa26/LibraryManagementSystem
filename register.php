<?php
// Database connection
include 'db.php';

// Fetch POST data
$name = mysqli_real_escape_string($connection, $_POST['name']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$password = mysqli_real_escape_string($connection, $_POST['password']);
$address = mysqli_real_escape_string($connection, $_POST['address']);
$mobile = mysqli_real_escape_string($connection, $_POST['phoneno']);
$state = mysqli_real_escape_string($connection, $_POST['state']);
$country = mysqli_real_escape_string($connection, $_POST['country']);
$age = (int)$_POST['age'];
$dob = mysqli_real_escape_string($connection, $_POST['dob']);
$gender = mysqli_real_escape_string($connection, $_POST['gender']);

// Hash the password before storing it in the database
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// SQL Queries
$reg_query = "INSERT INTO myprofile (FullName, EmailID, MobileNo, Address, State, Country, Gender, DateOfBirth, Age, MembershipStart, created_date)
VALUES ('$name', '$email', '$mobile', '$address', '$state', '$country', '$gender', '$dob', $age, NOW(), NOW())";

if (mysqli_query($connection, $reg_query)) {
    $last_id = $connection->insert_id;
    $login_query = "INSERT INTO users (RegID, FullName, EmailID, MobileNo, Address, password) VALUES ('$last_id', '$name', '$email', '$mobile', '$address', '$hashed_password')";
    
    if (mysqli_query($connection, $login_query)) {
        echo '<script type="text/javascript">
            alert("Registration Successful.... You may log in now.");
            window.location.href="index.php";
        </script>';
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the connection
mysqli_close($connection);
?>
