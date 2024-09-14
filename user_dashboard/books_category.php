<?php
include '../db.php'; // Include database connection
SESSION_start();

$user_id = $_SESSION['userid'];

$user_name="";
$user_email="";

// Fetch user details
$query = "SELECT * FROM Users WHERE id ='$_SESSION[userid]'";
$query_run = mysqli_query($connection, $query); 
while($row = mysqli_fetch_assoc($query_run)){
    $user_name = $row['FullName'];
    $user_email = $row['EmailID'];
    $user_mobile = $row['MobileNo'];
    $user_address = $row['Address'];
}
$Cat_id = 0;
$Cat_name = '';
if (isset($_GET['category'])) {
    $Cat_id = intval($_GET['category']);
}

// Fetch categories for the dropdown
$category_query = "SELECT * FROM category";
$category_result = mysqli_query($connection, $category_query);

// Fetch the selected category name
if ($Cat_id > 0) {
    $category_name_query = "SELECT Cat_Name FROM category WHERE Cat_ID = ?";
    $stmt = $connection->prepare($category_name_query);
    $stmt->bind_param('i', $Cat_id);
    $stmt->execute();
    $stmt->bind_result($Cat_name);
    $stmt->fetch();
    $stmt->close();
}

// Fetch books based on the selected category
$books_query = "SELECT * FROM books WHERE booktype = ?";
$stmt = $connection->prepare($books_query);
$stmt->bind_param('s', $Cat_name); // Bind as a string if `booktype` is a name
$stmt->execute();
$books_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/user_dashboard.css">
    <title>Books by Category</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }
        form {
            display: flex;
            /* justify-content: center; */
            margin-bottom: 20px;
            margin-left: 12px;
        }
        label {
            margin-right: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 200px;
            margin-bottom:10px;
            margin-top: -7px;
        }
        .books-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .books-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .books-list li {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 0px 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            transition: transform 0.3s ease-in-out;
        }
        .books-list li .image img{
            margin:0px 50px;
            width: 150px;
        }
        .books-list li:hover {
            transform: scale(1.05);
        }
        .books-list h2 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }
        .books-list p {
            margin: 5px 0;
            color: #666;
            font-size: 16px;
        }
        .empty{
            height: 300px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include_once('user_nav.php'); ?>
    <h1>Books by Category</h1>
    <form method="GET" action="">
        <label for="category">Select Category:</label>
        <select name="category" id="category" onchange="this.form.submit()">
            <option value="0">Select a Category</option>
            <?php while($Cat = mysqli_fetch_assoc($category_result)): ?>
                <option value="<?php echo $Cat['Cat_ID']; ?>" <?php if($Cat['Cat_ID'] == $Cat_id) echo 'selected'; ?>>
                    <?php echo $Cat['Cat_Name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <div class="books-list row">
        <?php if ($books_result->num_rows > 0): ?>
            <ul class="row">
                <?php while($book = $books_result->fetch_assoc()): ?>
                    <a href="show_book.php?bn=<?php echo $row['id'] ?>" class="text-decoration-b">
                    <li>

                            <div class="image">
                                <img src="../public/assests/bookimage/<?php echo htmlspecialchars($book['bookimage']); ?>" alt="">
                            </div>
                            <h2><?php echo htmlspecialchars($book['bookname']); ?></h2>
                            <p>Author: <?php echo htmlspecialchars($book['authorname']); ?></p>
                            <p>Available: <?php echo htmlspecialchars($book['availablebook']); ?></p>
                        </li>
                    </a>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="empty">No books found in this category.</p>
        <?php endif; ?>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>
