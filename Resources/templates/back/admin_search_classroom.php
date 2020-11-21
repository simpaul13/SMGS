<?php
require_once("../../config.php");

if(isset($_POST["query"])) {

   $search = escape_string($_POST["query"]);
   $mainquery = query("SELECT * FROM classroom WHERE classroom.classroom_name LIKE '%".$search."%'");
   confirm($mainquery);
   $counter = 1;

   if(mysqli_num_rows($mainquery) == 0) {
      
         $list_classroom = <<< DELIMITER
            <tr>
               <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
            </tr>
         DELIMITER;
         echo $list_classroom;

   } else {
     
      while($row = fetch_array($mainquery)) {
         $list_classroom = <<<DELIMETER
         <tr>
             <td>{$counter}</td>
             <td>{$row['classroom_name']}</td>
             <td class="text-center">
                 <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
             </td>
         </tr>
         DELIMETER;
         $counter++;
         echo $list_classroom;
     }

   }


} else {
   
   list_function_admin::class_list();

}