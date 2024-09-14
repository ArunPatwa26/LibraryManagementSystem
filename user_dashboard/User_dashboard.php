<?php
include('../check_session.php');
include '../db.php';
$userid = $_SESSION['userid'];

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

$limit = 8;  // Number of books per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle search
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
    $book_query = "SELECT * FROM Books WHERE 
                   bookname LIKE '%$search_query%' OR 
                   authorname LIKE '%$search_query%' OR 
                   id LIKE '%$search_query%' OR 
                   booksrno LIKE '%$search_query%' 
                   LIMIT $limit OFFSET $offset";  // Limit the results
} else {
    $book_query = "SELECT * FROM Books LIMIT $limit OFFSET $offset";  // Limit the results
}

$query_run = mysqli_query($connection, $book_query);

// Fetch the total number of books for pagination
$total_books_query = "SELECT COUNT(*) as total FROM Books";
$total_books_result = mysqli_query($connection, $total_books_query);
$total_books_row = mysqli_fetch_assoc($total_books_result);
$total_books = $total_books_row['total'];

// Calculate total pages
$total_pages = ceil($total_books / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@200;300;400;700;800&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/user_dashboard.css">
    <style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .pagination-btn {
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        padding: 8px 16px;
        margin: 0 5px;
        border-radius: 5px;
        color: #333;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }

    .pagination-btn:hover {
        background-color: #17a2b8;
        color: white;
    }

    .pagination-btn.active {
        background-color: #17a2b8;
        color: white;
        font-weight: bold;
        border-color: #17a2b8;
    }

    .pagination-btn:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(23, 162, 184, 0.5);
    }
    .slider-container {
    width: 100%;
    max-width: 1400px; /* Set a max width to prevent overly large images */
    height: 600px; /* Adjust to fit your design */
    margin: 20px auto;
    position: relative;
    overflow: hidden;
    border-radius: 6px; /* Optional: Adds rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds subtle shadow */
}

.slider {
    display: flex;
    transition: transform 1s ease-in-out;
    /* width: 100%; Adjust according to the number of slides */
}

.slide {
    min-width: 100%; /* Ensure each slide takes full width */
    transition: opacity 3s ease-in-out;
}

.slide img {
    width: 100%; /* Makes the images responsive */
    height: 100%; /* Ensures the image fills the container */
    /* object-fit: cover; Ensures the image scales without distortion */
    /* border-radius: 10px; */
    /* display: block; */
}

/* Optional: Add some pagination dots */
.slider-container .dots {
    text-align: center;
    position: absolute;
    width: 100%;
    bottom: 20px;
    display: flex;
    justify-content: center;
}

.dots span {
    height: 10px;
    width: 10px;
    margin: 0 5px;
    display: inline-block;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    cursor: pointer;
}

.dots span.active {
    background-color: #17a2b8;
}
</style>
</head>

<body>
    <?php include_once('user_navbar.php'); ?>

    <div class="slider-container">
    <div class="slider">
        <div class="slide">
            <img src="../public/assests/slidderimg1.jpeg" alt="Slider Image 1">
        </div>
        <div class="slide">
            <img src="../public/assests/slidderimg2.jpe" alt="Slider Image 2">
        </div>
        <div class="slide">
            <img src="../public/assests/slidderimg3.jpeg" alt="Slider Image 3">
        </div>
    </div>
</div>
    <main-section1>
        <div class="text">

            <h1 class="text-center font-family">Books</h1>
        </div>
        <section-1>
            <div class="book-cards column">
                <div class="cards row" style="display:flex; flex-wrap:wrap; justify-content:center">
                    <?php while($row = mysqli_fetch_assoc($query_run)){ 
                        $_SESSION['bookid'] = $row['id'];
                    ?>
                        <div class="card column font-family" style="margin:20px 20px;">
                            <a href="show_book.php?bn=<?php echo $row['id'] ?>" class="text-decoration-b">
                                <div class="img">
                                    <img src="../public/assests/bookimage/<?php echo($row['bookimage']); ?>" alt="book image">
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

            <!-- Pagination Links -->
            <div class="pagination" style="text-align:center; margin:20px;">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>" class="btn text-decoration-b pagination-btn">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="btn text-decoration-b pagination-btn <?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>" class="btn text-decoration-b pagination-btn">Next</a>
    <?php endif; ?>
</div>

        </section-1>
    </main-section1>
    <?php include_once('footer.php'); ?>

    

    <script>
        function searchBooks() {
            var query = document.getElementById('search').value;

            if (query.length > 0) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById('searchResults').innerHTML = xhr.responseText;
                        document.getElementById('searchResults').style.display = 'block';
                    }
                };
                xhr.open('GET', 'search_books.php?query=' + encodeURIComponent(query), true);
                xhr.send();
            } else {
                document.getElementById('searchResults').innerHTML = '';
                document.getElementById('searchResults').style.display = 'none';
            }
        }

        function toggleClearButton() {
            var searchInput = document.getElementById('search');
            var clearButton = document.getElementById('clearButton');
                clearButton.style.display = 'block';
            }
        

        function clearSearch() {
            document.getElementById('search').value = '';
            document.getElementById('searchResults').innerHTML = '';
            document.getElementById('searchResults').style.display = 'none';
            document.getElementById('clearButton').style.display = 'none'; // Hide clear button
            document.getElementById('search').focus(); // Focus back to the search input
        }
    </script>


<!-- Slider Script -->
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slider .slide');
const totalSlides = slides.length;

function showNextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    const slider = document.querySelector('.slider');
    slider.style.transform = 'translateX(' + (-currentSlide * 100) + '%)';
}

// Auto-slide every 3 seconds
setInterval(showNextSlide, 3000);
</script>
   
</body>
</html>
