<?php

    $query = query("DELETE FROM schedule WHERE section_id = ".escape_string($_POST['id'])." ");
    confirm($query);
