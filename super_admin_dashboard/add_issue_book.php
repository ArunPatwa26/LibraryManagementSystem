<?php
include('check_admin_session.php');
include '../db.php';

$admin_name = "";
$admin_email = "";
$book_isbn = "";
$student_id = "";

$query = "SELECT * FROM Admins WHERE EmailID = '$_SESSION[adminemail]'";
$query_run = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query_run)) {
    $admin_name = $row['FullName'];
    $admin_email = $row['EmailID'];
}

$isbn_number = "";
$student_id = "";
$issue_date = "";

// $userid = $_SESSION['userid'];
$error_isbn = "";
$error_student = "";
$error_date = "";
$issue_book_error = "";
$error_flag = 0;
$available_book_error = "";
$error_book_available = "";
$error_book_issue_limit = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_isbn = trim($_POST['book_isbn']);
    $student_id = $_POST['student_id'];
    $issue_date = $_POST['issue_date'];

    $date = strtotime($issue_date);
    $return_date = date('Y-m-d', strtotime("+7 day", $date));
    $admin_userid = $_SESSION['adminid'];

    // Check how many books issued to the user/student
    $check_issue_book_data_count = 0;
    $check_issued_query = "SELECT * FROM issuebooks WHERE studentregid ='$student_id' AND status=0 AND (bookreturnedon = '' OR returndate <>'')";
    $check_issued_result = mysqli_query($connection, $check_issued_query);
    $check_issue_book_data_count = mysqli_num_rows($check_issued_result);

    if ($check_issue_book_data_count == 5) {
        $error_book_issue_limit = "User/Student has already issued 5 books. It is not allowed to issue more.";
        $error_flag = 1;
    } else {
        $book_query = "SELECT id as Book_id, bookname as BookName, availablebook as AvailableBook FROM books WHERE booksrno = '$book_isbn'";
        $book_result = mysqli_query($connection, $book_query);
        $book_data = mysqli_fetch_array($book_result);

        if ($book_data) {
            $book_id = $book_data['Book_id'];
            $available_book = $book_data['AvailableBook'];

            if ($available_book == 0) {
                $error_book_available = "No Book Available for this Book.";
                $error_flag = 1;
            } else {
                $user_query = "SELECT ID as User_id, FullName as UserName, EmailID as LoginUser FROM users WHERE EmailID = '$student_id'";
                $user_result = mysqli_query($connection, $user_query);
                $user_data = mysqli_fetch_array($user_result);

                if ($user_data) {
                    $reg_user_ID = $user_data['User_id'];
                    $user_login_id = $user_data['LoginUser'];

                    // Check if the book is already issued to the user
                    $check_issue_book_query = "SELECT * FROM issuebooks WHERE booksrno = '$book_isbn' AND studentloginid ='$reg_user_ID'";
                    $check_issue_result = mysqli_query($connection, $check_issue_book_query);
                    $check_issue_book_data = mysqli_fetch_array($check_issue_result);

                    if ($check_issue_book_data) {
                        $issue_book_error = "You have already availed this book.";
                        $error_flag = 1;
                    } else {
                        $update_book_available = "UPDATE books SET availablebook = availablebook -1 WHERE id='$book_id' AND booksrno='$book_isbn'";
                        if (mysqli_query($connection, $update_book_available)) {
                            $add_issue_book_query = "INSERT INTO issuebooks (bookid, booksrno, studentregid, studentloginid, userid, issuedate, returndate, created_at) 
                                                     VALUES ('$book_id', '$book_isbn', '$user_login_id', '$reg_user_ID', '$admin_userid', '$issue_date', '$return_date', NOW())";
                            mysqli_query($connection, $add_issue_book_query);
                        }
                    }
                } else {
                    $error_student = "Invalid Student ID.";
                    $error_flag = 1;
                }
            }
        } else {
            $error_isbn = "Invalid ISBN number or book not found.";
            $error_flag = 1;
        }
    }

    // Close the connection
    mysqli_close($connection);
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
    <title>Admin Dashboard</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
$(function(){
    $("#isbn_number").keyup(function(){
        $.ajax({
            url: "ajax_call.php",
            type: 'POST',
            dataType: 'JSON',
            data: { 
                'keyword': $(this).val(),
                'CASE': 'ADD_ISSUE_BOOK'
            },
            success: function(result){
                $("#suggesstion-box1").show();
                $("#suggesstion-box1").html(result);
                $("#studentregid").css("background", "#FFF");
            }
        });
    });

    $("#student_id").keyup(function(){
        $.ajax({
            url: "ajax_call.php",
            type: 'POST',
            dataType: 'JSON',
            data: { 
                'keyword': $(this).val(),
                'CASE': 'SEARCH_STUDENT'
            },
            success: function(result){
                $("#studentSug").show();
                $("#studentSug").html(result);
                $("#studentSug").css("background", "#FFF");
            }
        });
    });

    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if (month < 10) month = '0' + month.toString();
    if (day < 10) day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#inputdate').attr('min', maxDate);
    $('#inputdate').attr('max', maxDate);
});

function selectBookSrNo(val) {
    $("#isbn_number").val(val);
    $("#suggesstion-box1").hide();
}

function selectStudentID(val) {
    $("#student_id").val(val);
    $("#studentSug").hide();
}
</script>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('super_addmin_navbar.php'); ?>
<span>
    <marquee behavior="" direction="" class="text">
        This is Library Management System. Library opens at 8.00 AM and closes at 8.00 PM 
    </marquee>
    <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw; color:blue; font-size:18px;">/Home</a></span>
    <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Issue Book</h1>
    
    <main-section class="column">
        <?php if($error_flag == 1): ?>
            <div style="color:red; text-align:center;">
                <?php
                    if ($issue_book_error != "") {
                        echo $issue_book_error;
                    } elseif ($error_book_available != "") {
                        echo $error_book_available;
                    } elseif ($error_book_issue_limit != "") {
                        echo $error_book_issue_limit;
                    } elseif ($error_isbn != "") {
                        echo $error_isbn;
                    } elseif ($error_student != "") {
                        echo $error_student;
                    }
                ?>
            </div>
        <?php endif; ?>
        <div class="column view-profile">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="column" method="post" enctype="multipart/form-data">
                <div class="form-group column ">
                    <label class="font-light label-size left font-family from-label"> Book ISBN:</label>
                    <input type="text" class="input-box font-family" name="book_isbn" id="isbn_number" value="<?=$book_isbn; ?>">
                    <div id="suggesstion-box1" style="overflow: overlay; overflow-y: scroll; max-height: 100px;" class="issue_list"></div>
                </div>
                <div class="form-group column">
                    <label class="font-light label-size left font-family from-label">Student ID:</label>
                    <input type="text" class="input-box font-family" id="student_id" name="student_id" value="<?=$student_id; ?>">
                    <div id="studentSug" style="overflow: overlay; overflow-y: scroll; max-height: 100px;" class="issue_list"></div>
                </div>
                <div class="form-group column">
                    <label class="font-light label-size left font-family from-label">Issue Date:</label>
                    <input type="date" class="input-box font-family" name="issue_date" id="inputdate" value="<?=$issue_date;?>">
                </div>
                <div class="form-group column">
                    <input type="submit" value="Issue Book" class="btn btn-info form-button font-family" name="submit">
                </div>
            </form>
        </div>
    </main-section>
    <?php include "../user_dashboard/footer.php"; ?>
</body>
</html>
