<?php 
    session_start();
    require_once './includes/session.php';

    require './includes/config.php'; 
    require_once './includes/connection.php';
    
    if(isset($_GET['delete_institute']))
    {
        $instituteQuery = mysqli_query($connection, "DELETE FROM institute WHERE institute_id = '$_GET[delete_institute]' ");
        if($instituteQuery)
        {
            header('Location:institute-view.php?success=Record deleted successfully');
        }
    }

    if(isset($_GET['delete_study']))
    {
        $studyQuery = mysqli_query($connection, "DELETE FROM type_of_study WHERE type_of_study_id = '$_GET[delete_study]' ");
        if($studyQuery)
        {
            header('Location:studyType-view.php?success=Record deleted successfully');
        }
    }

    if(isset($_GET['delete_major']))
    {
        $majorQuery = mysqli_query($connection, "DELETE FROM major WHERE major_id = '$_GET[delete_major]' ");
        if($majorQuery)
        {
            header('Location:major-view.php?success=Record deleted successfully');
        }
    }

    if(isset($_GET['delete_subject']))
    {
        $subjectQuery = mysqli_query($connection, "DELETE FROM subject_details WHERE subject_id = '$_GET[delete_subject]' ");
        if($subjectQuery)
        {
            header('Location:subject-view.php?success=Record deleted successfully');
        }
    }


    if(isset($_GET['delete_topic']))
    {
        $topicQuery = mysqli_query($connection, "DELETE FROM subject_topic WHERE subject_topic_id = '$_GET[delete_topic]' ");
        if($topicQuery)
        {
            header('Location:topic-view.php?success=Record deleted successfully');
        }
    }

    if(isset($_GET['delete_question_type']))
    {
        $topicQuery = mysqli_query($connection, "DELETE FROM question_type WHERE question_type_id = '$_GET[delete_question_type]' ");
        if($topicQuery)
        {
            header('Location:questionType-view.php?success=Record deleted successfully');
        }
    }

    if(isset($_GET['delete_question']))
    {
        $topicQuery = mysqli_query($connection, "DELETE FROM question_bank WHERE question_id = '$_GET[delete_question]' ");
        if($topicQuery)
        {
            header('Location:question-view.php?success=Record deleted successfully.');
        }
    }

    if(isset($_GET['delete_teacher_subject']))
    {
        $topicQuery = mysqli_query($connection, "DELETE FROM teacher_subject_relation WHERE subjectId = '$_GET[delete_teacher_subject]' AND teacherId = '$_SESSION[userId]' ");
        if($topicQuery)
        {
            header('Location:dashboard.php?success=Record deleted successfully.');
        }
    }
    

    if(isset($_GET['delete_exam']))
    {
        $examQuery = mysqli_query($connection, "DELETE FROM exam WHERE examId = '$_GET[delete_exam]' ");
        if($examQuery)
        {
            header('Location:dashboard.php?success=Record deleted successfully.');
        }
    }


    