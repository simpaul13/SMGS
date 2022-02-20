<?php
require_once("../../config.php");

if(isset($_POST["query"])) {

   $search = escape_string($_POST["query"]);
   $mainquery = query("SELECT * FROM section WHERE section.section_name LIKE '%".$search."%'");
   confirm($mainquery);
   $counter = 1;

   if(mysqli_num_rows($mainquery) == 0) {
      
         $list_section = <<< DELIMITER
            <tr>
               <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
            </tr>
         DELIMITER;
         echo $list_section;

   } else {
     
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


} else {
   
   list_function_admin::section_list();

}





// if(mysqli_num_rows($result) == 0)
// {

//  while($row = mysqli_fetch_array($result))
//  {
//   $output .= '
//    <tr>
//     <td>'.$row["classroom_name"].'</td>

//    </tr>
//   ';
//  }
//  echo $output;
// }
// else
// {
//  echo '<tr>
//          <th colspan="3" class="text-center bg-danger text-white"> No Result </th>
//       </tr>';
// }
