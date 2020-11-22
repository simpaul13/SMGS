<?php

    $query = query("DELETE FROM section WHERE section_id = ".escape_string($_POST['id'])." ");
    confirm($query);
