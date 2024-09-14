<?php
include 'db.php'; // Include database connection

if (isset($_POST['state_id'])) {
    $state_id = $_POST['state_id'];
    
    $query = "SELECT * FROM cities WHERE state_id = $state_id";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select city</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    } else {
        echo '<option value="">No cities available</option>';
    }
}
?>
