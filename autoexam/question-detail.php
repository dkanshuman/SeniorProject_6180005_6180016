<?php 
    $title = "Question Detail";
    require_once './templates/header.php';
    require_once './includes/session.php';

    require_once './includes/teacher-subjects.php'; 
    
    if(isset($_SESSION['user']))
    {
        if(isset($_GET['question']))
        {
            $questionQuery = mysqli_query($connection, 
                "SELECT * FROM `question_bank` 
                LEFT JOIN `teacher_profile` ON `teacher_profile`.`teacher_id` = `question_bank`.`questionAddedBy`  
                LEFT JOIN subject_topic ON `question_bank`.`subject_topic_id` = `subject_topic`.`subject_topic_id`
                LEFT JOIN subject_details ON subject_details.subject_id = subject_topic.subject_id
                LEFT JOIN `major` ON `major`.`major_id` = `subject_details`.`major_id`
                LEFT JOIN `type_of_study` ON `type_of_study`.`type_of_study_id` = `major`.`type_of_study_id`
                LEFT JOIN `institute` ON  `institute`.`institute_id` = `type_of_study`.`institute_id`
                LEFT JOIN `question_type` On `question_type`.`question_abbr` = `question_bank`.`question_abbr`
                WHERE `question_bank`.`question_id` = '$_GET[question]'
                ");
        }
    }
?>

<section>

    <h3 class="heading">Question Detail</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Question Detail</h4>
            </div>

            <a href="question-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Questions</a>

        </div>

        <div class="table-responsive">
            <?php 
                require './includes/message.php';
            ?>
            <table class="table">
                <tbody>
                    <?php
                        if(mysqli_num_rows($questionQuery) == 1)
                        {
                            $questionR = mysqli_fetch_assoc($questionQuery);
                                echo "
                                    <tr>
                                        <th class=\"text-left\" style=\"width:30%;\" valign=\"top\">Question</th>
                                        <td style=\"width:70%;\">$questionR[question]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \" valign=\"top\">Answer</th>
                                        <td class=\"img-fluid\">$questionR[answer]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \">Score</th>
                                        <td>$questionR[score]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \">Type</th>
                                        <td>$questionR[question_type_value]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \">Options</th>
                                        <td>
                                            <p>$questionR[optionA]</p>
                                            <p>$questionR[optionB]</p>
                                            <p>$questionR[optionC]</p>
                                            <p>$questionR[optionD]</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \">Added By</th>
                                        <td>$questionR[teacher_firstname] $questionR[teacher_lastname]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \">Added On</th>
                                        <td>".date("d M Y", strtotime($questionR['addedOn']))."</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Subject Topic</th>
                                        <td>$questionR[subject_topic_name]</td>
                                     </tr>
                                    <tr>
                                        <th class=\"text-left\">Subject</th>
                                        <td>$questionR[subject_name]</td>
                                     </tr>
                                    <tr>
                                        <th class=\"text-left\">Major</th>
                                        <td>$questionR[major_name]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Study Type</th>
                                        <td>$questionR[study_name]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Institute</th>
                                        <td>$questionR[institute_name]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Added By</th>
                                        <td>$questionR[teacher_firstname] $questionR[teacher_lastname]</td>
                                     </tr>
                                    <tr>
                                        <th class=\"text-left\">Added On</th>
                                        <td>".date("d M, Y", strtotime($questionR['questionAddedOn']))."</td>
                                    </tr>";
                                    
                                // if($questionR['questionAddedBy'] == $_SESSION['userId'])
                                // {

                                if( ($_SESSION['userType'] == 'Admin') || ( $_SESSION['userType'] == 'Teacher' &&  in_array($questionR['subject_topic_id'], $topicArr))) 
                                {    

                                    echo "<tr>
                                        <td colspan=\"2\" class=\"text-center\">
                                    ";  

                                    if($questionR['question_abbr'] == 'MCQ')
                                    {
                                        echo "<a href=\"question-3-edit-mcq.php?edit=$questionR[question_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>";
                                    }
                                    else
                                    {
                                        echo "<a href=\"question-3-edit.php?edit=$questionR[question_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>";
                                    }
                                       

                                    echo " <a href=\"delete.php?delete_question=$questionR[question_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>
                                        </td>
                                    </tr>";

                                }
                        }
                        else
                        {
                            echo "<tr><td colspan=\"7\">0 Record found.</td></tr>";
                        }
                    ?>
                   
                </tbody>
            </table>
        </div>

    </div>


</section>


<?php 
    require_once './templates/footer.php';
?>