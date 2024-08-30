<?php
include '../db.php';

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($connection, $_GET['query']);

    $book_query = "SELECT * FROM Books WHERE 
                   bookname LIKE '%$search_query%' OR 
                   authorname LIKE '%$search_query%' OR 
                   id LIKE '%$search_query%' OR 
                   booksrno LIKE '%$search_query%' OR 
                   booktype LIKE '%$search_query%'";

    $query_run = mysqli_query($connection, $book_query);
    
    if (mysqli_num_rows($query_run) > 0) {
        echo '<ul>';
        while ($row = mysqli_fetch_assoc($query_run)) {
            echo '<li ><a href="show_book.php?bn=' . $row['id'] . '">' . $row['bookname'] . ' by ' . $row['authorname'] . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No results found</p>';
    }
}
?>
