<?php 
    $title = "Question Bank";
    require_once './templates/header.php';
    require_once './includes/session.php';

    // Get the question type
    $questionTypeQ = mysqli_query($connection, "SELECT * FROM `question_type` ORDER BY question_type_value" );

    // Get the Subject Topics
    $subjectTopicQ = mysqli_query($connection, "SELECT * FROM `subject_topic` ORDER BY subject_topic_name" );

    $option1 = $option2 = $option3 = $option4 = "";

    $errList = [];
    $errors = ["subjectErr" => "", "questionErr" => "", "questionTypeErr" => "", "answerErr" => "", "scoreErr" => ""];
    $topicId = $QuestionType =  $question = $answer = $score ='' ;

    if(isset($_GET['topic']))
    {
        $topicId = $_GET['topic'];
    }


    if(isset($_POST['submit']))
    {
        $topicId = sanitise_input($_POST['subjectTopic']);
        $QuestionType = sanitise_input($_POST['QuestionType']);
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $score = sanitise_input($_POST['score']);

        if(empty($topicId))
        {
            $errors["subjectErr"] = "<p>Please fill the required subject field</p>";
        }
        if(empty($QuestionType))
        {
            $errors["questionTypeErr"] = "<p>Please fill the required Question Type field</p>";
        }
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


        $option1 = isset($_POST['option1']) ? $_POST['option1'] : '';
        $option2 = isset($_POST['option2']) ? $_POST['option2'] : '';
        $option3 = isset($_POST['option3']) ? $_POST['option3'] : '';
        $option4 = isset($_POST['option4']) ? $_POST['option4'] : '';

        if(isset($_POST['optGroup']))
        {
            $answergp = $_POST['optGroup'];
            $answer = $_POST[$answergp];
        }

       
        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            $query = mysqli_query($connection, "INSERT INTO `question_bank`
            (`subject_topic_id`, `question_abbr`, `question`, `optionA`, `optionB`, `optionC`, `optionD`, `answer`, `score`, `questionAddedBy`) 
            VALUES ('$topicId', '$QuestionType', '$question', '$option1', '$option2', '$option3', '$option4', '$answer', '$score', '$_SESSION[userId]');
            " );
            if($query)
            {
                $qid = $connection->insert_id;
                header("Location:question-3.php?topic=$topicId&&success=Action Done Successfully. View question <a href=\"question-detail.php?question=$qid\">here</a>.");
            }
          
        }

    }


?>

