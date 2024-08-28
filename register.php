<?php
$connection = mysqli_connect("localhost","root","root");
$db =mysqli_select_db($connection,"library");
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$mobile  =$_POST['phoneno'];

//print_r($_POST); die;
$login_query="insert into users (FullName,EmailID,MobileNo,Address,password) values('$name','$email',$mobile,'$address','$password')";

$query_run=mysqli_query($connection,$login_query);
?>
<script type="text/javascript">
    alert("Registeration Successfully.... You May login now..")
    window.location.href="index.php"
</script>