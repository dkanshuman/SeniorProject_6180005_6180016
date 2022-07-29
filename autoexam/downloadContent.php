<?php 
    session_start();
    require './includes/config.php'; 
    require_once './includes/connection.php';
    if(isset($_REQUEST['exam_id']) && isset($_REQUEST['type']) && isset($_REQUEST['mode']))
    {

        $examData = [];

        $examDetail = mysqli_query($connection, 
        "SELECT * FROM `exam` 
            LEFT JOIN `subject_details` ON `subject_details`.`subject_id` = `exam`.`subjectId`
            LEFT JOIN `teacher_profile` ON `teacher_profile`.`teacher_id` = `exam`.`examAddedBy`
            WHERE `examId` = '$_REQUEST[exam_id]'
        ");

        $examRow = mysqli_fetch_assoc($examDetail);

        if($examRow['semester'])
        {
            $sem = $examRow['semester'];
        }
        else
        {
            $sem = '-';
        }

        array_push($examData, [
            "examId" => $examRow['examId'], 
            "examName" => $examRow['examName'], 
            "subjectCode" => $examRow['subject_code'],
            "subjectName" => $examRow['subject_name'],
            "semester" => $sem,
            "teacherName" => $examRow['teacher_firstname'] .' '. $examRow['teacher_lastname'],
            "examType" => $_REQUEST['type']
            ]
        );



        // Get exam topics
        $examTopicsQ = mysqli_query($connection, 
            "SELECT * FROM `exam_topics`
            LEFT JOIN `subject_topic` ON `subject_topic`.`subject_topic_id` = `exam_topics`.`topicId`
            WHERE exam_topics.examId = '$_REQUEST[exam_id]' ");

        $topicsArr = [];

        $total = 0;

        while ($examTopicR = mysqli_fetch_assoc($examTopicsQ)) 
        {

            $questionDetail = mysqli_query($connection, 
            "SELECT *, exam_questions.score as escore  
            FROM `exam_questions` 
            LEFT JOIN `question_bank` ON `question_bank`.`question_id` = `exam_questions`.`questionId`
            LEFT JOIN `subject_topic` ON `subject_topic`.`subject_topic_id` = `question_bank`.`subject_topic_id`
                WHERE `exam_questions`.`examId` = '$_REQUEST[exam_id]' AND `question_bank`.subject_topic_id = '$examTopicR[topicId]'
                ORDER BY `exam_questions`.`questionOrder`
            ");

            if(mysqli_num_rows($questionDetail) >= 1)
            {

                $topicname =  $examTopicR['subject_topic_name'];
                $topicId = $examTopicR['subject_topic_id'];

                $maxMarks = 0;

                $questionsArr = [];

                $topicQuesDetailArr = [];
                
                while ($question = mysqli_fetch_assoc($questionDetail)) 
                {
                    $maxMarks += $question['escore'];
                    $options = [];
                    if($question['question_abbr'] == "MCQ")
                    {
                        $options = [ 
                                $question['optionA'],
                                $question['optionB'],
                                $question['optionC'],
                                $question['optionD']
                        ];                    
                    }

                    if($_REQUEST['type'] == 'answer')
                    {
                        array_push($questionsArr, ["questionId" => $question['question_id'], "question" => $question['question'], "answer" => $question['answer'],  "score"=>$question['escore'], "questionType" => $question['question_abbr'], "options" => $options ]);
                    }
                    else
                    {
                        array_push($questionsArr, ["questionId" => $question['question_id'], "question" => $question['question'], "score" => $question['escore'], "questionType" => $question['question_abbr'], "options" => $options ]);
                    }
                }


                array_push($topicQuesDetailArr, [
                    "topic" => $topicname,
                    "topicId" => $topicId,
                    "maxMarks" => $maxMarks,
                    "questionsDet" => $questionsArr
                ]);

                $total += $maxMarks;

                array_push($examData, [
                    "questions" => $topicQuesDetailArr,
                ]);
                
            }          

        } 



        $data = [
            "AllQuestionsArray" => $examData
        ];

        header('Content-Type:Application/json');
        echo json_encode($data); 

    }
   
?>
