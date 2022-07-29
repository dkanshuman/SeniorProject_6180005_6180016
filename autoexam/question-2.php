<?php 

$title = "Question - 2";

require_once './templates/header.php';
require_once './includes/session.php';

$subjectIds = [];

if($_SESSION['userType'] == 'Teacher')
{
    $teacherIdQ = mysqli_query($connection, "SELECT * FROM `teacher_subject_relation` WHERE teacherId = '$_SESSION[userId]'");

    if(mysqli_num_rows($teacherIdQ) >= 1)
    {
        while ($teacherIdR = mysqli_fetch_assoc($teacherIdQ)) {
            array_push($subjectIds, $teacherIdR['subjectId']);
        }
    }
}

?>
 
<section>

    <h3 class="heading">Add Questions</h3>

    <div class="card">

        <?php 
            $errList = [];
            $errors = ["subjectErr" => "", "topicErr" => ""];

            $subject = '';

            if( isset($_GET['institute']) && isset($_GET['study']) && $_GET['major'] )
            {
                if(isset($_GET['subject']))
                {
                    $subject = $_GET['subject'];
                }

                $subjectDetailQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE `major_id` = '$_GET[major]' ORDER BY `subject_name`");

                $questionTypeQ = mysqli_query($connection, "SELECT * FROM `question_type` ORDER BY `question_type_value`");

                if(isset($_POST['submit']))
                {
                    $subject = isset($_POST['subject']) ? sanitise_input($_POST['subject']) : '';
                    $topic = isset($_POST['topic']) ? sanitise_input($_POST['topic']) : '';
                    
                    if(empty($subject))
                    {
                        $errors["subjectErr"] = "<p>Please fill the required Subject field</p>";
                    }

                    
                    if($_SESSION['userType'] == 'Teacher')
                    {
                        if(!in_array($subject, $subjectIds))
                        {
                            $errors["subjectErr"] = "<p>You are not allowed to add topic of the selected subject.</p>";
                        }
                    }

            
                    if(empty($topic) )
                    {
                        $errors["topicErr"] = "<p>Please fill the required Topic field</p>";
                    }
            
            
                    if(array_filter($errors))
                    {
                        $errList = $errors;
                    }
                    else
                    {
                        header("Location: question-3.php?topic=$topic");
                    }
                }

        ?>

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Select Subject And Subtopics</h4>
            </div>

        </div>

        <form method="post" class="form-container g-xlarge">
            
            <?php 
                require './includes/message.php';
            ?>

            <fieldset class="form-box">
                
                <legend><span class="index">4</span> Select Subject</legend>

                <select name="subject" id="subject" class="form-control" onchange="fetchTopics(this.value, 'single')">
                    <option value="">Select Subject</option>
                    <?php 
                        if(mysqli_num_rows($subjectDetailQ) >= 1 )
                        {
                            while($subjectRow = mysqli_fetch_assoc($subjectDetailQ))
                            {
                                // if($_SESSION['userType'] == 'Teacher')
                                // {
                                //     if(in_array($subjectRow['subject_id'], $subjectIds))
                                //     {
                                //         if($subject == $subjectRow['subject_id'])
                                //         {
                                //             echo "<option value=\"$subjectRow[subject_id]\" selected>$subjectRow[subject_name]</option>";
                                //         }
                                //         else
                                //         {
                                //             echo "<option value=\"$subjectRow[subject_id]\">$subjectRow[subject_name]</option>";
                                //         }
                                //     }
                                //     else
                                //     {
                                //         echo "<option value=\"$subjectRow[subject_id]\" disabled=\"disabled\">$subjectRow[subject_name]</option>";
                                //     }  
                                // }
                                // else
                                // {
                                    if($subject == $subjectRow['subject_id'])
                                    {
                                        echo "<option value=\"$subjectRow[subject_id]\" selected>$subjectRow[subject_name]</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"$subjectRow[subject_id]\">$subjectRow[subject_name]</option>";
                                    }
                                // }
                            }
                        }
                    ?>
                </select>

            </fieldset>

            <fieldset class="form-box">

                <legend><span class="index">5</span> Select Subject Topic</legend>
                
                <div id="subjectTopicResponse">

                    <?php
                        if(isset($_GET['subject']))
                        {
                            $topicQ = mysqli_query($connection, "SELECT * FROM `subject_topic` WHERE subject_id = '$_GET[subject]' ORDER BY `subject_topic_name`" );
                            if(mysqli_num_rows($topicQ) >= 1 )
                            {
                                echo "<select class=\"form-control\" name=\"topic\">";
                                    echo "<option value=\"\">--SELECT TOPIC--</option>";
                                    while($topicR = mysqli_fetch_assoc($topicQ))
                                    {
                                        echo "<option value=\"$topicR[subject_topic_id]\">$topicR[subject_topic_name]</option>";
                                    }
                                echo "</select>"; 

                            }
                            else
                            {
                                echo "No Topic exists For this subject";
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