<?php require_once("../resources/config.php");


include(TEMPLATE_FRONT . "/header.php");

if($_SERVER['REQUEST_URI'] == "/schoolmanagementsystem/Public/" || $_SERVER['REQUEST_URI'] == "/schoolmanagementsystem/Public/index.php") {
        
    $title = "Login";
    include(TEMPLATE_FRONT . "/test.php");
    
}

else if(isset($_GET['login'])) {

    $title = "Login";
    include(TEMPLATE_FRONT . "/login.php");

}

else if(isset($_GET['test'])) {
    $title = "Test";

}

 include(TEMPLATE_FRONT . "/footer.php");
 
 