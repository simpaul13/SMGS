<?php  

/*************************************************************************************************/
/******************************************HELPER CODE********************************************/
/*************************************************************************************************/



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
            redirect("admin/");

        }
    }

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