<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('check_admin_session.php');
include '../db.php';

$admin_name = "";
$admin_email = "";

// Get admin details
$query = "SELECT * FROM Admins WHERE EmailID = '$_SESSION[adminemail]'";
$query_run = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query_run)) {
    $admin_name = $row['FullName'];
    $admin_email = $row['EmailID'];
}

// Initialize response
$response = [
    "success" => false,
    "message" => ""
];

// Fetch `issuebook_id` from the URL
$issuebook_id = isset($_GET['issuebook_id']) ? intval($_GET['issuebook_id']) : 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $issuebook_id = isset($_POST['issuebook_id']) ? intval($_POST['issuebook_id']) : 0;
    $return_date = date('Y-m-d'); // Get current return date

    // Validate `issuebook_id`
    if ($issuebook_id <= 0) {
        $response["message"] = "Invalid issue book ID.";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    // Check if the book was issued
    $check_issue_query = "SELECT * FROM issuebooks WHERE id = '$issuebook_id' AND status = 0";
    $check_issue_result = mysqli_query($connection, $check_issue_query);

    if (mysqli_num_rows($check_issue_result) > 0) {
        $issue_data = mysqli_fetch_assoc($check_issue_result);
        $book_isbn = $issue_data['booksrno'];
        $student_id = $issue_data['studentregid'];
        $due_date = $issue_data['returndate'];

        // Calculate fine if return date has expired
        $fine = 0;
        $days_late = 0;
        if (strtotime($return_date) > strtotime($due_date)) {
            $days_late = (strtotime($return_date) - strtotime($due_date)) / (60 * 60 * 24);
            $fine = $days_late * 3; // Rs. 3 fine per day
        }

        // Update the `issuebooks` table to set the status to 1 and record the return date
        $update_issue_query = "UPDATE issuebooks SET status = 1, bookreturnedon = '$return_date', fine = '$fine', dayslate = '$days_late' WHERE id = '$issuebook_id'";
        if (mysqli_query($connection, $update_issue_query)) {
            // Increment the available books in the `books` table
            $update_book_query = "UPDATE books SET availablebook = availablebook + 1 WHERE booksrno = '$book_isbn'";
            mysqli_query($connection, $update_book_query);

            $response["success"] = true;
            $response["message"] = "Book returned successfully!";
        } else {
            $response["message"] = "Failed to update return information!";
        }
    } else {
        $response["message"] = "No issued book found for this ID!";
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // End script after sending JSON response
}

// Fetch issuebook details for pre-filling the form
if ($issuebook_id > 0) {
    $issuebook_query = "SELECT * FROM issuebooks WHERE id = '$issuebook_id'";
    $issuebook_result = mysqli_query($connection, $issuebook_query);
    if (mysqli_num_rows($issuebook_result) > 0) {
        $issuebook_data = mysqli_fetch_assoc($issuebook_result);
        $book_isbn = $issuebook_data['booksrno'];
        $student_id = $issuebook_data['studentregid'];
        $return_due_date = $issuebook_data['returndate'];
    } else {
        $response["message"] = "No issuebook details found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" href="../public/admin_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#return_form').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission
                $.ajax({
                    url: 'return_issuebook.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log('Raw response:', response); // Log raw response
                        try {
                            let res = JSON.parse(response);
                            alert(res.message);
                            if (res.success) {
                                window.location.href = 'manage_issuebook.php'; // Redirect to the manage issue books page
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            alert('An unexpected error occurred.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', status, error);
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('admin_dash_nav.php'); ?>
<h1 class="font-family" style="background-color:#17a2b8; color:white; margin:20px auto; text-align:center; height:50px; padding:10px 0px; border-radius:10px;">Return Book</h1>
<form id="return_form" action="return_issuebook.php" method="POST" style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
    <input type="hidden" name="issuebook_id" value="<?php echo htmlspecialchars($issuebook_id, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="form-group">
        <label for="book_isbn">Book ISBN:</label>
        <input type="text" id="book_isbn" name="book_isbn" value="<?php echo htmlspecialchars($book_isbn ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($student_id ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="return_due_date">Return Due Date:</label>
        <input type="text" id="return_due_date" name="return_due_date" value="<?php echo htmlspecialchars($return_due_date ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="days_late">Days Late:</label>
        <input type="text" id="days_late" name="days_late" value="<?php echo isset($days_late) ? htmlspecialchars($days_late, ENT_QUOTES, 'UTF-8') : '0'; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="total_fine">Total Fine (Rs.):</label>
        <input type="text" id="total_fine" name="total_fine" value="<?php echo isset($fine) ? htmlspecialchars($fine, ENT_QUOTES, 'UTF-8') : '0'; ?>" readonly>
    </div>
    <button type="submit" class="update-button font-family">Return Book</button>
</form>
<?php include "../user_dashboard/footer.php"; ?>
</body>
</html>
