<?php require_once("../resources/config.php")?>

<?php 

include(TEMPLATE_FRONT . "/header.php");


?>


<?php 




    if($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php") {
        include(TEMPLATE_FRONT . "/test.php");
    }


    /****** VIEW  ******/

    if(isset($_GET['test'])) {
        include(TEMPLATE_FRONT . "/test.php");
    }
    if(isset($_GET['login'])) {
        include(TEMPLATE_FRONT . "/login.php");
    }





?>

<?php include(TEMPLATE_FRONT . "/footer.php");?>