<?php 

$title = "Generate Manual Exam - 4";

require_once './templates/header.php';
require_once './includes/session.php';


?>
 
<section>

    <h3 class="heading">Set Exam</h3>

    <div class="card">

        <?php 
            if( isset($_GET['examId']))
            {

                if(isset($_SESSION['questions']) || isset($_SESSION['score']))
                {
                    unset($_SESSION['questions']);
                    unset($_SESSION['score']);
                } 

                $examQ = mysqli_query($connection, "SELECT * FROM exam WHERE examId = '$_GET[examId]'");

                if(mysqli_num_rows($examQ) >= 1 )
                {
                    $examR = mysqli_fetch_assoc($examQ);

                    $topicsId = '';
                    $questionTypeValue = '';

                    $examsTopicQ = mysqli_query($connection, "SELECT * FROM exam_topics WHERE examId = '$_GET[examId]'");

                    if(mysqli_num_rows($examsTopicQ) >= 1)
                    {
                        $topicArr = [];
                        while ($examTopicR = mysqli_fetch_assoc($examsTopicQ)) {
                        $topicArr[] = $examTopicR['topicId'];
                        }
                        $topicsId = implode(',',$topicArr);
                    }

                    $typeQ = mysqli_query($connection, "SELECT * FROM exam_type WHERE examId = '$_GET[examId]'");
                    
                    if(mysqli_num_rows($typeQ) >= 1)
                    {
                        while ($typeR = mysqli_fetch_assoc($typeQ)) 
                        {
                            $val = "'$typeR[question_abbr]'";
                            $typeArr[] = $val ;
                        }
                        $typeId = implode(',',$typeArr);
                    }

                    // FOR "EDIT" PART Starts
                    $queArr = [];
                    $examQuestionsExists = mysqli_query($connection, "SELECT * FROM exam_questions WHERE examId = '$_GET[examId]'"); 
                    if(mysqli_num_rows($examQuestionsExists) >= 1)
                    {
                       

                        while ($examQuestionsR = mysqli_fetch_assoc($examQuestionsExists)) 
                        {
                            $queArr[] = $examQuestionsR['questionId'];
                            $_SESSION['questions'][$examQuestionsR['questionId']] = $examQuestionsR['questionId'];
                            $_SESSION['score'][$examQuestionsR['questionId']] = $examQuestionsR['score'];
                            
                        }
                    }
                    // FOR "EDIT" PART Ends

                    $questionsQ = mysqli_query($connection, 
                        "SELECT * FROM question_bank 
                        LEFT JOIN subject_topic ON question_bank.subject_topic_id = subject_topic.subject_topic_id
                        LEFT JOIN question_type ON question_type.question_abbr = question_bank.question_abbr
                        WHERE question_bank.subject_topic_id IN ($topicsId) AND question_bank.question_abbr IN ( $typeId)");

        ?>

        <div class="card-heading">

            <div>
                <h4 class="sub-heading"><?= $examR['examMode']; ?> Quiz</h4>
            </div>

            <p>
                Total Score: 
                <span id="examScore">
                    <?php 
                        $totalscore = 0;
                        if( isset( $_SESSION['score'] ) )
                        {
                            foreach($_SESSION['score'] as $value)
                            {
                                $totalscore += (int)$value;
                            }
                        }
                        echo $totalscore;
                    ?>
                </span>
            </p>

        </div>

        <div>

        </div>

        <div class="main-block">


            <div class="left-block">

                <form method="post" class="form-container g-xlarge">
                    
                    <?php 
                        require './includes/message.php';
                    ?>


                    <fieldset class="form-box">

                            <ul class="question-lists">

                                <?php 
                                    if(mysqli_num_rows($questionsQ) >= 1) 
                                    {
                                        $i = 1;
                                        while ($questionR = mysqli_fetch_assoc($questionsQ)) 
                                        {
                                            $checked = "";
                                            $quesBg= "";
                                            if( isset($_SESSION['questions'][$questionR['question_id']]))
                                            {
                                                $checked = "<a class=\"btn btn-minus\" href='javascript:void(0)'><span>&#8722;</span></a>";
                                                $quesBg = "light-bg";
                                            }

                                            echo "<li class=\"question-block $quesBg\"  id=\"questionBlock$questionR[question_id]\">
                                                    
                                                    <p class=\"question-text text-sm\"> 
                                                        
                                                        <span class=\"question-type\"> 
                                                            $i. $questionR[subject_topic_name] 
                                                            - $questionR[score] Points -
                                                            <span class=\"text-right badge-red\">$questionR[question_abbr]</span>
                                                        </span>

                                                        <span class=\"checked\" onclick=\"removeQuestionFromExam($questionR[question_id], $questionR[score])\" id=\"checked$questionR[question_id]\">$checked</span>
 
                                                    </p>


                                                    <div class=\"btn-block\">
                                                        <a href=\"javascript:void(0)\" onclick=\"showQuestionDetails($questionR[question_id], 'question')\" class=\"btn-sm btn-green\">Question</a>
                                                        <a href=\"javascript:void(0)\" onclick=\"showQuestionDetails($questionR[question_id], 'answer')\" class=\"btn-sm btn-back\">Answer</a>
                                                    </div>
                                                
                                                </li>";

                                            $i++;
                                        }
                                    }

                                ?>
                            </ul>    
                    
                    </fieldset>

 
                    <div>
                        
                        <?php
                            if(isset($_GET['mode']))
                            {
                                $mode = $_GET['mode'];
                                if($mode == 'Random')
                                {
                                    $exmamode = 'Manual';
                                }
                                elseif($mode == 'Manual')
                                {
                                    $exmamode = 'Manual';
                                }
                            }
                            else
                            {
                                $exmamode = $examR['examMode'];
                            }
                        ?>

                        <a href="setExam-5.php?examId=<?= $_GET['examId']; ?>&&examMode=<?= $exmamode; ?>" class="btn btn-green">Final Submit</a>
                    </div>

                </form>

            </div>

            <div class="right-block" id="question-details">
                                    
            </div>

        </div>
      

        <?php
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
        ?>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>