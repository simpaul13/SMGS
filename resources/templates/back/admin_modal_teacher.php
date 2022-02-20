<?php

require_once("../../config.php");

if(isset($_POST['query'])) {

    $id         =       escape_string($_POST["id"]);
    $query      =       query("");
    confirm($query);
    
    if(mysqli_num_rows($query) == 0) {

        $list_teacher = <<<DELIMITER
        <tr>
            <th colspan="6" class="text-center bg-danger text-white"> No Result </th>
        </tr>
        DELIMITER;
        echo $list_teacher;
    } else {

        while($row = fetch_array($query)) {
            $list_teacher = <<<DELIMITER

            DELIMITER;
            echo $list_teacher;
        }
    }
}