<?php
//this will start the connection of the db
ob_start();


//this is will start the session
session_start();


//
defined("DS") ? NULL : define("DS", DIRECTORY_SEPARATOR);
defined("TEMPLATE_UPLOAD") ? NULL : define("TEMPLATE_UPLOAD", __DIR__ . DS . "../public/resources/upload");
defined("TEMPLATE_FRONT") ? NULL : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");
defined("TEMPLATE_BACK") ? NULL : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");

//this connectio to the host 
defined("DB_HOST") ? NULL : define("DB_HOST", "localhost");

defined("DB_USER") ? NULL : define("DB_USER", "simpaul");

defined("DB_PASS") ? NULL : define("DB_PASS", "Password123@@@");

defined("DB_NAME") ? NULL : define("DB_NAME", "sms_v1");

//this will check the connection of the host 
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//this will request the file function.php
require_once("function.php");
