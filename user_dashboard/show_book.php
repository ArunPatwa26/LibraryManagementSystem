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

$book_id = 0;
if (isset($_GET['bn'])) {
    $book_id = intval($_GET['bn']);
}

// Fetch book data
$query = "SELECT * FROM Books WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $book_id);
$stmt->execute();
$book_data = $stmt->get_result()->fetch_assoc();

if ($book_data) {
    $name = $book_data['bookname'];
    $type = $book_data['booktype'];
    $authorname = $book_data['authorname'];
    $availablebook = $book_data['availablebook'];
    $booksrno = $book_data['booksrno'];
    $booksummary = $book_data['booksummary'];
    $publisher = $book_data['bookpublisher'];
    $imageName = $book_data['bookimage'];
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
    <title>User Dashboard</title>
</head>
<body>
    <?php include_once('user_nav.php'); ?>

    <div class="mainsection">
        <main-section class="column">
            <div class="parts row">
                <div class="part1">
                    <img src="../public/assests/bookimage/<?php echo htmlspecialchars($imageName); ?>" alt="">
                </div>
                <div class="part2">
                    <div class="text font-family-light">
                        <h1>Title: <?php echo htmlspecialchars($name); ?></h1>
                        <p><span>Author</span>: <?php echo htmlspecialchars($authorname); ?></p>
                        <p><span>Language</span>: English</p>
                        <p><span>Book Category</span>: <?php echo htmlspecialchars($type); ?></p>
                        <p><span>ISBN</span>: <?php echo htmlspecialchars($booksrno); ?></p>
                        <p><span>Book Published</span>: <?php echo htmlspecialchars($publisher); ?></p>
                        <p><span>Book Available</span>: <?php echo htmlspecialchars($availablebook); ?></p>

                        <!-- Conditional button rendering -->
                        <?php if ($availablebook > 0): ?>
                        <button class="button-available">Available</button>
                    <?php else: ?>
                        <button class="button-not-available">Not Available</button>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-summary">
                <h1>About the Book</h1>
                <p><?php echo htmlspecialchars($booksummary); ?></p>
            </div>
        </main-section>
    </div>
</body>
</html>
