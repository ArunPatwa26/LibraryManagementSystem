<?php
 include('../check_session.php');
 include '../db.php';
// $_SESSION['id']=$row['ID'];
$id=$_SESSION['id'];
// echo $id ;

$name = $_POST['name'];
$email = $_POST['email'];
$mobile  =$_POST['mobile'];
$address = $_POST['address'];
// print_r($_POST); die;
$query ="update Users set FullName='$name',EmailID='$email',MobileNo='$mobile',Address='$address' where id=".$id; 
//echo $query;

$query_run =mysqli_query($connection,$query)
?>
<script type="text/javascript">
    alert("Updated Succesfully")
    window.location.href="User_dashboard.php"
</script>