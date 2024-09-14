<?php
include('check_admin_session.php');
include '../db.php';
// $_SESSION['id']=$row['ID'];
$id=$_SESSION['adminid'];
// echo $id ;

$name = $_POST['name'];
$email = $_POST['email'];
$mobile  =$_POST['mobile'];
$age  =$_POST['age'];
$gender  =$_POST['gender'];

// print_r($_POST); die;
$query ="update Admins set FullName='$name',EmailID='$email',MobileNo='$mobile',age='$age',gender='$gender' where id=".$id; 
// echo $query;

$query_run =mysqli_query($connection,$query)
?>
<script type="text/javascript">
    alert("Updated Succesfully")
    window.location.href="admin_dashboard.php"
</script>