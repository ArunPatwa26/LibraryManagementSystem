<?php
include('../check_session.php');
include '../db.php';
##session_start();
$id = $_SESSION['id'];
#$connection = mysqli_connect("localhost","root","root");
#$db =mysqli_select_db($connection,"library");
$user_name="";
$user_email = "";
$user_mobile="";
$user_address="";



$query="select * from Users where EmailID = '$_SESSION[email]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $user_name=$row['FullName'];
    $user_email=$row['EmailID'];
    $user_mobile=$row['MobileNo'];
    $user_address=$row['Address'];
}

$book_id = 0;
if(isset($_GET['bn'])){
    $book_id = $_GET['bn'];
}



$query="select * from Books where id =".$book_id;
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $name =$row['bookname'];
    $type =  $row['booktype'];
    $authorname =$row['authorname'];
    $availablebook =$row['availablebook'];
    $booksrno = $row['booksrno'];
    $booksummary =$row['booksummary'];
    $publisher =$row['bookpublisher'] ;
    $imageName =$row['bookimage'];
 

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
    <title>User dashboard</title>
</head>
<body>
<?php include_once('user_nav.php'); ?>

    <main-section class="column">
        <div class="parts row">
            <div class="part1">
                <img src="../public/assests/bookimage/<?php echo $imageName; ?>" alt="">
            </div>
            <div class="part2">
                <div class="text font-family-light">
                    <h1>Title : <?php echo $name;?></h1>
                    <p><span>Author</span> :  <?php echo $authorname;?></p>
                    <p><span>Language</span> : English</p>
                    <p><span>Book Category</span>: <?php echo $type;?></p>
                    <p><span>ISBN</span> : <?php echo $booksrno;?></p>
                    <p><span>Book Published</span> : <?php echo $publisher;?></p>
                    <p><span>Book Available</span> : <?php echo $availablebook;?></p>
                   
                    </div>


            </div>

        </div>
        <div class="text-summary">
            <h1>About book</h1>
            <p><?php echo $booksummary;?></p>
        </div>
    </main-section>

    </body>
    </html>