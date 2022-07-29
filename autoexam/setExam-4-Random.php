<?php 

$title = "Generate Random Exam - 4";

require_once './templates/header.php';
require_once './includes/session.php';

?>
 
<section>

    <h3 class="heading">Set Exam</h3>

    <div class="card">

        <?php 

            $totalScore = 0;

            if( isset($_GET['examId']))
            {

                require_once './includes/previous-paper.php';  

                $examQ = mysqli_query($connection, "SELECT * FROM exam WHERE examId = '$_GET[examId]'");
                 

                if(mysqli_num_rows($examQ) >= 1 )
                {
                   
                    $examR = mysqli_fetch_assoc($examQ);

                    if(isset($_POST['submit']))
                    {   
                        $sum = array_sum($_POST['score']);

                            foreach($_POST['score'] as $key => $value )
                            {
                                $value = sanitise_input($value);
                                mysqli_query($connection, "UPDATE exam_topics SET score = '$value' WHERE topicId = '$key' AND examId = '$_GET[examId]' ");
                            }

                            header("Location: setExam-5.php?examId=$_GET[examId]&&examMode=$examR[examMode]&&score=$_POST[totalScore]");
                        
                    }

                    
                    // Fetch Topics
                    $examTopicsQ = mysqli_query($connection, 
                        "SELECT * FROM exam_topics 
                        LEFT JOIN subject_topic ON subject_topic.subject_topic_id = exam_topics.topicId
                        WHERE exam_topics.examId = '$_GET[examId]'");


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

        ?>

                <div class="card-heading">

                    <div>
                        <h4 class="sub-heading"><?= $examR['examMode']; ?> Quiz</h4>
                    </div>

                </div>

                <form method="post" class="form-container g-large" id="randomScoreForm">
                    
                    <?php 
                        require './includes/message.php';
                    ?>

                    <?php 
                        if(mysqli_num_rows($examTopicsQ) >= 1)
                        {
                            while ($examTopicsR = mysqli_fetch_assoc($examTopicsQ)) 
                            { 
                                if($prevQues != '')
                                {
                                    $sql = "SELECT SUM(score) as qscore, min(`score`) as minSc FROM `question_bank` WHERE `subject_topic_id` = '$examTopicsR[topicId]' AND `question_abbr` IN ($typeId) AND question_id NOT IN ($prevQues)";
                                }
                                else
                                {
                                    $sql = "SELECT SUM(score) as qscore, min(`score`) as minSc FROM `question_bank` WHERE `subject_topic_id` = '$examTopicsR[topicId]' AND `question_abbr` IN ($typeId)";
                                }


                                $questionBankQ = mysqli_query($connection, $sql);

                                $questionBankR = mysqli_fetch_assoc($questionBankQ);

                                echo "
                                    <div class=\"split-row\">
                                        
                                        <label for=\"\">
                                            Score For $examTopicsR[subject_topic_name]
                                            <span class=\"text-red f-sm\">(Min: $questionBankR[minSc], Max : $questionBankR[qscore])</span>
                                        </label>

                                        <input type=\"number\"  name=\"score[$examTopicsR[topicId]]\" class=\"form-control score-inp\" placeholder=\"Enter Total Score\" min=\"$questionBankR[minSc]\" max=\"$questionBankR[qscore]\" required>
                                    </div>
                                ";
                                $totalScore += $questionBankR['qscore'];
                            }
                        }

                    ?>

                    <div class="split-row">
                        <label for="">
                            Total Score
                            <span class="text-red f-sm">(Max : <?= $totalScore;?>)</span>
                        </label>
                        <input type="number" name="totalScore" class="form-control" placeholder="Enter Total Score" max="<?= $totalScore;?>" id="totalScore" value="0" disabled="true" required>

                    </div>

                    <div>
                        <input type="submit" value="Final Submit" name="submit" class="btn btn-green">
                    </div>

                </form>

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


<script>

    let randomScoreForm = document.getElementById("randomScoreForm");
    let totEl = document.querySelector("#totalScore");

    Array.from(randomScoreForm.elements).forEach(element => 
    {
        element.addEventListener("blur", function()
        {
            let totScore = 0;
            Array.from(randomScoreForm.elements).forEach(elem => 
            {
                if(elem.className === "form-control score-inp")
                {
                    if(elem.value != '')
                    {
                       let vl = parseInt(elem.value);
                        totScore += vl;
                        console.log("tot" + totScore);
                    }
                    totEl.value = totScore;
                }
            });
        });
    });

</script>


<?php 
    require_once './templates/footer.php';
?>