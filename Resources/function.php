<?php  

/*************************************************************************************************/
/******************************************HELPER CODE********************************************/
/*************************************************************************************************/

if (isset($_GET['login'])) {
    $title = "Login";
}


$upload_directory = "uploads";

// helper functions

function display_image($picture) {

global $upload_directory;

return $upload_directory  . DS . $picture;



}

function last_id(){

global $connection;

return mysqli_insert_id($connection);


}


function set_message($msg){

if(!empty($msg)) {

$_SESSION['message'] = $msg;

} else {

$msg = "";


    }


}


function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }

}


function redirect($location){

return header("Location: $location ");


}



// function redirect($location, $sec=0)
// {
//     if (!headers_sent())
//     {
//         header( "refresh: $sec;url=$location" ); 
//     }
//     elseif (headers_sent())
//     {
//         echo '<noscript>';
//         echo '<meta http-equiv="refresh" content="'.$sec.';url='.$location.'" />';
//         echo '</noscript>';
//     }
//     else
//     {
//         echo '<script type="text/javascript">';
//         echo 'window.location.href="'.$location.'";';
//         echo '</script>';
//     }
// }



function query($sql) {

global $connection;

return mysqli_query($connection, $sql);


}


function confirm($result){

global $connection;

if(!$result) {

die("QUERY FAILED " . mysqli_error($connection));


	}
}


function escape_string($string){

global $connection;

return mysqli_real_escape_string($connection, $string);


}



function fetch_array($result){

return mysqli_fetch_array($result);


}


/****************************FRONT END FUNCTIONS***************************/

/***************************************************************************/
/******************************* LOGIN FUNCTION ****************************/
/***************************************************************************/

/******************************* LOGIN STUDENT ****************************/

function login_signup(){

    //Login For Student
    if(isset($_POST['submit-student'])) {

        $username = escape_string($_POST['username_student']);
        $password = escape_string($_POST['password_student']);

        $query = query("SELECT * FROM student WHERE username = '{$username}' AND password = '{$password}'");
    
        confirm($query);
        
        $row = $query -> fetch_array(MYSQLI_NUM);

        if(mysqli_num_rows($query) == 0) {
            
            redirect("index.php?login&password=incorrect");

        } else {

            $_SESSION['student_id'] = $row[0];
            $_SESSION['student_username'] = $row[1];
            redirect("student/");

        }
    }

    //Login for TEACHER
    if(isset($_POST['submit-teacher'])) {

        $username = escape_string($_POST['username_teacher']);
        $password = escape_string($_POST['password_teacher']);

        $query = query("SELECT * FROM teacher WHERE username = '{$username}' AND password = '{$password}'");
    
        confirm($query);
        $row = $query -> fetch_array(MYSQLI_NUM);

        if(mysqli_num_rows($query) == 0) {
            
            redirect("index.php?login&password=incorrect");

        } else {

            $_SESSION['teacher_id'] = $row[0];
            $_SESSION['teacher_username'] = $row[1];
            redirect("teacher/");

        }
    }
    
    //Login for ADMIN
    if(isset($_POST['submit-admin'])) {

        $username = escape_string($_POST['username_admin']);
        $password = escape_string($_POST['password_admin']);

        $query = query("SELECT * FROM admin WHERE username = '{$username}' AND password = '{$password}'");
    
        confirm($query);
        $row = $query -> fetch_array(MYSQLI_NUM);

        if(mysqli_num_rows($query) == 0) {
            
            redirect("index.php?login&password=incorrect");

        } else {

            $_SESSION['admin_id'] = $row[0];
            $_SESSION['admin_username'] = $row[1];
            redirect("admin/index.php");

        }
    }


    //Add Student
    if(isset($_POST['signup'])) {
        
        $username       =       escape_string($_POST['username']);
        $lastname       =       escape_string($_POST['lastname']);
        $firstname      =       escape_string($_POST['firstname']);
        $email          =       escape_string($_POST['email']);

        $checkusername = query("SELECT * FROM student WHERE username = '{$username}'");
        confirm($checkusername);

        if(mysqli_num_rows($checkusername) == 0) {

            $checkemail  =   query("SELECT * FROM student WHERE email = '{$email}'");
            confirm($checkemail);

            if(mysqli_num_rows($checkemail) == 0) {

                $checkname  =   query("SELECT * FROM student WHERE lastname = '{$lastname}' AND firstname = '{$firstname}'");
                confirm($checkname);
    
                if(mysqli_num_rows($checkname) == 0) {
    
                    $firstname      =       escape_string($_POST['firstname']);
                    $lastname       =       escape_string($_POST['lastname']);
                    $username       =       escape_string($_POST['username']);
                    $password       =       escape_string($_POST['password']);
                    $email          =       escape_string($_POST['email']);
            
                    $query = query("INSERT INTO student(`firstname`, `lastname`, `username`, `password`, `email`) VALUE ('{$firstname}', '{$lastname}','{$username}', '{$password}' , '{$email}')");
                    confirm($query);
            
                    redirect("index.php?login&signup=registered");
    
                } else {
                    redirect("index.php?login&signup=inscribe");
                } 
            } else {
                redirect("index.php?login&signup=email");
            }
        } else {
            redirect("index.php?login&signup=username");
        }
    } 
       
}


