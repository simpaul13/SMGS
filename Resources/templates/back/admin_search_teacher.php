<?php
require_once("../../config.php");

if(isset($_POST["query"])) {

   $search = escape_string($_POST["query"]);
   $mainquery = query("SELECT * FROM teacher 
   WHERE teacher.firstname LIKE '%".$search."%'
   OR teacher.lastname LIKE '%".$search."%'");
   confirm($mainquery);
   $counter = 1;

   if(mysqli_num_rows($mainquery) == 0) {
      
      $list_classroom = <<< DELIMITER
      <tr>
           <th colspan="6" class="text-center bg-danger text-white"> No Result </th>
      </tr>
      DELIMITER;
      echo $list_classroom;

   } else {
     
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

   }


} else {
   
   list_function_admin::teacher_list(); 

}