<?php 
// Number Of User Count
function get_user_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as user_count from Users";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $user_count=$row['user_count'];
    }
    return($user_count);
}

// Number of Book Count
function get_book_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as book_count from Books";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $book_count=$row['book_count'];
    }
    return($book_count);
}
// Number of Category count
function get_category_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as category_count from Category";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $category_count=$row['category_count'];
    }
    return($category_count);
}
// Number Of Authors Count
function get_author_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as author_count from Category";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $author_count=$row['author_count'];
    }
    return($author_count);
}
function get_issuebooks_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as issuebook_count from Issuebooks";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $issuebook_count=$row['issuebook_count'];
    }
    return($issuebook_count);
}
// Number of Admins Count
function get_admin_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as admin_count from Admins";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $admin_count=$row['admin_count'];
    }
    return($admin_count);
}
// Number of events Count
function get_events_count(){
    $connection = mysqli_connect("localhost","root","root");
    $db =mysqli_select_db($connection,"library");
    $query="select count(*) as event_count from notification_box";
    $query_run=mysqli_query($connection,$query);
    while($row =mysqli_fetch_assoc($query_run)){
        $event_count=$row['event_count'];
    }
    return($event_count);
}
?>