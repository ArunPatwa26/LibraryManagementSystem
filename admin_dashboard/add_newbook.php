<?php
include('../check_session.php');
include '../db.php';
$admin_name="";
$admin_email = "";



$query="select * from Admins where EmailID = '$_SESSION[email]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
}


    $name = "";
    $type =  "";
    $authorname = "";
    $availablebook =  "";
    $booksrno =  "";
    $booksummary = "";
    $publisher =  "";
    $imageName ="";
    $userid =$_SESSION['id'];
    $error_name ="";
    $error_type ="";
    $error_image="";
    $error_authname="";
    $error_booksrno="";
    $error_availablebook="";
    $error_booksummary="";
    $error_publisher="";
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        $name = trim($_POST['bookname']);
        if($name ==""){
            $error_name ="Enter Valid Book Name.";
        } else {
            if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/',$name)) {
                $error_name ="Enter Valid Book Name Use Only Alpha Numeric dont use special symbols.";
            }
        }

        $type =  $_POST['booktype'];
        if($type ==""){
            $error_type = "Select valid Book Category";
        }

        $authorname = $_POST['authorname'];
        if($authorname==""){
            $error_authname = "Enter Valid Author Name.";
        }

        $availablebook =  $_POST['availablebook'];
        if($availablebook==""){
            $error_availablebook = "Enter Valid SRNO.";
        }


        $booksrno =  $_POST['booksrno'];
        if($booksrno==""){
            $error_booksrno = "Enter Valid SRNO.";
        }else {
            if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/',$booksrno)) {
                $error_booksrno ="Enter Valid SRNO use Alpha Numeric.";
            }
        }

        $booksummary = trim($_POST['booksummary']);
        if($booksummary ==""){
            $error_booksummary ="Enter Valid Book Summary.";
        }else {
            if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/',$booksrno)) {
                $error_booksrno ="Enter Valid Summary use Alpha Numeric. dont use extra Symbols";
            }
        }

        $publisher =  $_POST['bookpublisher'];
        if($publisher ==""){
            $error_publisher ="Enter Valid Publisher Name.";
        }else {
            if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/',$booksrno)) {
                $error_booksrno ="Enter Valid Publisher use Alpha Numeric. dont use extra Symbols";
            }
        }

        //  $image = $_POST['bookimage'];
        // if($image==""){
        //     $error_image ="Enter Valid Image.";
        // }
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $target_dir = "../public\assests\bookimage/";
    $target_file = $target_dir . basename($_FILES["bookimage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["bookimage"]["tmp_name"]);
    if($check !== false) {
        $error_image="File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $error_image="File is not an image.";
        $uploadOk = 0;
    }
    }

    if (file_exists($target_file)) {
    $error_image="Sorry, file already exists.";
    $uploadOk = 0;
    }

    if ($_FILES["bookimage"]["size"] > 5000000) {
        $error_image="Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $error_image="Sorry, only JPG, JPEG & PNG files are allowed.";
    $uploadOk = 0;
    }


if ($uploadOk == 0) {
  $error_image="Sorry, your file was not uploaded.";

} else {
  if (move_uploaded_file($_FILES["bookimage"]["tmp_name"], $target_file)) {
    $error_image="The file ". htmlspecialchars( basename( $_FILES["bookimage"]["name"])). " has been uploaded.";
  } else {
    $error_image="Sorry, there was an error uploading your file.";
  }
}
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){



  // Check the connection
  if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $admin_id = "";

  $name = trim($_POST['bookname']);
  $type =  $_POST['booktype'];
  $authorname = $_POST['authorname'];
  $availablebook =  $_POST['availablebook'];
  $booksrno =  $_POST['booksrno'];
  $booksummary = trim(addslashes($_POST['booksummary']));
  $publisher =  $_POST['bookpublisher'];
  $imageName =($_FILES["bookimage"]["name"]);
  $userid =$_SESSION['id'];

  // Correct SQL query syntax
  $query ="INSERT INTO books (bookname, booktype, authorname, availablebook, booksrno, booksummary, bookpublisher, bookimage, userid, created_at, updated_at) 
            VALUES ('$name', '$type', '$authorname', $availablebook, '$booksrno', '$booksummary', '$publisher', '$imageName', $userid, NOW(), NOW())";

  $_query_run = mysqli_query($connection, $query);

  if ($_query_run) {
      echo "<script type='text/javascript'>
              alert('Registration Successfully.... You May login now..');
              window.location.href='view_manage_books.php';
            </script>";
  } else {
      echo "<script type='text/javascript'>
              alert('Error: " . mysqli_error($connection) . "');
              window.location.href='view_manage_books.php';
            </script>";
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
    <title>Admin dashboard</title>
</head>
<body>
<?php include_once('admin_navbar.php'); ?>
<?php include_once('admin_dash_nav.php'); ?>
<span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
        <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Add Books</h1>

        <main-section class="column">
        <div class="column view-profile">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="column" method="post" enctype="multipart/form-data">
                    <div class="form-group column ">
                        <label  class="font-light label-size left font-family  from-label"> Book Title:</label>
                        <input type="text" class="input-box font-family"  name="bookname" value="<?php echo $name;?>">
                        <span style="color:red;"><?php echo $error_name; ?></span>
                    </div>
                    <div class="form-group column">
                    <label  class="font-light label-size left font-family  from-label"> Book Type:</label>
                        <div class="col-sm-5">
                        <select class="custom-select" name="booktype" id="booktype" style="width: 800px; height: 45px; border-radius: 6px; padding: 0px 10px;">
                            <option value="">Select Book Type</option>
                        
                        <?php
                            $user_query="select * from Category";
                            $option_query_run=mysqli_query($connection,$user_query);
                            while($row=mysqli_fetch_assoc($option_query_run)){ ?>
                                <option value="<?php echo $row['Cat_Name']; ?>" <?=$type ==$row['Cat_Name'] ? 'selected="selected"' : '' ?>><?php echo $row['Cat_Name']; ?></option>
                       
                        <?php } ?>

                        </select>
                    </div>
                    <span style="color:red;"><?php echo $error_type; ?></span>
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Author name:</label>
                        <input type="text" class="input-box font-family"  name="authorname">
                        <span style="color:red;"><?php echo $error_authname; ?></span>
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Book ISBN:</label>
                        <input type="text" class="input-box font-family"  name="booksrno">
                        <span style="color:red;"><?php echo $error_booksrno; ?></span>
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">No Of Books:</label>
                        <div class="col-sm-5">
                <select class="custom-select"  name="availablebook" id="availablebook" style="width: 800px; height: 45px; border-radius: 6px; padding: 0px 10px;">
                     <option value="">Select Book Available</option>
                     <?php for($i =1;$i<=100;$i++) : ?>
                        <option value="<?=$i;?>"> <?=$i;?></option>
                        <?php endfor;?>
                        
                  </select>
                </div>
                <span style="color:red;"><?php echo $error_availablebook; ?></span>
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Upload Book Image:</label>
                        <input type="file" class="input-box font-family" name="bookimage" style="margin:4px 0px; padding:8px 10px;">
                        <span style="color:red;"><?php echo $error_image; ?></span>
                        
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Book Publisher:</label>
                        <input type="text" class="input-box font-family" name="bookpublisher">
                        <span style="color:red;"><?php echo $error_publisher; ?></span>
                    </div>
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Books Summary:</label>
                        <div class="col-sm-5">
                    <textarea class="form-control"  style="height: 238px;" id="booksummary" name="booksummary" placeholder="Enter Summary"></textarea>
                    
                </div>
                <span style="color:red;"><?php echo $error_booksummary; ?></span>
                    </div>
                   
                    <button class="update-button font-family">Add Book</button>
        </form>
        </div>

    </main-section>


        
</span>
</body>
</html>