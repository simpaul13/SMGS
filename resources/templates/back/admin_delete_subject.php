<?php

    $query = query("DELETE FROM subject WHERE subject_id = ".escape_string($_POST['id'])." ");
    confirm($query);
