<?php 
    session_start();
    require_once './includes/session.php';

    require './includes/config.php'; 
    require_once './includes/connection.php';

    ob_start();

    if( isset($_GET['examId']) && isset($_GET['examMode']))
    {

        if($_GET['examMode'] == 'Manual')
        {

            if(isset($_SESSION['questions']))
            {

                $exists = mysqli_query($connection, "DELETE FROM  `exam_questions` WHERE `examId` = '$_GET[examId]'");

                foreach ($_SESSION['questions'] as $key => $value) 
                {
                    $score =  $_SESSION['score'][$key];

                    $exists = mysqli_query($connection, "SELECT * FROM `exam_questions` WHERE `questionId` = '$value' AND `examId` = '$_GET[examId]'");
                    
                    mysqli_query($connection, "INSERT INTO `exam_questions`(`questionId`, `examId`, `score`, `questionOrder`) VALUES ('$value', '$_GET[examId]', '$score', 0)");
                }

                $date = date("Ymd");
                mysqli_query($connection, "UPDATE exam SET examName = '$date' WHERE examId = '$_GET[examId]'");
            }

            unset($_SESSION['questions']);
            unset($_SESSION['score']);

            header("Location: preview.php?exam_id=$_GET[examId]&&examMode=$_GET[examMode]&&type=question");  

        }


        else if($_GET['examMode'] == 'Random')
        {
            require_once './includes/previous-paper.php'; 

            echo "<pre>";

            $maxScore = $_GET['score'];

            $typeQ = mysqli_query($connection, "SELECT * FROM exam_type WHERE examId = '$_GET[examId]'");
                
            if(mysqli_num_rows($typeQ) >= 1)
            {
                while ($typeR = mysqli_fetch_assoc($typeQ)) {
                    $val = "'$typeR[question_abbr]'";
                    $typeArr[] = $val ;
                }
                $typeId = implode(',',$typeArr);
            }
            
            $examTopics = mysqli_query($connection, "SELECT * FROM `exam_topics` WHERE examId = '$_GET[examId]'");

            $topic_score_arr = [];

            $examQuestionArr = [];

            while($examTopic = mysqli_fetch_assoc($examTopics))
            {
                $topicScore = $examTopic['score'];

                $topicAddedSc = 0;

                $left = 0;  

                $questionsScoreArr = []; 
                $leftQuestionArr = [];
                
                $leftScore = 0;

                $scoreArr = [];
                
                if($prevQues != '')
                {
                    $sql = "SELECT * FROM `question_bank` WHERE `subject_topic_id` = '$examTopic[topicId]'  AND `question_abbr` IN ( $typeId) AND `question_id` NOT IN ($prevQues) AND `score` <= '$topicScore'";
                }
                else
                {
                    $sql = "SELECT * FROM `question_bank` WHERE subject_topic_id = '$examTopic[topicId]'  AND `question_abbr` IN ( $typeId)  AND `score` <= '$topicScore'";
                }   

                $questionBank = mysqli_query($connection, $sql);
                
                if(mysqli_num_rows($questionBank) >= 1) 
                {
                    while ($questionInfo = mysqli_fetch_assoc($questionBank)) 
                    {
                        $questionsScoreArr[] = [$questionInfo['question_id'] => $questionInfo['score'] ];
                        $scoreArr[] = $questionInfo['score'];
                    }

                }

                shuffle($questionsScoreArr);

                print_r($questionsScoreArr);

                $counter = 0;

                foreach ($questionsScoreArr as $key => $value) 
                {
                    foreach ($value as $k => $v) 
                    {
                        if(($topicAddedSc + $v) <= $topicScore)
                        {
                            $topicAddedSc += $v;
                            array_push($examQuestionArr, [$k => $v]);
                            $counter++;
                            $leftScore = $topicScore - $topicAddedSc;
                        }
                        else
                        {
                            array_push($leftQuestionArr, [$k => $v]);
                        }
                        
                        if( $topicAddedSc ==  $topicScore)
                        {
                            break;
                        }
                    }
                }

             

                echo "<p>**************** EXAM QUES ARR $examTopic[topicId]  - PART 1 *****************</p>";
                print_r($examQuestionArr);

                echo "<p>Added: $topicAddedSc, Left Score: $leftScore</p>";


                if($topicAddedSc < $topicScore)
                {
                    echo "Topic is less<br>";
                    while($topicAddedSc < $topicScore)
                    {
                        // Traverse through left question array to get minimum and max available score
                        $leftScArr = [];
                        $newScArr = [];
                        foreach ($leftQuestionArr as $key => $value) 
                        {
                            foreach ($value as $leftkey => $leftval) 
                            {
                                array_push($leftScArr, $leftval);
                            }
                        }

                        echo "<p>*********** LEFT SCORE: ***********</p>";
                        sort($leftScArr);
                        $min = min($leftScArr);
                        $max = max($leftScArr);

                        // If left score is in the range then traverse through left array
                        if($leftScore >= $min && $leftScore <= $max)
                        {
                            foreach ($leftQuestionArr as $key => $value) 
                            {
                                foreach ($value as $k => $v) 
                                {  
                                    if(($topicAddedSc + $v) <= $topicScore)
                                    {
                                        $topicAddedSc += $v;
                                        array_push($examQuestionArr, [$k => $v]);
                                        $topicAddedSc += $v;
                                        unset($leftQuestionArr[$k]);
                                        $leftScore = $topicScore - $topicAddedSc;
                                    }
                                
                                    if( $topicAddedSc ==  $topicScore)
                                    {
                                        break;
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo "<p>Added: $topicAddedSc, Left Score: $leftScore</p>";
                            break;
                        }

                        echo "<p>**************** EXAM QUES ARR $examTopic[topicId]  - PART 2 *****************</p>";
                        print_r($examQuestionArr);
        
                        echo "<p>Added: $topicAddedSc, Left Score: $leftScore</p>";
                    }

                }


                print_r($examQuestionArr);
                echo "<p>Added: $topicAddedSc, Left Score: $leftScore</p>";


                // Increment the score for each question
                if($topicAddedSc < $topicScore)
                {
                    while($topicAddedSc < $topicScore)
                    {
                        foreach ($examQuestionArr as $key => $value) 
                        {
                            foreach($value as $k => $v)
                            {
                                if($topicAddedSc == $topicScore)
                                {
                                    break;
                                }
                                else if($topicAddedSc < $topicScore)
                                {
                                    $examQuestionArr[$key][$k] = $v + 1;
                                    $topicAddedSc += 1;
                                    $leftScore--;
                                }
                                else
                                {
                                    break;
                                }
                            }
                            
                        }
                    }

                }

                echo "<p>**************** FINAL $examTopic[topicId] *****************</p>";
                print_r($examQuestionArr);
                echo "<p>Added: $topicAddedSc, Left Score: $leftScore</p>";

                
              
            }

            $order = 1;

            foreach ($examQuestionArr as $key => $questionAr) 
            {
                foreach($questionAr as $ques => $score)
                {
                    mysqli_query($connection, "INSERT INTO `exam_questions`(`examId`, `questionId`, `score`, `questionOrder`) VALUES ('$_GET[examId]', '$ques',  '$score', '$order')");
                    $order++;
                }
            }


            $date = date("Ymd");
            mysqli_query($connection, "UPDATE exam SET examName = '$date' WHERE examId = '$_GET[examId]'");
            
            header("Location: preview.php?exam_id=$_GET[examId]&&examMode=$_GET[examMode]&&type=question");  

        }

    }

    ob_end_flush();


?>