<?php
include('../check_session.php');
include '../db.php';
// $_SESSION['id']=$row['ID'];
$id=$_SESSION['id'];

// echo $id ;
$password="";
// print_r($_POST); die;
$query ="select * from Admins where id =".$id; 
// echo $query;

$query_run =mysqli_query($connection,$query);
while($row =mysqli_fetch_assoc($query_run)){
    $password=$row['password'];
}
if($password==$_POST['old_password']){
    $query="update Admins set password ='$_POST[new_password]' where id =".$id;
    $query_run =mysqli_query($connection,$query);
}
?>
<script type="text/javascript">
    alert("Updated Password Successfully");
    window.location.href="admin_dashboard.php";
</script>
