<?php
require('function.php');
include('../check_session.php');
include '../db.php';
$admin_name = "";
$admin_email = "";



$query = "select * from Admins where EmailID = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query_run)) {
    $admin_name = $row['FullName'];
    $admin_email = $row['EmailID'];
}

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
    <title>Admin dashboard</title>
</head>

<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('admin_dash_nav.php'); ?>
    
    <span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM
        </marquee>
    </span>
    <br><br>
    <section class="column font-family">
        <div class="cards cards1 row">
            <div class="card card1 font-family">
                <a href="register_users.php" target="_blank" class="text-decoration-b">
                    <div class="card-header font-family">Registered Users:</div>
                    <div class="card-body">
                        <h1 style="font-size:50px; text-align: center; margin:15px 0px">

                            <?php echo get_user_count(); ?>
                        </h1>

                        <p style="text-align: center; font-size:20px">

                            Numbers Of Users
                        </p>
                    </div>
                </a>
            </div>
            <div class="card card2 font-family">
                <a href="view_manage_books.php" target="_blank" class="text-decoration-b">
                    <div class="card-header font-family">Registered Books:</div>
                    <div class="card-body">
                        <h1 style="font-size:50px; text-align: center; margin:15px 0px">
                            <?php echo get_book_count(); ?>

                        </h1>

                        <p style="text-align: center; font-size:20px">

                            Numbers Of Books
                        </p>
                    </div>
                </a>
            </div>
            <div class="card card3 font-family">
                <a href="manage_category.php" target="_blank" class="text-decoration-b">
                    <div class="card-header font-family">Registered Category:</div>
                    <div class="card-body">
                        <h1 style="font-size:50px; text-align: center; margin:15px 0px">

                            <?php echo get_category_count(); ?>
                        </h1>

                        <p style="text-align: center; font-size:20px">

                            view Categories
                        </p>
                    </div>
                </a>
            </div>
            <div class="card card4 font-family">
                <a href="view_issuebook.php" target="_blank" class="text-decoration-b">
                    <div class="card-header font-family">Issued Books:</div>
                    <div class="card-body">
                        <h1 style="font-size:50px; text-align: center; margin:15px 0px">

                            <?php echo get_issuebooks_count(); ?>
                        </h1>

                        <p style="text-align: center; font-size:20px">

                            View Issued Books
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="cards column" style="margin:20px 0px">

            <div class="card card5 font-family">
                <a href="view_admins.php" target="_blank" class="text-decoration-b">
                    <div class="card-header font-family">View Admins:</div>
                    <div class="card-body">
                        <h1 style="font-size:50px; text-align: center; margin:15px 0px">
                            <?php echo get_admin_count(); ?>
                            
                        </h1>
                        
                        <p style="text-align: center; font-size:20px">
                            
                            View Admins
                        </p>
                    </div>
                </a>
            </div>
        </div>


            
    </section>
</body>

</html>