<?php
session_start();
session_destroy();
unset($_SESSION['adminid']);
header("Location:../admin_dashboard/index.php");