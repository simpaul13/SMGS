<?php require_once("../../resources/config.php");



    if(!isset($_SESSION['admin_username'])) { 
        redirect("../index.php?login"); 
    }



include(TEMPLATE_BACK . "/admin_header.php");

    /****** LIST  ******/
    if(isset($_GET['classroom'])) {
        include(TEMPLATE_BACK . "/admin_list_class.php");
    }

    else if(isset($_GET['enrolled'])) {
        include(TEMPLATE_BACK . "/admin_list_enrolled.php");
    }

    else if(isset($_GET['grade'])) {
        include(TEMPLATE_BACK ."/admin_list_grade.php");
    }

    else if(isset($_GET['schedule'])) {
        include(TEMPLATE_BACK . "/admin_list_schedule.php");
    }

    else if(isset($_GET['section'])) {
        include(TEMPLATE_BACK . "/admin_list_section.php");
    }

    else if(isset($_GET['student'])) {
        include(TEMPLATE_BACK ."/admin_list_student.php");
    }

    else if(isset($_GET['subject'])) {
        include(TEMPLATE_BACK ."/admin_list_subject.php");
    }

    else if(isset($_GET['teacher'])) {
        include(TEMPLATE_BACK . "/admin_list_teacher.php");
    }


    
    /****** DELETE  ******/
    else if(isset($_GET['classroom_delete'])) {
        include(TEMPLATE_BACK . "/admin_delete_classroom.php");
    }

    else if(isset($_GET['section_delete'])) {
        include(TEMPLATE_BACK . "/admin_delete_section.php");
    }

    else if(isset($_GET['subject_delete'])) {
        include(TEMPLATE_BACK . "/admin_delete_subject.php");
    }

    else if(isset($_GET['schedule_delete'])) {
        include(TEMPLATE_BACK . "/admin_delete_schedule.php");
    }

    /****** MODAL  ******/
    else if(isset($_GET['modal_teacher'])) {
        include(TEMPLATE_BACK . "/admin_list_modal_teacher_subject.php");
    }


    

    
 include(TEMPLATE_BACK . "/admin_footer.php");
 
 
 ?>