<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "system_v3"; 

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}


$userid = 0;
if(isset($_POST['userid'])){
   $userid = mysqli_real_escape_string($con,$_POST['userid']);
}
$sql = "select * from subject where subject_id=".$userid;
$result = mysqli_query($con,$sql);

$response = "<table border='0' width='100%'>";
while( $row = mysqli_fetch_array($result) ){
 $id = $row['id'];
 $emp_name = $row['emp_name'];
 $salary = $row['salary'];
 $gender = $row['gender'];
 $city = $row['city'];
 $email = $row['email'];
 
 $response .= "<tr>";
 $response .= "<td>Name : </td><td>".$emp_name."</td>";
 $response .= "</tr>";

}
$response .= "</table>";

echo $response;
exit;
?>