/***************************************************************************/
/******************************* ADMIN FUNCTION ****************************/
/***************************************************************************/

//LIST FUNCTION 

class list_function_admin {

    public function class_list() {
        
        $mainquery = query("SELECT * FROM classroom");
        confirm($mainquery);
        $counter = 1;

        if(mysqli_num_rows($mainquery) == 0) {
           
           $list_classroom = <<< DELIMITER
            <tr>
                <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
            </tr>
           DELIMITER;
           echo $list_classroom;

        } elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
                $delete = "index.php?classroom_delete={$row['classroom_id']}";

                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['classroom_name']}</td>
                    <td class="text-center">
                        <a href="#" id="{$row['classroom_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                DELIMETER;
                $counter++;
                echo $product;
            }

        
        
        } else {

        $query = query(" SELECT * FROM classroom");
        confirm($query);

        $rows = mysqli_num_rows($query); // Get total of mumber of rows from the database

        if(isset($_GET['classroom'])){ //get page from URL if its there

            $page = preg_replace('#[^0-9]#', '', $_GET['classroom']);//filter everything but numbers

        } else{// If the page url variable is not present force it to be number 1

            $page = 1;

        }


        $perPage = 5; // Items per page here 
        $lastPage = ceil($rows / $perPage); // Get the value of the last page


        // Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

        if($page < 1){ // If it is less than 1

            $page = 1; // force if to be 1

        }elseif($page > $lastPage){ // if it is greater than $lastpage

            $page = $lastPage; // force it to be $lastpage's value

        }

        $middleNumbers = ''; // Initialize this variable

        // This creates the numbers to click in between the next and back buttons
        $sub1 = $page - 1;
        $sub2 = $page - 2;
        $add1 = $page + 1;
        $add2 = $page + 2;
       

        if($page == 1){
            
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$add1.'">' .$add1. '</a></li>';

        }elseif($page < 2 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$add1.'">' .$add1. '</a></li>';

        } elseif ($page == $lastPage) {
            
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

        }elseif ($page > 2 && $page < ($lastPage -1)) {

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$sub2.'">' .$sub2. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$add1.'">' .$add1. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$add2.'">' .$add2. '</a></li>';

        } elseif($page > 1 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom= '.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$add1.'">' .$add1. '</a></li>';

        }

        // This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        // $query2 is what we will use to to display products with out $limit variable
        $query2 = query(" SELECT * FROM classroom $limit");
        confirm($query2);

        $outputPagination = ""; // Initialize the pagination output variable

        // If we are not on page one we place the back link
        if($page != 1){

            $prev  = $page - 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$prev.'">Back</a></li>';

        }

        // Lets append all our links to this variable that we can use this output pagination

        $outputPagination .= $middleNumbers;

        // If we are not on the very last page we the place the next link

        if($page != $lastPage){

            $next = $page + 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$next.'">Next</a></li>';

        }
        // Remember we use query 2 below :)
        while($row = fetch_array($query2)) {
        $delete = "index.php?classroom_delete={$row['classroom_id']}";

        $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['classroom_name']}</td>
                    <td class="text-center">
                        <a href="#" id="{$row['classroom_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
        DELIMETER;
        $counter++;
        echo $product;
        
        }
        echo "<div style='clear:both' class='text-center'><ul class='pagination justify-content-center'>{$outputPagination}</ul></div>";
       }

    }
    
    public function Enrolled_list() { 
        $query = query("SELECT
        *
      FROM enrollment
        INNER JOIN student
          ON enrollment.student_id = student.student_id
        INNER JOIN schedule
          ON enrollment.section_id = schedule.section_id
        INNER JOIN section
          ON schedule.section_id = section.section_id
        INNER JOIN classroom
          ON schedule.classroom_id = classroom.classroom_id
        INNER JOIN subject
          ON schedule.subject_id = subject.subject_id
        GROUP BY section.section_name");

        confirm($query);

        if(mysqli_num_rows($query) == 0){
            $list_classroom = <<< DELIMITER
            <tr>
                <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
            </tr>
            DELIMITER;
            echo $list_classroom;
        }
    }

    public function Grade_list() {

        echo "grade list";

    }

    public function Schedule_list() {

        $mainquery = query("SELECT
            *
        FROM schedule
            INNER JOIN section
            ON schedule.section_id = section.section_id
            INNER JOIN classroom
            ON schedule.classroom_id = classroom.classroom_id
            INNER JOIN subject
            ON schedule.subject_id = subject.subject_id
        GROUP BY section.section_name");

        confirm($mainquery);
        $counter = 1;

        if(mysqli_num_rows($mainquery) == 0) {
           
           $list_classroom = <<< DELIMITER
           <tr>
               <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
           </tr>
           DELIMITER;
           echo $list_classroom;

        }

        elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['section_name']}</td>
                    <td class="text-center">
                        <a href="#"  class="btn btn-info btn-sm name"  data-toggle="modal" data-target="#section{$row['section_id']}"><i class="fas fa-list"></i></a>
                        <a href="#" id="{$row['schedule_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                DELIMETER;
                $counter++;
                echo $product;
            }

        }
        
        else {

        $query = query("SELECT
        *
        FROM schedule
            INNER JOIN section
            ON schedule.section_id = section.section_id
            INNER JOIN classroom
            ON schedule.classroom_id = classroom.classroom_id
            INNER JOIN subject
            ON schedule.subject_id = subject.subject_id
        GROUP BY section.section_name");
        
        confirm($query);

        $rows = mysqli_num_rows($query); // Get total of mumber of rows from the database

        if(isset($_GET['sschedule'])){ //get page from URL if its there

            $page = preg_replace('#[^0-9]#', '', $_GET['schedule']);//filter everything but numbers

        } else{// If the page url variable is not present force it to be number 1

            $page = 1;

        }


        $perPage = 5; // Items per page here 
        $lastPage = ceil($rows / $perPage); // Get the value of the last page


        // Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

        if($page < 1){ // If it is less than 1

            $page = 1; // force if to be 1

        }elseif($page > $lastPage){ // if it is greater than $lastpage

            $page = $lastPage; // force it to be $lastpage's value

        }

        $middleNumbers = ''; // Initialize this variable

        // This creates the numbers to click in between the next and back buttons
        $sub1 = $page - 1;
        $sub2 = $page - 2;
        $add1 = $page + 1;
        $add2 = $page + 2;
       

        if($page == 1){
            
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$add1.'">' .$add1. '</a></li>';

        }elseif($page < 2 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$add1.'">' .$add1. '</a></li>';

        } elseif ($page == $lastPage) {
            
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

        }elseif ($page > 2 && $page < ($lastPage -1)) {

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$sub2.'">' .$sub2. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$add1.'">' .$add1. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$add2.'">' .$add2. '</a></li>';

        } elseif($page > 1 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule= '.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$add1.'">' .$add1. '</a></li>';

        }

        // This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        // $query2 is what we will use to to display products with out $limit variable
        $query2 = query("SELECT
            *
        FROM schedule
            INNER JOIN section
            ON schedule.section_id = section.section_id
            INNER JOIN classroom
            ON schedule.classroom_id = classroom.classroom_id
            INNER JOIN subject
            ON schedule.subject_id = subject.subject_id
        GROUP BY section.section_name $limit");
        confirm($query2);

        $outputPagination = ""; // Initialize the pagination output variable

        // If we are not on page one we place the back link
        if($page != 1){

            $prev  = $page - 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$prev.'">Back</a></li>';

        }

        // Lets append all our links to this variable that we can use this output pagination

        $outputPagination .= $middleNumbers;

        // If we are not on the very last page we the place the next link

        if($page != $lastPage){

            $next = $page + 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?schedule='.$next.'">Next</a></li>';

        }
        // Remember we use query 2 below :)
        while($row = fetch_array($query2)) {

        $product = <<<DELIMETER
        <tr>
            <td>{$counter}</td>
            <td>{$row['section_name']}</td>
            <td class="text-center">
                <a href="#"  class="btn btn-info btn-sm name"  data-toggle="modal" data-target="#section{$row['section_id']}"><i class="fas fa-list"></i></a>
                <a href="#" id="{$row['schedule_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>
        DELIMETER;
        $counter++;
        echo $product;
        
        }
        echo "<div style='clear:both' class='text-center'><ul class='pagination justify-content-center'>{$outputPagination}</ul></div>";
       }
    }

    public function Subject_list_A() {

         $query = query("SELECT
         *
       FROM schedule
         INNER JOIN section
           ON schedule.section_id = section.section_id
         INNER JOIN classroom
           ON schedule.classroom_id = classroom.classroom_id
         INNER JOIN subject
           ON schedule.subject_id = subject.subject_id
       GROUP BY section.section_id");
       confirm($query);
       $counter = 1;

       if(mysqli_num_rows($query) == 0){
            $section = <<<DELIMITER
                kopkop
            DELIMITER;
            echo $section;
       } else {

            while($row = fetch_array($query)) {

                $section = <<<DELIMETER
                <div class="modal fade" id="section{$row['section_id']}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Section {$row['section_name']}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Subject Name</th>
                                            <th scope="col">Time start</th>
                                            <th scope="col">Time end</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Room</th>
                                            <th scope="col">Teacher</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                DELIMETER;
                echo $section;

                $query1 = query("SELECT
                *
              FROM schedule
                INNER JOIN section
                  ON schedule.section_id = section.section_id
                INNER JOIN classroom
                  ON schedule.classroom_id = classroom.classroom_id
                INNER JOIN subject
                  ON schedule.subject_id = subject.subject_id
                INNER JOIN teacher
                  ON schedule.teacher_id = teacher.teacher_id
                    WHERE section.section_id = {$row['section_id']} ");

               confirm($query1);

               while($roow = fetch_array($query1)) {
                   $list_subject = <<<DELIMITER
                   <tr>
                       <td>$counter</td>
                       <td>{$roow['subject_name']}</td>
                       <td>{$roow['subject_time_start']}</td>
                       <td>{$roow['subject_time_end']}</td>
                       <td>{$roow['subject_date']}</td>
                       <td>{$roow['classroom_name']}</td>
                       <td>{$roow['lastname']}, {$roow['firstname']}</td>
                   </tr>
                   DELIMITER;
                   $counter++;
                   echo $list_subject;
               }

                $section = <<< DELIMETER
                                </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                DELIMETER;
                echo $section;
            }
       }

    }

    public function Section_list() {

        $mainquery = query("SELECT * FROM section");
        confirm($mainquery);
        $counter = 1;

        if(mysqli_num_rows($mainquery) == 0) {
           
           $list_classroom = <<< DELIMITER
           <tr>
               <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
           </tr>
           DELIMITER;
           echo $list_classroom;

        }

        elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['section_name']}</td>
                    <td class="text-center">
                        <a href="#" id="{$row['section_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                DELIMETER;
                $counter++;
                echo $product;
            }

        }
        
        else {

        $query = query(" SELECT * FROM section");
        confirm($query);

        $rows = mysqli_num_rows($query); // Get total of mumber of rows from the database

        if(isset($_GET['section'])){ //get page from URL if its there

            $page = preg_replace('#[^0-9]#', '', $_GET['section']);//filter everything but numbers

        } else{// If the page url variable is not present force it to be number 1

            $page = 1;

        }


        $perPage = 5; // Items per page here 
        $lastPage = ceil($rows / $perPage); // Get the value of the last page


        // Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

        if($page < 1){ // If it is less than 1

            $page = 1; // force if to be 1

        }elseif($page > $lastPage){ // if it is greater than $lastpage

            $page = $lastPage; // force it to be $lastpage's value

        }

        $middleNumbers = ''; // Initialize this variable

        // This creates the numbers to click in between the next and back buttons
        $sub1 = $page - 1;
        $sub2 = $page - 2;
        $add1 = $page + 1;
        $add2 = $page + 2;
       

        if($page == 1){
            
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$add1.'">' .$add1. '</a></li>';

        }elseif($page < 2 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$add1.'">' .$add1. '</a></li>';

        } elseif ($page == $lastPage) {
            
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

        }elseif ($page > 2 && $page < ($lastPage -1)) {

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$sub2.'">' .$sub2. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$add1.'">' .$add1. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$add2.'">' .$add2. '</a></li>';

        } elseif($page > 1 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section= '.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$add1.'">' .$add1. '</a></li>';

        }

        // This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        // $query2 is what we will use to to display products with out $limit variable
        $query2 = query(" SELECT * FROM section $limit");
        confirm($query2);

        $outputPagination = ""; // Initialize the pagination output variable

        // If we are not on page one we place the back link
        if($page != 1){

            $prev  = $page - 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$prev.'">Back</a></li>';

        }

        // Lets append all our links to this variable that we can use this output pagination

        $outputPagination .= $middleNumbers;

        // If we are not on the very last page we the place the next link

        if($page != $lastPage){

            $next = $page + 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?section='.$next.'">Next</a></li>';

        }
        // Remember we use query 2 below :)
        while($row = fetch_array($query2)) {

        $product = <<<DELIMETER
        <tr>
            <td>{$counter}</td>
            <td>{$row['section_name']}</td>
            <td class="text-center">
                <a href="#" id="{$row['section_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>
        DELIMETER;
        $counter++;
        echo $product;
        
        }
        echo "<div style='clear:both' class='text-center'><ul class='pagination justify-content-center'>{$outputPagination}</ul></div>";
       }

    }

    public function Stundent_list() {

        $mainquery = query("SELECT * FROM student");
        confirm($mainquery);
        $counter = 1;

        if(mysqli_num_rows($mainquery) == 0) {
           
           $list_classroom = <<< DELIMITER
           <tr>
               <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
           </tr>
           DELIMITER;
           echo $list_classroom;

        }

        elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['lastname']}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>
                DELIMETER;
                $counter++;
                echo $product;
            }

        }
        
        else {

        $query = query(" SELECT * FROM student");
        confirm($query);

        $rows = mysqli_num_rows($query); // Get total of mumber of rows from the database

        if(isset($_GET['student'])){ //get page from URL if its there

            $page = preg_replace('#[^0-9]#', '', $_GET['student']);//filter everything but numbers

        } else{// If the page url variable is not present force it to be number 1

            $page = 1;

        }


        $perPage = 5; // Items per page here 
        $lastPage = ceil($rows / $perPage); // Get the value of the last page


        // Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

        if($page < 1){ // If it is less than 1

            $page = 1; // force if to be 1

        }elseif($page > $lastPage){ // if it is greater than $lastpage

            $page = $lastPage; // force it to be $lastpage's value

        }

        $middleNumbers = ''; // Initialize this variable

        // This creates the numbers to click in between the next and back buttons
        $sub1 = $page - 1;
        $sub2 = $page - 2;
        $add1 = $page + 1;
        $add2 = $page + 2;
       

        if($page == 1){
            
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$add1.'">' .$add1. '</a></li>';

        }elseif($page < 2 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$add1.'">' .$add1. '</a></li>';

        } elseif ($page == $lastPage) {
            
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

        }elseif ($page > 2 && $page < ($lastPage -1)) {

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$sub2.'">' .$sub2. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$add1.'">' .$add1. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$add2.'">' .$add2. '</a></li>';

        } elseif($page > 1 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student= '.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$add1.'">' .$add1. '</a></li>';

        }

        // This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        // $query2 is what we will use to to display products with out $limit variable
        $query2 = query(" SELECT * FROM student $limit");
        confirm($query2);

        $outputPagination = ""; // Initialize the pagination output variable

        // If we are not on page one we place the back link
        if($page != 1){

            $prev  = $page - 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$prev.'">Back</a></li>';

        }

        // Lets append all our links to this variable that we can use this output pagination

        $outputPagination .= $middleNumbers;

        // If we are not on the very last page we the place the next link

        if($page != $lastPage){

            $next = $page + 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?student='.$next.'">Next</a></li>';

        }
        // Remember we use query 2 below :)
        while($row = fetch_array($query2)) {

        $product = <<<DELIMETER
        <tr>
            <td>{$counter}</td>
            <td>{$row['firstname']}</td>
            <td>{$row['lastname']}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
        DELIMETER;
        $counter++;
        echo $product;
        
        }
        echo "<div style='clear:both' class='text-center'><ul class='pagination justify-content-center'>{$outputPagination}</ul></div>";
       }

    }

    public function Subject_list() {

        
        $mainquery = query("SELECT * FROM subject");
        confirm($mainquery);
        $counter = 1;

        if(mysqli_num_rows($mainquery) == 0) {
           
           $list_classroom = <<< DELIMITER
           <tr>
                <th colspan="6" class="text-center bg-danger text-white"> No Result </th>
           </tr>
           DELIMITER;
           echo $list_classroom;

        }

        elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['subject_date']}</td>
                    <td>{$row['subject_time_start']}</td>
                    <td>{$row['subject_time_end']}</td>
                    <td class="text-center">
                        <a href="#" id="{$row['subject_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                DELIMETER;
                $counter++;
                echo $product;
            }

        }
        
        else {

        $query = query(" SELECT * FROM subject");
        confirm($query);

        $rows = mysqli_num_rows($query); // Get total of mumber of rows from the database

        if(isset($_GET['subject'])){ //get page from URL if its there

            $page = preg_replace('#[^0-9]#', '', $_GET['subject']);//filter everything but numbers

        } else{// If the page url variable is not present force it to be number 1

            $page = 1;

        }


        $perPage = 5; // Items per page here 
        $lastPage = ceil($rows / $perPage); // Get the value of the last page


        // Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

        if($page < 1){ // If it is less than 1

            $page = 1; // force if to be 1

        }elseif($page > $lastPage){ // if it is greater than $lastpage

            $page = $lastPage; // force it to be $lastpage's value

        }

        $middleNumbers = ''; // Initialize this variable

        // This creates the numbers to click in between the next and back buttons
        $sub1 = $page - 1;
        $sub2 = $page - 2;
        $add1 = $page + 1;
        $add2 = $page + 2;
       

        if($page == 1){
            
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$add1.'">' .$add1. '</a></li>';

        }elseif($page < 2 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$add1.'">' .$add1. '</a></li>';

        } elseif ($page == $lastPage) {
            
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

        }elseif ($page > 2 && $page < ($lastPage -1)) {

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$sub2.'">' .$sub2. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$add1.'">' .$add1. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$add2.'">' .$add2. '</a></li>';

        } elseif($page > 1 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject= '.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$add1.'">' .$add1. '</a></li>';

        }

        // This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        // $query2 is what we will use to to display products with out $limit variable
        $query2 = query(" SELECT * FROM subject $limit");
        confirm($query2);

        $outputPagination = ""; // Initialize the pagination output variable

        // If we are not on page one we place the back link
        if($page != 1){

            $prev  = $page - 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$prev.'">Back</a></li>';

        }

        // Lets append all our links to this variable that we can use this output pagination

        $outputPagination .= $middleNumbers;

        // If we are not on the very last page we the place the next link

        if($page != $lastPage){

            $next = $page + 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?subject='.$next.'">Next</a></li>';

        }
        // Remember we use query 2 below :)
        while($row = fetch_array($query2)) {

        $product = <<<DELIMETER
        <tr>
            <td>{$counter}</td>
            <td>{$row['subject_name']}</td>
            <td>{$row['subject_date']}</td>
            <td>{$row['subject_time_start']}</td>
            <td>{$row['subject_time_end']}</td>
            <td class="text-center">
                <a href="#" id="{$row['subject_id']}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>
        DELIMETER;
        $counter++;
        echo $product;
        
        }
        echo "<div style='clear:both' class='text-center'><ul class='pagination justify-content-center'>{$outputPagination}</ul></div>";
       }

    }

    public function Teacher_list() {

        $mainquery = query("SELECT * FROM teacher");
        confirm($mainquery);
        $counter = 1;

        if(mysqli_num_rows($mainquery) == 0) {
           
           $list_classroom = <<< DELIMITER
            <tr>
                <th colspan="6" class="text-center bg-danger text-white"> No Result </th>
            </tr>
           DELIMITER;
           echo $list_classroom;

        } elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
               
                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['middlename']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$row['date_start']}</td>
                    <td class="text-center">
                        <a href="#" id="{$row['teacher_id']}" class="btn btn-primary btn-sm"><i class="fas fa-th-list"></i></a>
                    </td>
                </tr>
                DELIMETER;
                $counter++;
                echo $product;
            }

        
        
        } else {

        $query = query(" SELECT * FROM teacher");
        confirm($query);

        $rows = mysqli_num_rows($query); // Get total of mumber of rows from the database

        if(isset($_GET['teacher'])){ //get page from URL if its there

            $page = preg_replace('#[^0-9]#', '', $_GET['teacher']);//filter everything but numbers

        } else{// If the page url variable is not present force it to be number 1

            $page = 1;

        }


        $perPage = 5; // Items per page here 
        $lastPage = ceil($rows / $perPage); // Get the value of the last page


        // Be sure URL variable $page(page number) is no lower than page 1 and no higher than $lastpage

        if($page < 1){ // If it is less than 1

            $page = 1; // force if to be 1

        }elseif($page > $lastPage){ // if it is greater than $lastpage

            $page = $lastPage; // force it to be $lastpage's value

        }

        $middleNumbers = ''; // Initialize this variable

        // This creates the numbers to click in between the next and back buttons
        $sub1 = $page - 1;
        $sub2 = $page - 2;
        $add1 = $page + 1;
        $add2 = $page + 2;
       

        if($page == 1){
            
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$add1.'">' .$add1. '</a></li>';

        }elseif($page < 2 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$add1.'">' .$add1. '</a></li>';

        } elseif ($page == $lastPage) {
            
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

        }elseif ($page > 2 && $page < ($lastPage -1)) {

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$sub2.'">' .$sub2. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$add1.'">' .$add1. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$add2.'">' .$add2. '</a></li>';

        } elseif($page > 1 && $page < $lastPage){

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher= '.$sub1.'">' .$sub1. '</a></li>';
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?teacher='.$add1.'">' .$add1. '</a></li>';

        }

        // This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        // $query2 is what we will use to to display products with out $limit variable
        $query2 = query(" SELECT * FROM classroom $limit");
        confirm($query2);

        $outputPagination = ""; // Initialize the pagination output variable

        // If we are not on page one we place the back link
        if($page != 1){

            $prev  = $page - 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$prev.'">Back</a></li>';

        }

        // Lets append all our links to this variable that we can use this output pagination

        $outputPagination .= $middleNumbers;

        // If we are not on the very last page we the place the next link

        if($page != $lastPage){

            $next = $page + 1;
            $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?classroom='.$next.'">Next</a></li>';

        }
        // Remember we use query 2 below :)
        while($row = fetch_array($query2)) {
        $delete = "index.php?classroom_delete={$row['teacher_id']}";

        $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['middlename']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$row['date_start']}</td>
                    <td class="text-center">
                        <a href="#" id="{$row['teacher_id']}" class="btn btn-primary btn-sm"><i class="fas fa-th-list"></i></a>
                    </td>
                </tr>
        DELIMETER;
        $counter++;
        echo $product;
        
        }
        echo "<div style='clear:both' class='text-center'><ul class='pagination justify-content-center'>{$outputPagination}</ul></div>";
       }

    }

}

