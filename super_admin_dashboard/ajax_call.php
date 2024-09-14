<?php
include('check_admin_session.php');
include '../db.php';

$search = $_POST['keyword'];

$CASE = $_POST['CASE'];


switch ($CASE) {
    case "ADD_ISSUE_BOOK":
      $book_data_res = false;
      //$a =  "Your favorite color is red!";
      if(!empty(trim($search))){

        $book_data = "SELECT id,booksrno,bookname FROM  books where booksrno LIKE ". "'%$search%'" ." OR bookname LIKE ". "'%$search%'";
        #$book_data = "SELECT id,booksrno,bookname FROM  books where booksrno LIKE ". "'%$search%'";
        $book_data_res = mysqli_query($connection,$book_data);
        //echo $book_data;
      }
      $i =0;
      $mes ="";
      if(!empty($book_data_res)){
        
        $mes .= "<ul id='country-list' class='issue_ul'>";
        while($book_data_array = mysqli_fetch_assoc($book_data_res)){
          // print_r($book_data_array['id']);
          $res_book_array[$i]['ID'] = $book_data_array['id'];
          $res_book_array[$i]['ISBN'] = $book_data_array['booksrno'];
          $res_book_array[$i]['Name'] = $book_data_array['bookname'];
          $i++;
        }
        //$mes .= "<ul id='country-list' class='list-group'>";
        if(!empty($res_book_array)){
          foreach($res_book_array as $value){
            $book_name = trim($value['Name']);
            $book_srno = trim($value['ISBN']);
            $mes .="<li style='cursor: pointer;' class='issue_li overflow-auto' onClick=selectBookSrNo('$book_srno')>" . $book_name."(".$book_srno . ")</li>";
          }
        } 
        $mes .='</ul>';
      }
     
      echo json_encode($mes);
     
      break;



      case "SEARCH_STUDENT":
        $student_data_res = false;
        //$a =  "Your favorite color is red!";
        if(!empty(trim($search))){
  
          $student_data = "SELECT id,FullName,EmailID FROM  users where EmailID LIKE ". "'%$search%'" ." OR MobileNo LIKE ". "'%$search%'";
          
          $student_data_res = mysqli_query($connection,$student_data);
          
        }
        $i =0;
        $mes ="";
        if(!empty($student_data_res)){
          
          $mes .= "<ul id='country-list' class='issue_ul'>";
          while($student_data_array = mysqli_fetch_assoc($student_data_res)){
            // print_r($book_data_array['id']);
            $res_student_array[$i]['ID'] = $student_data_array['id'];
            $res_student_array[$i]['Name'] = $student_data_array['FullName'];
            $res_student_array[$i]['EmailID'] = $student_data_array['EmailID'];
            $i++;
          }
          //$mes .= "<ul id='country-list' class='list-group'>";
          if(!empty($res_student_array)){
            foreach($res_student_array as $value){
              $f_name = $value['Name'];
              $email_id = $value['EmailID'];
              $mes .="<li class= issue_li overflow-auto' onClick=selectStudentID('$email_id')>" . $f_name."(".$email_id . ")</li>";
            }
          } 
          $mes .='</ul>';
        }
       
        echo json_encode($mes);
       
        break;
      
    
  }