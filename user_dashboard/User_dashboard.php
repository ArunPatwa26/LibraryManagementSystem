<?php
include('../check_session.php');
include '../db.php';
$id = $_SESSION['id'];

$user_name="";
$user_email = "";
$user_mobile="";
$user_address="";

// Fetch user details
$query = "SELECT * FROM Users WHERE EmailID = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query); 
while($row = mysqli_fetch_assoc($query_run)){
    $user_name = $row['FullName'];
    $user_email = $row['EmailID'];
    $user_mobile = $row['MobileNo'];
    $user_address = $row['Address'];
}

// Handle search
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
    $book_query = "SELECT * FROM Books WHERE 
                   bookname LIKE '%$search_query%' OR 
                   authorname LIKE '%$search_query%' OR 
                   id LIKE '%$search_query%' OR 
                   booksrno LIKE '%$search_query%'";
} else {
    $book_query = "SELECT * FROM Books";
}

$query_run = mysqli_query($connection, $book_query);

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
</head>
<body>
    <?php include_once('user_navbar.php'); ?>
    <main-section1>
        <section-1>
            <div class="book-cards column">
                <div class="cards row" style="display:flex; flex-wrap:wrap; justify-content:center">
                    <?php while($row = mysqli_fetch_assoc($query_run)){ 
                        $_SESSION['bookid'] = $row['id'];
                    ?>
                        <div class="card column font-family" style="margin:20px 20px;">
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
</body>
</html>
