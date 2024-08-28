<?php
include('../check_session.php');
include '../db.php';

$user_name = "";
$user_email = "";
$user_mobile = "";
$user_address = "";

// Fetch user details
$query = "SELECT * FROM Users WHERE EmailID = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query); 
while ($row = mysqli_fetch_assoc($query_run)) {
    $user_name = $row['FullName'];
    $user_email = $row['EmailID'];
    $user_mobile = $row['MobileNo'];
    $user_address = $row['Address'];
}

// Fetch messages in reverse order (most recent first)
$message_query = "SELECT * FROM notification_box ORDER BY created_date DESC";
$message_query_run = mysqli_query($connection, $message_query); 
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
</head>
<body>
    <?php include_once('user_nav.php'); ?>
    <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Library Messages</h1>
    <div class="mainsection" style="background-color:whitesmoke; margin:30px 15vw; padding:50px 0px">
        <section-1> 
            <div class="book-cards column">
                <div class="cards row" style="display:flex; flex-wrap:wrap; justify-content:center">
                    <?php while($row = mysqli_fetch_assoc($message_query_run)){ ?>
                        <div class="card column font-family" style="padding:40px 15px; margin:10px 20px; width:90%;">
                            <h3>Date : <span class="font-family-light"><?php echo htmlspecialchars($row['created_date']); ?></span></h3>
                            <h1 class="font-family">Title : <?php echo htmlspecialchars($row['title']); ?></h1>
                            <h2 class="font-family">
                                Message : <span class="font-family-light"><?php echo htmlspecialchars($row['summary']); ?></span>
                            </h2>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section-1>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>