class add_function_admin {

    public function class_add() {
        if(isset($_POST['create'])) {

            $classroom = escape_string($_POST['classroom_name']);

            $query = query("INSERT INTO classroom(classroom_name) VALUES ('$classroom')");
            confirm($query);

            redirect("index.php?classroom=success");
        }
    }

    public function grade_add() {

    }

    public function schedule_add() {
        if(isset($_POST['submit'])){
            for($i = 0; $i < count($_POST['subject_id']); $i++) {
                
                // echo $_POST['subject_id'][$i] . "<br>";
                // echo $_POST['teacher_id'][$i] . "<br>";
                // echo $_POST['classroom_id'][$i] . "<br>";

                $querycheckerfirst = query("SELECT * FROM schedule WHERE section_id = '{$_POST['section_id']}' AND subject_id = '{$_POST['subject_id'][$i]}' AND classroom_id = '{$_POST['classroom_id'][$i]}' AND teacher_id = '{$_POST['teacher_id'][$i]}'");
                confirm($querycheckerfirst);

                if(mysqli_num_rows($querycheckerfirst) == 0) {

                    $querycheckersecond = query("SELECT * FROM schedule WHERE subject_id = '{$_POST['subject_id'][$i]}' AND classroom_id = '{$_POST['classroom_id'][$i]}' AND teacher_id = '{$_POST['teacher_id'][$i]}'");
                    confirm($querycheckersecond);
                    
                    if(mysqli_num_rows($querycheckersecond) == 0) {

                        $querycheckerthird = query("SELECT * FROM schedule WHERE subject_id = '{$_POST['subject_id'][$i]}' AND teacher_id = '{$_POST['teacher_id']}'");
                        confirm($querycheckerthird);

                        if(mysqli_num_rows($querycheckerthird) == 0) {
                            
                            $query = query("INSERT INTO schedule(section_id, subject_id, classroom_id, teacher_id)
                            VALUE ('{$_POST['section_id']}','{$_POST['subject_id'][$i]}','{$_POST['classroom_id'][$i]}', '{$_POST['teacher_id'][$i]}')");
                            confirm($query);
            
                            redirect("index.php?schedule=success");

                        } else {
                            echo "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'The teacher you have Schedule With the same Subject and Room'
                                    })
                                  </script>";
                        }

                    } else {
                        echo "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'The teacher you have Schedule With the same Subject and Room'
                                    })
                                </script>";
                    }

                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Section Already Exists'
                            })
                          </script>";
                }
            }
        }
    }

    public function section_add() {
        if(isset($_POST['submit'])){
            $section_name          =        escape_string($_POST['section_name']);
          
            $query = query("INSERT INTO section(section_name) VALUES ('{$section_name}')");
            
            confirm($query);
    
            redirect("index.php?section=success");
    
        }
    }

    public function subject_add() {
        if(isset($_POST['submit'])) {
            $subject_name       =       escape_string($_POST['subject_name']);
            $subject_date       =       escape_string($_POST['subject_date']);
            $subject_time_start =       escape_string($_POST['subject_time_start']);
            $subject_time_end   =       escape_string($_POST['subject_time_end']);
            
            if(!empty($_POST['subject_name'])) {
                if(!empty($_POST['subject_date'])) {
                    if(!empty($_POST['subject_time_start'])) {
                        if(!empty($_POST['subject_time_end'])){
        
                            $query = query("INSERT INTO subject(subject_name, subject_date, subject_time_start, subject_time_end) VALUES ('{$subject_name}','{$subject_date}','{$subject_time_start}', '{$subject_time_end}')");
                            confirm($query);
                
                            redirect("index.php?subject=success");
                        } else {
                            echo "input subject time end";
                        }
                    } else {
                        echo "input subject time start";
                    }
                } else {
                    echo "input subject date";
                }
            } else {
                echo "input subject name";
            }
        }
    }
}

