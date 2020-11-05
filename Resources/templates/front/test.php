<?php 
echo $_SESSION['student_id'] . "<br>"; 
echo $_SESSION['student_username'] . "<br>"; 

echo $_SESSION['teacher_id'] . "<br>"; 
echo $_SESSION['teacher_username'] . "<br>"; 

echo $_SESSION['admin_id'] . "<br>"; 
echo $_SESSION['admin_username'] . "<br>"; 


session_destroy();

?>
