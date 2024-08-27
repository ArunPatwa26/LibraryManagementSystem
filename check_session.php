<?php
session_start();
$id = $_SESSION['id'];

//check that the session exists
if(!isset($_SESSION['id']))
{
    //echo "here";
  //the session does not exist, redirect
  header("location: ../index.php");
}