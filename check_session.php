<?php
//session_start();
//$admin_id = $_SESSION['adminid'];
//$user_id = $_SESSION['userid'];
// if(isset($_SESSION)){
//   if(!$_SESSION['userid']){
//     header("location: ../index.php");
//   }
// }

session_start();
    if(!isset($_SESSION['userid']) && !$_SESSION['userid']>0) {
        //session is set
        header('Location:index.php');
    }
    //  if(!isset($_SESSION['adminid']) && !$_SESSION['adminid']>0){
    // //     //session is not set
    //      header('Location: ../index.php');
    //  }
//check that the session exists
// if(!isset($_SESSION['userid']))
// {
//     //echo "here";
//   //the session does not exist, redirect
//   header("location: ../index.php");
// } elseif(!isset($_SESSION['adminid']))
// {
//     //echo "here";
//   //the session does not exist, redirect
//   header("location: ../index.php");
// }