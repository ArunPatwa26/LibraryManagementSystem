<?php
include('../check_session.php');
include '../db.php';
$admin_name="";
$admin_email = "";

$book_isbn= "";
$student_id = "";

$query="select * from Admins where EmailID = '$_SESSION[email]'";
$query_run=mysqli_query($connection,$query); 
while($row =mysqli_fetch_assoc($query_run)){
    $admin_name=$row['FullName'];
    $admin_email=$row['EmailID'];
}


    $isbn_number = "";
    $student_id =  "";
    $issue_date = "";
  


    $userid =$_SESSION['id'];
    $error_isbn ="";
    $error_student="";
    $error_date ="";
    $issue_book_error="";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        /**   */
        $book_isbn = trim($_POST['book_isbn']);
        $student_id =  $_POST['student_id'];
        $issue_date = $_POST['issue_date'];


        $date = $issue_date;
        $date = strtotime($date);
        $date = strtotime("+7 day", $date);
        $return_date =  date('Y-m-d', $date);
        $admin_id = "";
        $admin_userid =$_SESSION['id'];

        $book_query = "SELECT id as Book_id,bookname as BookName,availablebook as AvailableBook from books where booksrno =  '$book_isbn'";
        $book_result = mysqli_query($connection,$book_query);
        $book_data = mysqli_fetch_array( $book_result );
        $book_id = $book_data['Book_id'];
        $available_book = $book_data['AvailableBook'];


        $user_query = "SELECT ID as User_id,FullName as UserName,EmailID as LoginUser from users where EmailID =  '$student_id'";
        //echo $user_query; die;
        $user_result = mysqli_query($connection,$user_query);
        $user_data = mysqli_fetch_array( $user_result );
        $reg_user_ID = $user_data['User_id'];
        $user_login_id = $user_data['LoginUser'];

        /* Check already book is issued to users*/

        $check_issue_book_query = "SELECT * FROM issuebooks where booksrno = '$book_isbn' and  studentloginid ='$reg_user_ID'";
        #echo $check_issue_book_query; die;
        $check_issue_result = mysqli_query($connection,$check_issue_book_query);
        $check_issue_book_data = mysqli_fetch_array( $check_issue_result );
        if(count($check_issue_book_data)>0){
            $issue_book_error = "You have already availed this book.";
        } else {
            if($book_id>0){
                $query ="INSERT INTO issuebooks 
                    (bookid, booksrno, studentregid,studentloginid,userid,issuedate,returndate, created_at) 
                 VALUES ('$book_id ', '$book_isbn','$user_login_id' ,'$reg_user_ID','$admin_userid','$issue_date', '$return_date', NOW())";
    
                 //echo $query; die;
    
            }
        }
        #$due_returndate = $user_data['returndate'];
        #$delayday = $user_data['delayday'];

       /* end */
        // if($book_isbn ==""){
        //     $error_isbn ="Enter Valid Book Name.";
        // } else {
        //     if (!preg_match('/[^a-zA-Z0-9]/',$book_isbn)) {
        //         $error_isbn ="Enter Valid Book Name Use Only Alpha Numeric dont use special symbols.";
        //     }
        // }


        // if($book_isbn ==""){
        //     $error_isbn ="Enter Valid Book Name.";
        // } else {
        //     if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/',$book_isbn)) {
        //         $error_isbn ="Enter Valid Book Name Use Only Alpha Numeric dont use special symbols.";
        //     }
        // }
       

    

       

       
        //echo $book_data; die;
        

  // Correct SQL query syntax

//   $_query_run = mysqli_query($connection, $query);

//   if ($_query_run) {
//       echo "<script type='text/javascript'>
//               alert('Registration Successfully.... You May login now..');
//               window.location.href='view_manage_books.php';
//             </script>";
//   } else {
//       echo "<script type='text/javascript'>
//               alert('Error: " . mysqli_error($connection) . "');
//               window.location.href='view_manage_books.php';
//             </script>";
//   }

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
$(function(){

    // ajax call
    $("#isbn_number").keyup(function(){
        //alert($(this).val());
        $.ajax({
            url: "ajax_call.php",
            type:'POST',
            dataType:'JSON', 
            data: { 
                'keyword' : $(this).val(),
                'CASE':'ADD_ISSUE_BOOK'
            },
            success: function(result){
                //alert(result);
                $("#suggesstion-box1").show();
				    $("#suggesstion-box1").html(result);
				    $("#studentregid").css("background", "#FFF");

            }
        });
        
  });

  $("#student_id").keyup(function(){
        //alert($(this).val());
        $.ajax({
            url: "ajax_call.php",
            type:'POST',
            dataType:'JSON', 
            data: { 
                'keyword' : $(this).val(),
                'CASE':'SEARCH_STUDENT'
            },
            success: function(result){
                //alert(result);
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
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
     day = '0' + day.toString();
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
<?php include_once('admin_dash_nav.php'); ?>
<span>
        <marquee behavior="" direction="" class="text">
            This is Library Management System Library opens at 8.00 AM and close at 8.00 PM 
        </marquee>
        <span><a href="admin_dashboard.php" class="font-family text-decoration-b" style="margin:20px 0px; position:relative; left: 88vw;  color:blue; font-size:18px;">/Home</a></span>
        <h1 class="font-family" style="background-color:#17a2b8; width:1100px; color:white; margin:20px auto; text-align:center; height:50px; padding:0px 0px; border-radius:10px;">Issue Book</h1>
        <div style="color:red;"> 
            <?php 
            if($issue_book_error !=""){
                echo $issue_book_error;
            }
            ?>
            </div>
        <main-section class="column">
        <div class="column view-profile">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="column" method="post" enctype="multipart/form-data">
                    <div class="form-group column ">
                        <label  class="font-light label-size left font-family  from-label"> Book ISBN:</label>
                        <input type="text" class="input-box font-family"  name="book_isbn" id="isbn_number" value="<?=$book_isbn; ?>">
                        <div id="suggesstion-box1" style="overflow: overlay; overflow-y: scroll;max-height: 100px;" class="issue_list"></div>
                        <span style="color:red;"><?php echo $error_isbn; ?></span>
                        <p id="test"></p>
                    </div>
                    
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Student ID:</label>
                        <input type="text" class="input-box font-family"  name="student_id"  id="student_id" value="<?=$student_id; ?>">
                        <div id="studentSug" style="overflow: overlay; overflow-y: scroll;max-height: 100px;" class="issue_list"></div>
                        <span style="color:red;"><?php   ?></span>
                    </div>
                   
                    <div class="form-group column " >
                        <label  class="font-light label-size left font-family">Issue Date:</label>
                        <input type="date" class="input-box font-family" id="inputdate" name="issue_date" style="margin:4px 0px; padding:8px 10px;" value="<?php echo date('Y-m-d'); ?>" >
                        <span style="color:red;"><?php  ?></span>
                      
                        
                    </div>
                  
                   
                    <button class="update-button font-family">Issue Book</button>
        </form>
        </div>

    </main-section>


        
</span>
</body>
</html>