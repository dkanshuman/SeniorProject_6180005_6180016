<?php
 session_start();
 require_once './includes/config.php'; 
 require_once './includes/connection.php';
 require_once './includes/function.php';
    if(isset($_REQUEST['exam_id']) && isset($_REQUEST['name']))
    {
        $name = sanitise_input($_REQUEST['name']);
        $exam_id = sanitise_input($_REQUEST['exam_id']);
        $query = mysqli_query($connection, "UPDATE exam SET examName = '$name' WHERE examId = '$exam_id'");
        if($query)
        {
            echo $_REQUEST['name'];
        }
    }

    else  if(isset($_REQUEST['getExam_id']) && isset($_REQUEST['name']))
    {
        $exam_id = sanitise_input($_REQUEST['getExam_id']);
        $query = mysqli_query($connection, "SELECT examName FROM exam  WHERE examId = '$exam_id'");
        if(mysqli_num_rows($query) == 1)
        {
            $row = mysqli_fetch_assoc($query);
            echo $row['examName'];
        }
    }

    elseif(isset($_REQUEST['getQuestionId']) && isset($_REQUEST['updateExamScore']))
    {
        $que_id = sanitise_input($_REQUEST['getQuestionId']);
        $query = mysqli_query($connection, "SELECT question_id, score FROM question_bank  WHERE question_id = '$que_id'");
        if(mysqli_num_rows($query) == 1)
        {
            $row = mysqli_fetch_assoc($query);
            echo $row['score'];
        }
    }

    elseif( isset($_REQUEST['updateQuestionId']) && isset($_REQUEST['updateExamScore']) )
    {
        $score = trim($_REQUEST['updateExamScore']);
        $qid = $_REQUEST['updateQuestionId'];
        if(isset($_SESSION['score'][$qid]))
        {
            $_SESSION['score'][$qid] = $score;             
        } 

        if(isset($_SESSION['score']))
        {
            $totalscore = 0;
            foreach($_SESSION['score'] as $value)
            {
                $value = (int)$value;
                $totalscore += $value;
            }
            echo $totalscore;  
        }     

    }

    elseif( isset($_REQUEST['exam'])  && isset($_REQUEST['prevQuesId']) && isset($_REQUEST['prevScore']) )
    {
        $exam = $_REQUEST['exam'];
        $qid = $_REQUEST['prevQuesId'];
        $score = trim($_REQUEST['prevScore']);
        
        $query = mysqli_query($connection, "UPDATE `exam_questions` SET `score` = '$score' WHERE `examId` = '$exam' AND `questionId` = '$qid' ");

        if($query)
        {
            echo $score;
        }

    }


    else if(isset($_REQUEST['data']) && isset($_REQUEST['exam_id']) && isset($_GET['type']) && isset($_GET['mode']))
    {

        header("Content-Type: application/json; charset=UTF-8");
        $questionJSONData = json_decode($_REQUEST['data'], false);

        foreach($questionJSONData as $key => $value)
        {
            $qid = $value->question;
            $score = $value->score;
            $order = $value->order;
            $examId = $value->examId;

            mysqli_query($connection, "UPDATE exam_questions SET score = '$score', questionOrder = '$order' WHERE examId = '$examId' AND questionId = '$qid'");
        } 

        header("Location: preview.php?exam_id=$_REQUEST[exam_id]&&examMode=$_GET[mode]&&type=$_GET[type]");


    }


    elseif( isset($_REQUEST['exam_id']) && isset($_REQUEST['semester']))
    {
        $semester = sanitise_input($_REQUEST['semester']);
        $exam_id = sanitise_input($_REQUEST['exam_id']);

        $query = mysqli_query($connection, "UPDATE exam SET semester = '$semester' WHERE examId = '$exam_id'");
       
        if($query)
        {
            echo $_REQUEST['semester'];
        }
    }

    else  if(isset($_REQUEST['getExam_id']) && isset($_REQUEST['semester']))
    {
        $exam_id = sanitise_input($_REQUEST['getExam_id']);
        
        $query = mysqli_query($connection, "SELECT semester FROM exam  WHERE examId = '$exam_id'");
        
        if(mysqli_num_rows($query) == 1)
        {
            $row = mysqli_fetch_assoc($query);
            echo $row['semester'];
        }

    }

