<?php
 include('../check_session.php');
 include '../db.php';
// $_SESSION['id']=$row['ID'];
$id=$_SESSION['id'];

$user_email=$_SESSION['email'];
print_r($user_email); 
// echo $id ;

$name = mysqli_real_escape_string($connection, $_POST['name']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
// $password = mysqli_real_escape_string($connection, $_POST['password']);
$address = mysqli_real_escape_string($connection, $_POST['address']);
$mobile = mysqli_real_escape_string($connection, $_POST['phoneno']);
$state = mysqli_real_escape_string($connection, $_POST['state']);
$country = mysqli_real_escape_string($connection, $_POST['country']);
$age = (int)$_POST['age'];
$dob = mysqli_real_escape_string($connection, $_POST['dob']);
$gender = mysqli_real_escape_string($connection, $_POST['gender']); 



// print_r($_POST); die;
$update_reg_query ="update myprofile set FullName='$name', EmailID='$email',MobileNo='$mobile', Address='$address', State='$state', Country='$country', Gender='$gender', DateOfBirth='$dob', Age=$age where EmailID='$user_email'";
$update_query ="update Users set FullName='$name',EmailID='$email',MobileNo='$mobile',Address='$address' where EmailID='$user_email'"; 


//echo $query;

$query_run =mysqli_query($connection,$update_reg_query);
$query_run =mysqli_query($connection,$update_query);
?>
<script type="text/javascript">
    alert("Updated Succesfully")
    window.location.href="User_dashboard.php"
</script>