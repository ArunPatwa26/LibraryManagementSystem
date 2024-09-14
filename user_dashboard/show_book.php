<?php
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

// Fetch related books from the same category
$related_books_query = "SELECT * FROM Books WHERE booktype = ? AND id != ? LIMIT 5";
$stmt_related = $connection->prepare($related_books_query);
$stmt_related->bind_param('si', $type, $book_id);
$stmt_related->execute();
$related_books_result = $stmt_related->get_result();

// Fetch random books for suggestions
$suggested_books_query = "SELECT * FROM Books ORDER BY RAND() LIMIT 4";
$suggested_books_query_run = mysqli_query($connection, $suggested_books_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@200;300;400;700;800&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/user_dashboard.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .mainsection {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .parts {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
        }

        .part1 img {
            max-width: 350px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .part2 {
            max-width: 700px;
            padding: 0 20px;
        }

        .part2 h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .part2 p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .part2 p span {
            font-weight: 600;
            color: #555;
        }

        .button-available {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .button-not-available {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .text-summary {
            margin-top: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .text-summary h1 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #444;
        }

        .text-summary p {
            font-size: 18px;
            line-height: 1.6;
            color: #666;
        }

        .related-books, .suggested-books {
            margin-top: 40px;
        }

        .related-books h2, .suggested-books h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 20px;
            margin: 25px 51px;
        }

        .related-books-list, .suggested-books-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 0px 55px
        }

        .related-book-item, .suggested-book-item {
            width: 180px;
            text-align: center;
            margin: 0 20px;
        }

        .related-book-item img, .suggested-book-item img {
            width: 100%;
            height: 239px;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .related-book-item img:hover, .suggested-book-item img:hover {
            transform: scale(1.05);
        }

        .related-book-item p, .suggested-book-item p {
            font-size: 16px;
            margin-top: 10px;
            color: #555;
        }

        .related-book-item a, .suggested-book-item a {
            text-decoration: none;
            color: inherit;
        }
        .suggested-books {
    margin-top: 40px;
}

.suggested-books h2 {
    font-size: 26px;
    color: #333;
    margin-bottom: 20px;
    margin: 25px 51px;
}

.suggested-books-slider {
    position: relative;
    overflow: hidden;
}

.suggested-books-list {
    display: flex;
    overflow-x: scroll;
    scroll-behavior: smooth;
    gap: 20px;
}

.suggested-book-item {
    min-width: 180px;
    text-align: center;
    margin: 0 20px;
}

.suggested-book-item img {
    width: 100%;
    height: 239px;
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.suggested-book-item img:hover {
    transform: scale(1.05);
}

.slider-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}

    </style>
    <title>Book Details</title>
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
                        <button class="button-available" onclick="availableBook()">Available</button>
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

         

            <!-- Suggested Books Section -->
            <!-- Suggested Books Section -->
<div class="suggested-books">
    <h2>Suggested Books</h2>
    <div class="suggested-books-slider">
        <button class="slider-button prev" onclick="scrollSlider(-1)">&#10094;</button>
        <div class="suggested-books-list">
            <?php while ($suggested_book = mysqli_fetch_assoc($suggested_books_query_run)): ?>
            <div class="suggested-book-item">
                <a href="show_book.php?bn=<?php echo $suggested_book['id']; ?>">
                    <img src="../public/assests/bookimage/<?php echo htmlspecialchars($suggested_book['bookimage']); ?>" alt="Suggested Book">
                    <p><?php echo htmlspecialchars($suggested_book['bookname']); ?></p>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <button class="slider-button next" onclick="scrollSlider(1)">&#10095;</button>
    </div>
</div>


        </main-section>
    </div>
    <?php include_once('footer.php'); ?>
    <script>
        function scrollSlider(direction) {
    const slider = document.querySelector('.suggested-books-list');
    const scrollAmount = 300; // Adjust the scroll amount as needed
    slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
}
function availableBook(){
    alert("book available in library you can issue from the library");
}

    </script>
    
</body>
</html>
