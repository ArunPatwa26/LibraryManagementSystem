<?php
// session_start();
include('../check_session.php');
include '../db.php';

$user_name = "";
$user_email = "";
$user_mobile = "";
$user_address = "";

// Fetch user details
$query = "SELECT * FROM Users WHERE id ='$_SESSION[userid]'";
$query_run = mysqli_query($connection, $query); 
while($row = mysqli_fetch_assoc($query_run)){
    $user_name = $row['FullName'];
    $user_email = $row['EmailID'];
    $user_mobile = $row['MobileNo'];
    $user_address = $row['Address'];
}
// Include your database connection file

// Check if the connection to the database is successful


// Check if the user is logged in by verifying the session
if (!isset($_SESSION['userid'])) {
    die("User is not logged in.");
}

// Get the logged-in user's ID
$userId = $_SESSION['userid'];

// Fetch issued books for the logged-in user
$query = "
    SELECT issuebooks.issuedate, issuebooks.returndate, issuebooks.status,
           books.bookname, books.authorname, books.bookimage 
    FROM issuebooks
    JOIN books ON issuebooks.bookid = books.id
    WHERE issuebooks.studentloginid = ?
";

$stmt = $connection->prepare($query);
if (!$stmt) {
    die("Error in query preparation: " . $connection->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/">
    <link rel="stylesheet" href="../public/user_dashboard.css"> <!-- Link your CSS file here -->
    <title>My Issued Books</title>
    <style>
       
       .container h2 {
            text-align: center;
            font-size: 2em;
            margin: 20px 0;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding-bottom: 80px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1em;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 16px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #fdfdfd;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        img {
            width: 166px;
    height: 250px;
    object-fit: cover;
    position: relative;
    left: 46px;
    /* margin: 0px 29px; */
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .no-books {
            text-align: center;
            font-size: 1.2em;
            color: #666;
            margin: 40px 0;
        }

        @media screen and (max-width: 768px) {
            th, td {
                padding: 12px;
                font-size: 0.9em;
            }

            img {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <?php include "user_nav.php" ?>
    <div class="container">
        <h2 class="font-family">My Issued Books</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead class="font-family">
                    <tr>
                        <th>Book Image</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><img src="../public/assests/bookimage/<?php echo htmlspecialchars($row['bookimage']); ?>" alt="Book Image"></td>
                            <td><?php echo htmlspecialchars($row['bookname']); ?></td>
                            <td><?php echo htmlspecialchars($row['authorname']); ?></td>
                            <td><?php echo htmlspecialchars($row['issuedate']); ?></td>
                            <td><?php echo htmlspecialchars($row['returndate']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p class="no-books">You have not issued any books yet.</p>
                    <?php endif; ?>
                    
                    <?php
        $stmt->close();
        $connection->close();
        ?>
    </div>
    <?php include "footer.php" ?>
</body>
</html>
