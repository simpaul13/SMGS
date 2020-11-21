<?php
require_once("../../config.php");

if(isset($_POST["query"])) {

   $search = escape_string($_POST["query"]);
   $mainquery = query("SELECT
   *
   FROM schedule
      INNER JOIN section
      ON schedule.section_id = section.section_id
      INNER JOIN classroom
      ON schedule.classroom_id = classroom.classroom_id
      INNER JOIN subject
      ON schedule.subject_id = subject.subject_id
   WHERE section.section_name LIKE '%".$search."%'
   OR subject.subject_name LIKE '%".$search."%'
   OR classroom.classroom_name LIKE '%".$search."%'
   GROUP BY section.section_name 
      ");
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
         $product = <<<DELIMETER
         <tr>
             <td>{$counter}</td>
             <td>{$row['section_name']}</td>
             <td class="text-center">
             <a href="#"  class="btn btn-info btn-sm name"  data-toggle="modal" data-target="#section{$row['section_id']}"><i class="fas fa-list"></i></a>
             <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
             </td>
         </tr>
         DELIMETER;
         $counter++;
         echo $product;
     }

   }

} else {
   
   list_function_admin::Schedule_list();

}