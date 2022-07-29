<?php 
    $title = "question_type";

    require_once './templates/header.php';
    require_once './includes/session.php';
    
    $errList = [];
    $errors = ["typeErr" => ""];
    $question_type = '';

    if(isset($_GET['edit']))
    {
        $questionTypeQ = mysqli_query($connection, "SELECT * FROM `question_type` WHERE `question_type_id` = '$_GET[edit]'" );
        if(mysqli_num_rows($questionTypeQ) == 1 )
        {
            $typeRow = mysqli_fetch_assoc($questionTypeQ);
            $question_type = $typeRow['question_type_value'];
        }
    }

    if (isset($_POST['submit'])) 
    {
        $question_type = sanitise_input($_POST['question_type']);

        if(empty($question_type))
        {
            $errors["typeErr"] = "<p>Please fill required field</p>";
        }
        else
        {
            if(isset($_GET['edit']))
            {
                $existsQ = mysqli_query($connection, "SELECT `question_type_value` FROM `question_type` WHERE `question_type_value` = '$question_type' AND question_type_id != '$_GET[edit]'" );
            }
            else
            {
                $existsQ = mysqli_query($connection, "SELECT `question_type_value` FROM `question_type` WHERE `question_type_value` = '$question_type'" );
            }
            if(mysqli_num_rows($existsQ) >=1 )
            {
                $errors["typeErr"] = "<p>question_type already exists.</p>";
            }
        }

        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            if(isset($_GET['edit']))
            {
                $query = mysqli_query($connection, "UPDATE `question_type` SET `question_type_value` = '$question_type' WHERE question_type_id = '$_GET[edit]'");   
            }
            else
            {
                $query = mysqli_query($connection, "INSERT INTO `question_type`(`question_type_value`, `questionTypeAddedBy`) VALUES ('$question_type', '$_SESSION[userId]')");   
            }
            if($query)
            {
                header('Location:questionType-view.php?success=Action Done Successfully.');
            }
        }
    }

?>
 
<section>

    <h3 class="heading">Question Type</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Add Question Type</h4>
            </div>

            <a href="questionType-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Question Type</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>

            <div>
                <label for="question_type">Enter Question Type<span class="text-red">*</span></label>
                <input type="text" name="question_type" id="question_type" class="form-control" placeholder="Enter Question Type" autofocus value="<?= $question_type; ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-green">Add question_type</button>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>