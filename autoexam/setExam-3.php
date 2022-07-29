<?php 

$title = "Generate Exam - 3";

require_once './templates/header.php';
require_once './includes/session.php';

?>
 
<section>

    <h3 class="heading">Set Exam</h3>

    <div class="card">

        <?php 
            if( isset($_GET['examId']))
            {
                $mode = "";

                $errList = [];
                $errors = ["typeErr" => "", "modeErr" => ""];

                $typeArr = [];

                // If exists already
                $examQ = mysqli_query($connection, "SELECT * FROM `exam` WHERE `examId` = '$_GET[examId]'");
                $examR = mysqli_fetch_assoc($examQ);
                $mode = $examR['examMode'];


                $exTypeQ =mysqli_query($connection, "SELECT * FROM exam_type WHERE `examId`= '$_GET[examId]'");

                if(mysqli_num_rows($exTypeQ) >= 1)
                {
                    while($exTypeR = mysqli_fetch_assoc($exTypeQ))
                    {
                        $typeArr[] = $exTypeR['question_abbr'];
                    }
                }


                $questionTypeQ = mysqli_query($connection, "SELECT * FROM `question_type` ORDER BY `question_type_value`");

                if(isset($_POST['submit']))
                {
                    $mode = sanitise_input($_POST['mode']);
                    
                    if(empty($mode))
                    {
                        $errors["modeErr"] = "<p>Please fill the required mode field</p>";
                    }

                    if(!isset($_POST['type']))
                    {
                        $errors["typeErr"] = "<p>Please fill the required question type field</p>";
                    }


                    if(array_filter($errors))
                    {
                        $errList = $errors;
                    }
                    else
                    {

                        $updateExamMode = mysqli_query($connection, "UPDATE exam SET examMode = '$mode' WHERE examId = '$_GET[examId]'");

                        if($updateExamMode)
                        {

                            $exType = mysqli_query($connection, "SELECT * FROM exam_type WHERE `examId`= '$_GET[examId]'");

                            if(mysqli_num_rows($exType) >= 1)
                            {
                                mysqli_query($connection, "DELETE FROM exam_type WHERE `examId`= '$_GET[examId]'");
                            }


                            foreach($_POST['type'] as $value)
                            {
                                $type = sanitise_input($value);

                                mysqli_query($connection, 
                                    "INSERT INTO `exam_type`
                                        (`question_abbr`, `examId`) 
                                        VALUES
                                                ('$type', '$_GET[examId]')
                                ");

                            }
                            if($mode == 'Random')
                            {
                                header("Location: setExam-4-Random.php?examId=$_GET[examId]");
                            }
                            elseif($mode == 'Manual')
                            {
                                header("Location: setExam-4.php?examId=$_GET[examId]");
                            }
                        }

                    }

                }

        ?>

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">SET YOUR EXAM</h4>
            </div>

        </div>

        <form method="post" class="form-container g-xlarge">
            
            <?php 
                require './includes/message.php';
            ?>


            <fieldset class="form-box">

                <legend><span class="index">6</span> Select Question Type</legend>

               
                    <?php 
                        if(mysqli_num_rows($questionTypeQ) >= 1 )
                        {
                            echo "<div class=\"radio-group-block form-group-length \" >";

                                while($questionTypeRow = mysqli_fetch_assoc($questionTypeQ))
                                {
                                    if( in_array($questionTypeRow['question_abbr'], $typeArr) )
                                    {
                                        echo "
                                        <div class=\"radio-group\">
                                            <input type=\"checkbox\" name=\"type[]\" id=\"type$questionTypeRow[question_type_value]\" value=\"$questionTypeRow[question_abbr]\" checked>
                                            <label for=\"type$questionTypeRow[question_type_value]\">$questionTypeRow[question_type_value]</label>
                                        </div>
                                        ";
                                    }
                                    else
                                    {
                                        echo "
                                        <div class=\"radio-group\">
                                            <input type=\"checkbox\" name=\"type[]\" id=\"type$questionTypeRow[question_type_value]\" value=\"$questionTypeRow[question_abbr]\">
                                            <label for=\"type$questionTypeRow[question_type_value]\">$questionTypeRow[question_type_value]</label>
                                        </div>
                                        ";
                                    }

                                }
                             
                            echo "</div>";    
                        }
                    ?>
              
            </fieldset>

            <fieldset class="form-box">
                
                <legend><span class="index">7</span> Exam Mode</legend>               
                
                <div class="radio-group-block">
                    <?php 
                        $examModeArr = ['Manual', 'Random']; 
                        foreach($examModeArr as $value)
                        {
                            if($mode == $value)
                            {
                                echo "
                                    <div class=\"radio-group\">
                                        <input type=\"radio\" name=\"mode\" id=\"$value\" value=\"$value\" required checked>
                                        <label for=\"$value\">$value</label>
                                    </div>
                                ";
                            }
                            else
                            {
                                echo "
                                    <div class=\"radio-group\">
                                        <input type=\"radio\" name=\"mode\" id=\"$value\" value=\"$value\" required>
                                        <label for=\"$value\">$value</label>
                                    </div>
                                ";
                            }
                            
                        }
                    ?>
                  
                </div>  
               
            </fieldset>

            <div>
                <button type="submit" name="submit" class="btn btn-green">Next</button>
            </div>

        </form>

        <?php
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