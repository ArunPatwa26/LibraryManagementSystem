<?php
require('function.php');
include('check_admin_session.php');
include '../db.php';

// Initialize variables
$admin_name = "";
$admin_email = "";

// Fetch admin details
$query = "SELECT * FROM Admins WHERE EmailID = '$_SESSION[adminemail]'";
$query_run = mysqli_query($connection, $query); 
while ($row = mysqli_fetch_assoc($query_run)) {
    $admin_name = $row['FullName'];
    $admin_email = $row['EmailID'];
}

// Fetch issued books
$user_query = "SELECT * FROM issuebooks";
$book_query_run = mysqli_query($connection, $user_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/admin_dashboard.css">
    <title>Admin Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

    <script>
        $(document).ready(function () {
            $('#issue_book').DataTable();
        });
    </script>
    <style>
        .status-returned {
            color: green;
            font-weight: bold;
        }
        .status-not-returned {
            color: red;
            font-weight: bold;
        }
        .return-checkmark {
            color: green;
            font-size: 18px;
        }
    </style>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('admin_dash_nav.php'); ?>
<span>
    <marquee behavior="" direction="" class="text">
        This is Library Management System. Library opens at 8.00 AM and closes at 8.00 PM.
    </marquee>
</span>
<span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw; color:blue; font-size:18px;">/Home</a></span>
<h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Manage Issue Books</h1>
<button class="update-button font-family" style="position:relative; left:82vw; margin-bottom:20px; padding:-4px 10px;">
    <a href="add_issue_book.php" class="text-decoration" style="padding:6px 6px;">Issue Books</a>
</button>

<section>
    <div class="row table-center table">
        <form action="" class="row table-center">
            <table id="issue_book" class="display">
                <thead>
                    <tr>
                        <th>Issue Book ID</th>
                        <th>Student ID</th>
                        <th>Book Serial No</th>
                        <th>Issue Date</th>
                        <th>Return Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($book_query_run)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['studentregid']; ?></td>
                        <td><?php echo $row['booksrno']; ?></td>
                        <td><?php echo $row['issuedate']; ?></td>
                        <td><?php echo $row['returndate']; ?></td>
                        <td>
                            <?php if ($row['status'] == 1) { ?>
                                <span class="status-returned">
                                    Returned <i class="fa fa-check return-checkmark" aria-hidden="true"></i>
                                </span>
                            <?php } else { ?>
                                <span class="status-not-returned">Not Returned</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 0) { ?>
                                <a href="return_issuebook.php?issuebook_id=<?php echo $row['id']; ?>" class="text-decoration-b return-btn font-family">Return</a>
                            <?php } ?>
                            <a href="edit_book.php?bn=<?php echo $row['id']; ?>" class="text-decoration edit-btn font-family">Edit</a>
                            <a href="delete_book.php?bn=<?php echo $row['id']; ?>" class="text-decoration delete-btn font-family">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</section>
<?php include "../user_dashboard/footer.php"; ?>

</body>
</html>
