<?php
include 'db.php'; // Include database connection

if (isset($_POST['country_id'])) {
    $country_id = $_POST['country_id'];
    
    $query = "SELECT * FROM states WHERE country_id = $country_id";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select state</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    } else {
        echo '<option value="">No states available</option>';
    }
}
?>
