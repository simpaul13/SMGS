<?php

    $query = query("DELETE FROM classroom WHERE classroom_id = ".$_POST['id']." ");
    confirm($query);
