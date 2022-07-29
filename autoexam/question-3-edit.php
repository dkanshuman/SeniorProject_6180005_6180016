<?php 
    $title = "Question Bank";
    require_once './templates/header.php';
    require_once './includes/session.php';

    // Get the question type
    $questionTypeQ = mysqli_query($connection, "SELECT * FROM `question_type` ORDER BY question_type_value" );

    // Get the Subject Topics
    $subjectTopicQ = mysqli_query($connection, "SELECT * FROM `subject_topic` ORDER BY subject_topic_name" );

    $errList = [];
    $errors = ["subjectErr" => "", "questionErr" => "", "questionTypeErr" => "", "answerErr" => "", "scoreErr" => ""];
    $topicId = $QuestionType =  $question = $answer = $score ='' ;
    $option1 = $option2 = $option3 = $option4 = "";

    if(isset($_GET['topic']))
    {
        $topicId = $_GET['topic'];
    }

    if(isset($_GET['edit']))
    {
        $questionQ = mysqli_query($connection, 
            "SELECT * FROM `question_bank` 
            WHERE `question_bank`.`question_id` = '$_GET[edit]'" 
        );  
        
        if(mysqli_num_rows($questionQ) == 1 )
        {
            $questionRow = mysqli_fetch_assoc($questionQ);
            $question = $questionRow['question'];
            $topicId = $questionRow['subject_topic_id'];
            $QuestionType = $questionRow['question_abbr'];
            $answer = $questionRow['answer'];
            $score = $questionRow['score'];
        

    if(isset($_POST['submit']))
    {
        $question = $_POST['question'];
        $score = sanitise_input($_POST['score']);
        $answer = $_POST['answer'];


        if(empty($question))
        {
            $errors["questionErr"] = "<p>Please fill the required question field</p>";
        }
        if(empty($answer))
        {
            $errors["answerErr"] = "<p>Please fill the required answer field</p>";
        }
        if(empty($score))
        {
            $errors["scoreErr"] = "<p>Please fill the required score field</p>";
        }


        // $option1 = isset($_POST['option1']) ? $_POST['option1'] : '';
        // $option2 = isset($_POST['option2']) ? $_POST['option2'] : '';
        // $option3 = isset($_POST['option3']) ? $_POST['option3'] : '';
        // $option4 = isset($_POST['option4']) ? $_POST['option4'] : '';

        // if(isset($_POST['optGroup']))
        // {
        //     $answergp = $_POST['optGroup'];
        //     $answer = $_POST[$answergp];
        // }
        // else
        // {
        // }


        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            $query = mysqli_query($connection, "UPDATE `question_bank` SET
            `question`='$question', `answer`='$answer', `score`='$score'
            WHERE `question_id` = '$_GET[edit]'
            " );
            if($query)
            {
                header("Location:question-detail.php?question=".$_GET['edit']);
            }
        }

    }


?>

<section>

    <h3 class="heading">Questions</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Edit Questions</h4>
            </div>

            <a href="question-view.php" class="btn  btn-green"><i class="fa-solid fa-eye"></i> View Questions</a>

        </div>

        <?php 
            include './includes/modal.php';
        ?>


        <form method="post" class="form-container g-large">
            <?php 
                require './includes/message.php';
            ?>
           

            <div>
                <label for="">Enter Question</label>
                <div>
                    <a href="javascript:void(0)" class="icon-btn" title="Add Table" onclick="displayEditorForm('table-block', 'questionContent', 'questionEditor')"><i class="fa-solid fa-table"></i></a>
                    <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'questionContent', 'questionEditor')"><i class="fa-solid fa-image"></i></a>
                </div>
            </div>

            <textarea name="question" id="questionContent" class="form-control" style="display: none;"><?= $question; ?></textarea>

            <div id="questionEditor" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'questionContent')" aria-placeholder="Enter Question">
            <?= $question; ?>
            </div>

            <div>
                <label for="answer" class="form-label">Enter Answer</label>
                <div>
                    <a href="javascript:void(0)" class="icon-btn" title="Add Table"  onclick="displayEditorForm('table-block', 'answerContent', 'answerEditor')"><i class="fa-solid fa-table"></i></a>
                    <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'answerContent', 'answerEditor')"><i class="fa-solid fa-image"></i></a>
                </div>
            </div>

            <textarea name="answer" id="answerContent" class="form-control" style="display: none;"><?= $answer; ?></textarea>

            <div id="answerEditor" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'answerContent')" aria-placeholder="Enter Answer">
            <?= $answer; ?>
            </div>
        

            <div>
                <label for="score" class="form-label">Enter Score</label>
                <input type="number" name="score" class="form-control" id="score" placeholder="Enter score" value="<?= $score; ?>">
            </div>

            <button type="submit" class="btn btn-green" name="submit" onclick="contentAdd()">Submit</button>

        </form>

    </div>

</section>


<script src="./assets/js/question-editor.js"></script>

<?php 
}
}
    require_once './templates/footer.php';
?>