<section>

    <h3 class="heading">Question Papers</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Add Questions</h4>
            </div>

            <a href="question-view.php" class="btn  btn-green"><i class="fa-solid fa-eye"></i> View Questions</a>

        </div>

        <?php 
            require './includes/modal.php';
        ?>

        <form method="post" class="form-container g-large">
            <?php 
                require './includes/message.php';
            ?>
            <div>
                <label for="">Choose Subject Topic</label>
                <?php 
                    if(mysqli_num_rows($subjectTopicQ) >= 1 )
                    {
                        echo "<select name=\"subjectTopic\" id=\"\" class=\"form-control\" autofocus>";
                            echo "<option value=\"\">Select Subject Topic</option>";
                            while($topicRow = mysqli_fetch_assoc($subjectTopicQ))
                            {
                                if($topicId == $topicRow['subject_topic_id'])
                                {
                                    echo "<option value=\"$topicRow[subject_topic_id]\" selected>$topicRow[subject_topic_name]</option>"; 
                                }
                                else
                                {
                                    echo "<option value=\"$topicRow[subject_topic_id]\">$topicRow[subject_topic_name]</option>"; 
                                }
                            }
                        echo "</select>";    
                    }
                ?>
            </div>

            <div>
                <label for="">Choose Question Type</label>
                <?php 
                    if(mysqli_num_rows($questionTypeQ) >= 1 )
                    {
                        echo "<select name=\"QuestionType\" id=\"\" class=\"form-control\" onchange=\"getAnswerType(this.value)\">";
                            echo "<option value=\"\">Select Question Type</option>";
                            while($typeRow = mysqli_fetch_assoc($questionTypeQ))
                            {
                                if($QuestionType == $typeRow['question_abbr'])
                                {
                                    echo "<option value=\"$typeRow[question_abbr]\" selected>$typeRow[question_type_value]</option>";
                                }
                                else
                                {
                                    echo "<option value=\"$typeRow[question_abbr]\">$typeRow[question_type_value]</option>";
                                }
                            }
                        echo "</select>";    
                    }
                ?>
            </div>

            <div>
                <label for="">Enter Question</label>
                <div>
                    <a href="javascript:void(0)" class="icon-btn" title="Add Table" onclick="displayEditorForm('table-block', 'questionContent', 'questionEditor')"><i class="fa-solid fa-table"></i></a>
                    <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'questionContent', 'questionEditor')"><i class="fa-solid fa-image"></i></a>
                </div>
            </div>

            <textarea name="question" id="questionContent" class="form-control" style="display: none;"><?= $question; ?></textarea>

            <div id="questionEditor" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'questionContent')"  aria-placeholder="Enter Question">
            <?= $question; ?>
            </div>


            <div id="hide">
                <div>
                    <label for="" class="form-label">Enter Options</label>

                    <div class="mt">
                        <label for="" class="form-label">Option 1</label>

                        <div>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Table"  onclick="displayEditorForm('table-block', 'op1', 'answerEditorop1')"><i class="fa-solid fa-table"></i></a>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'op1', 'answerEditorop1')"><i class="fa-solid fa-image"></i></a>
                        </div>

                        <textarea name="option1" id="op1" class="form-control" style="display: none;"><?= $option1; ?></textarea>

                        <div id="answerEditorop1" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'op1')" aria-placeholder="Enter Answer">
                        <?= $option1; ?>
                        </div>
                    </div>


                    <div class="mt">
                        <label for="" class="form-label">Option 2</label>
                        
                        <div>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Table"  onclick="displayEditorForm('table-block', 'op2', 'answerEditorop2')"><i class="fa-solid fa-table"></i></a>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'op2', 'answerEditorop2')"><i class="fa-solid fa-image"></i></a>
                        </div>

                        <textarea name="option2" id="op2" class="form-control" style="display: none;"><?= $option2; ?></textarea>

                        <div id="answerEditorop2" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'op2')" aria-placeholder="Enter Answer">
                        <?= $option2; ?>
                        </div>
                    </div>

                    <div class="mt">
                        <label for="" class="form-label">Option 3</label>
                        
                        <div>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Table"  onclick="displayEditorForm('table-block', 'op3', 'answerEditorop3')"><i class="fa-solid fa-table"></i></a>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'op3', 'answerEditorop3')"><i class="fa-solid fa-image"></i></a>
                        </div>

                        <textarea name="option3" id="op3" class="form-control" style="display: none;"><?= $option3; ?></textarea>

                        <div id="answerEditorop3" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'op3')" placeholder="Enter Answer">
                        <?= $option3; ?>
                        </div>
                    </div>

                    <div class="mt">
                        <label for="" class="form-label">Option 4</label>
                        
                        <div>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Table"  onclick="displayEditorForm('table-block', 'op4', 'answerEditorop4')"><i class="fa-solid fa-table"></i></a>
                            <a href="javascript:void(0)" class="icon-btn" title="Add Image" onclick="displayEditorForm('upload-block', 'op4', 'answerEditorop4')"><i class="fa-solid fa-image"></i></a>
                        </div>

                        <textarea name="option4" id="op4" class="form-control" style="display: none;"><?= $option4; ?></textarea>

                        <div id="answerEditorop4" class="editor" contenteditable="true" onkeyup="addContent(this.innerHTML, 'op4')" placeholder="Enter Answer">
                        <?= $option4; ?>
                        </div>
                    </div>

                </div>

                <div>
                    <label for="" class="form-label">Correct Option</label>
                    <input type="radio" name="optGroup" id="opt1" value="option1"> <label  for="opt1">Option 1</label><br>
                    <input type="radio" name="optGroup" id="opt2" value="option2"> <label  for="opt2">Option 2</label><br>
                    <input type="radio" name="optGroup" id="opt3" value="option3"> <label  for="opt3">Option 3</label><br>
                    <input type="radio" name="optGroup" id="opt4" value="option4"> <label  for="opt4">Option 4</label><br>
                    <!-- <input type="radio" name="optGroup" id="opt1" value="op1" onchange="getOptionValue(this.value)"> <label  for="opt1">Option 1</label><br>
                    <input type="radio" name="optGroup" id="opt2" value="op2" onchange="getOptionValue(this.value)"> <label  for="opt2">Option 2</label><br>
                    <input type="radio" name="optGroup" id="opt3" value="op3" onchange="getOptionValue(this.value)"> <label  for="opt3">Option 3</label><br>
                    <input type="radio" name="optGroup" id="opt4" value="op4" onchange="getOptionValue(this.value)"> <label  for="opt4">Option 4</label><br> -->
                </div>
               
            </div>
 
            
            <div class="hide" id="answerHide">
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
    require_once './templates/footer.php';
?>