class edit_function_admin {

}


class dropdown {

    function section() {
        $query = query("SELECT * FROM section");
        confirm($query);

        while($row = fetch_array($query)){
            $section = <<<DELIMITER
                <option value="{$row['section_id']}">{$row['section_name']}</option>
            DELIMITER;
            echo $section;
        }
    }

    function subject() {
        $query = query("SELECT * FROM subject");
        confirm($query);

        while($row = fetch_array($query)){
            $subject = <<<DELIMITER
                <option value="{$row['subject_id']}" >{$row['subject_name']} ({$row['subject_time_start']} - {$row['subject_time_end']})</option>
            DELIMITER;
            echo $subject;
        }
    }

    function classroom() {
        $query = query("SELECT * FROM classroom");
        confirm($query);

        while($row = fetch_array($query)){
            $classroom = <<<DELIMTER
                <option value="{$row['classroom_id']}">{$row['classroom_name']}</option>
            DELIMTER;
            echo $classroom;
        }
    }

    function teacher() {
        $query = query("SELECT * FROM teacher");
        confirm($query);

        while($row = fetch_array($query)) {
            $teacher = <<<DELIMITER
                <option value="{$row['teacher_id']}">{$row['lastname']}, {$row['firstname']}</option>
            DELIMITER;
            echo $teacher;
        }
    }
}
/***************************************************************************/
/******************************* STUDENT FUNCTION **************************/
/***************************************************************************/
class list_teacher {

}

class add_teacher {

}

/***************************************************************************/
/******************************* TEACHER FUNCTION **************************/
/***************************************************************************/
class list_student {

}

class add_student {

}