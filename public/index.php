<?php
require_once("../resources/config.php");


include(TEMPLATE_FRONT . "/header.php");

if ($_SERVER['REQUEST_URI']) {

    include(TEMPLATE_FRONT . "/login.php");
}


include(TEMPLATE_FRONT . "/footer.php");
