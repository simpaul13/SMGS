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

        }

        elseif(mysqli_num_rows($mainquery) < 5) {

            while($row = fetch_array($mainquery)) {
                $product = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['classroom_name']}</td>
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

        $product = <<<DELIMETER
        <tr>
            <td>{$counter}</td>
            <td>{$row['classroom_name']}</td>
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
    
    public function Enrolled_list() { 

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
                    <a href="#"  class="btn btn-info btn-sm name" id=""><i class="fas fa-list"></i></a>
                    <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
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
                <a href="#"  class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{$row['section_id']}"><i class="fas fa-list"></i></a>
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

    public function Subject_list_A() {
       if(isset($_POST['id'])){
           $subject_id = escape_string($_POST['id']);
           $query = query("SELECT
           section.section_name,
           subject.subject_name,
           classroom.classroom_name
         FROM schedule
           INNER JOIN section
             ON schedule.section_id = section.section_id
           INNER JOIN classroom
             ON schedule.classroom_id = classroom.classroom_id
           INNER JOIN subject
             ON schedule.subject_id = subject.subject_id
         WHERE section.section_id = ");
           confirm($query);

          
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
                        <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
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
                        <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
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

    public function Teacher_list() {

        echo "Teacher list";

    }

}

class add_function_admin {

    public function class_add() {
        if(isset($_POST['create'])) {
            $classroom = escape_string($_POST['classroom']);

            $query = query("INSERT INTO class(classroom_name) VALUES ('$classroom')");
            confirm($query);

            redirect("index.php?classroom=success");
        }
    }

    public function grade_add() {

    }

    public function schedule_add() {

    }

    public function section_add() {
        if(isset($_POST['submit'])){
            $class_id          =        escape_string($_POST['class_id']);
            $student_id        =        escape_string($_POST['student_id']);
            $subject_id        =        escape_string($_POST['subject_id']);
            $project           =        escape_string($_POST['project']);
            $quiz              =        escape_string($_POST['quiz']);
            $exam              =        escape_string($_POST['exam']);
            $average           =        escape_string($_POST['average']);
          
            $query = query("INSERT INTO grade(project, quiz, exam, average, student_id, subject_id, class_id) VALUES ('{$project}', '{$quiz}', '{$exam}', '{$average}', '{$student_id}', '{$subject_id}', '{$class_id}')");
            
            confirm($query);
    
            redirect("?studentgrade=addgrade");
    
        }
    }

    public function subject_add() {

    }
}

class edit_function_admin {
    
    
}

class delete_function_admin {
    
}

class dropdown {

    function section() {
        $query = query("SELECT * FROM section");
        confirm($query);

        while($row = fetch_array($query)){
            $section = <<<DELIMITER
                <option valeu"{$row['section_id']}">{$row['section_name']}</option>
            DELIMITER;
            echo $section;
        }
    }

    function subject() {
        $query = query("SELECT * FROM subject");
        confirm($query);

        while($row = fetch_array($query)){
            $subject = <<<DELIMITER
                <option valeu"{$row['subject_id']}" >{$row['subject_name']} ({$row['subject_time_start']} - {$row['subject_time_end']})</option>
            DELIMITER;
            echo $subject;
        }
    }

    function classroom() {
        $query = query("SELECT * FROM classroom");
        confirm($query);

        while($row = fetch_array($query)){
            $classroom = <<<DELIMTER
                <option valeu"{$row['classroom_id']}">{$row['classroom_name']}</option>
            DELIMTER;
            echo $classroom;
        }
    }

}
/***************************************************************************/
/******************************* STUDENT FUNCTION ****************************/
/***************************************************************************/
