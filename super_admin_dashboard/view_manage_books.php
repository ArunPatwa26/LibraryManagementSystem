<?php
 require('function.php');
 include('check_admin_session.php');
 include '../db.php';
 $admin_name="";
 $admin_email = "";
 $book_name="";
 $author_id="";
 $cat_id="";
 $book_no="";
 $book_price="";



$query="select * from Admins where EmailID = '$_SESSION[adminemail]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
     <link href="https://fonts.googleapis.com/css2?family=Neuton:ital,wght@0,200;0,300;0,400;0,700;0,800;1,400&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/admin_dashboard.css">
    <title>Admin dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

    <script>
        $(document).ready( function () {
        $('#issue_book').DataTable();
        } );
    </script>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('super_addmin_navbar.php'); ?>
<span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
        <br><br>
</span>
<span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
<h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Manage Books</h1>
<button class="update-button font-family" style="position:relative; left:82vw; margin-bottom:20px; padding:-4px 10px;"><a href="add_newbook.php" class="text-decoration" style="padding:6px 6px;">Add Books</a></button>
<section-1>
    <div class="row table-center table">
        <form action="" class="row table-center">
            <!-- <table class="row table" id="issue_book">
                <tr class='header font-family'>
                    <th> Book Name</th>
                    <th>Author ID</th>
                    <th>Cat ID</th>
                    <th>Book NO</th>
                    <th>Book Price</th>
                </tr>
            <?php
                    $user_query="select * from Books";
                 $book_query_run=mysqli_query($connection,$user_query);
            
            
            ?>
           
           
            </table> -->
            <table id="issue_book" class="display">
                <thead>
                    <tr>
                    <th> Book Name</th>
                                <th>Book Type</th>
                                <th>Auther Name</th>
                                <th>Available Books</th>
                                <th>Action</th>
                               
                    </tr>
                </thead>
                <tbody>
                <?php while($row=mysqli_fetch_assoc($book_query_run)){ 
                    $_SESSION['bookid']=$row['id'];
                    ?>
                    <tr>
                        <td><?php echo($row['bookname']); ?></td>
                        <td><?php echo($row['booktype']); ?></td>
                        <td><?php echo($row['authorname']); ?></td>
                        <td><?php echo($row['availablebook']); ?></td>
                        <td style="padding:20px 10px"><a href="edit_book.php?bn=<?php echo $row['id']; ?>" class="text-decoration edit-btn font-family">Edit</a><a href="delete_book.php?bn=<?php echo $row['id']?>" class="text-decoration delete-btn font-family" >Delete</a></td>

                       
                    </tr>
                    
                    <?php } ?>
                </tbody>
            </table>
         </form>

    </div>
</section-1>
<?php include "../user_dashboard/footer.php"; ?>

</body>
</html>