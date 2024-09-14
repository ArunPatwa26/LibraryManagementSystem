<?php
include('../check_session.php');
include '../db.php';
$id = $_SESSION['userid'];

$user_name="";
$user_email = "";
$user_mobile="";
$user_address="";

// Fetch user details
$query = "SELECT * FROM Users WHERE id ='$_SESSION[userid]'";
$query_run = mysqli_query($connection, $query); 
while($row = mysqli_fetch_assoc($query_run)){
    $user_name = $row['FullName'];
    $user_email = $row['EmailID'];
    $user_mobile = $row['MobileNo'];
    $user_address = $row['Address'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@200;300;400;700;800&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/user_dashboard.css">
    <title>Document</title>
</head>
<body>
<?php include_once('user_nav.php'); ?>
<div class="contact-section font-family" id="contact" style="background-color:whitesmoke; padding:60px 20px; margin:30px 80px;border-radius:4px">
        <h1 >Contact To Librarian</h1>
        <form action="https://api.web3forms.com/submit" method="POST" class="contact-form">

            <div class="form" >
                <input type="hidden" name="access_key" value="393550ec-41ad-4745-a6c9-5b2d3ff97ff6">
                <input type="text" name="Name" placeholder="Your Name" id="name" required>
                <input type="email" name="Email" placeholder="Your Email" id="email" required>
                <input type="text" name="Subject" placeholder="Title" id="subject" required>
                <textarea rows="4" cols="20" name="Message" placeholder=" Message" id="message" required></textarea>
                <button onclick="send()" class="contact-send-btn font-family">Send</button>
            </div>
            </form>
    </div>
    <?php include_once('footer.php'); ?>
    <script>
        function send(){
            console.log("hello")
            let name = document.getElementById("name").value
            let email = document.getElementById("email").value
            let subject = document.getElementById("subject").value
            let message = document.getElementById("message").value
            if (!name || !email || !subject || !message) {
                alert("Please Fill the form first")
            } else {
                alert("From Submited Successfully")
            }
               
        }
    </script>
</body>
</html>