<?php
 include('../check_session.php');
 include '../db.php';
$id = $_SESSION['id'];

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
    <?php include_once('user_navbar.php'); ?>
   
    <!-- <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Library Books</h1> -->

    <main-section1>
    <section-1>
 
      
            <?php
                    $user_query="select * from Books";
                 $query_run=mysqli_query($connection,$user_query);
                 
            
            
            ?>
            <div class="book-cards column">

                
                
                
                <div class="cards row" style="display:flex; flex-wrap:wrap; justify-content:center">
                
                <?php while($row=mysqli_fetch_assoc($query_run)){ 
                    $_SESSION['bookid']=$row['id'];
                    ?>
                        <div class="card column font-family" style="margin:20px 20px; ">
                            <a href="show_book.php?bn=<?php echo $row['id'] ?>" class="text-decoration-b">

                                <div class="img">
                                    <img src="../public/assests/bookimage/<?php echo($row['bookimage']); ?>" alt="">
                                    
                                </div>
                                <p class="bookauthorname font-family-light">
                                    <?php echo($row['authorname']); ?>
                                </p>
                                <h4 class="bookname">
                                    
                                    <?php echo($row['bookname']); ?>
                                </h4>
                                <h4 class="booktype">
                                    <?php echo($row['booktype']); ?>
                                </h4>
                                
                            </a>
                        </div>
                        
                        
                        <?php } ?>
                    </div>
                    
                </div>
   
</section-1>

    </main-section1>

    <footer class="row font-family">
        <div class="footer row  font-family">
            <div class="footer-1 column font-family">
                <h2>Library Management System</h2>
                <p class="font-family-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo deleniti dolores ex rerum, suscipit necessitatibus rem modi dicta iure optio perspiciatis error eveniet.</p>
            </div>
            <div class="footer-2 column"><h2>About Us</h2>
            <ul class="font-family-light">
                <li>We Are Provide All Varity Of Books</li>
                <li>Secure Library</li>
                <li>All Category Books</li>
                <li>Certified By University Of Mumbai</li>
            </ul>
        
        </div>
            <div class="footer-3 column">Three</div>
        </div>
    </footer>
</body>
</html>