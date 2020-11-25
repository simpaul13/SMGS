<?php
    require_once("../../config.php");

    if(isset($_POST['id'])){

        $teacher_id = $_POST['id'];

        $query = query("SELECT
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
                            WHERE schedule.teacher_id = $teacher_id");

        confirm($query);
        $counter = 1;

        if(mysqli_num_rows($query) == 0) {
            $list_subject = <<<DELIMITER
            no subject
            DELIMITER;
            echo $list_subject;
        } else {
            
            while($row = fetch_array($query)) {
                $list_subject = <<<DELIMETER
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['subject_date']}</td>
                    <td>{$row['subject_time_start']}</td>
                    <td>{$row['subject_time_end']}</td>
                    <td>{$row['classroom_name']}</td>
                    <td>{$row['section_name']}</td>
                </tr>
                DELIMETER;
                $counter++;
                echo $list_subject;
            }
        }

    }

?>