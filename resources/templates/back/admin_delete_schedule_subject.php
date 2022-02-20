<?php

    $query = query("DELETE FROM schedule WHERE schedule_id = ".escape_string($_POST['id'])." ");
    confirm($query);
