<?php
    session_start();
    require_once './includes/config.php'; 
    require_once './includes/connection.php';

    if (isset($_REQUEST['fetchStudyData'])) 
    {
?>       
        <label for="studytype">Select Study Type<span class="text-red">*</span></label>
        
            <?php 
                $studyQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE institute_id = '$_REQUEST[fetchStudyData]' ORDER BY `study_name`" );
                if(mysqli_num_rows($studyQ) >= 1 )
                {
                    echo "
                        <select name=\"studytype\" id=\"studytype\" class=\"form-control\" onchange=\"typeChanged(this.value)\">
                            <option value=\"\">Select Study Type</option>
                    ";
                    while($studyRow = mysqli_fetch_assoc($studyQ))
                    {
                        if($studyId == $studyRow['type_of_study_id'])
                        {
                            echo "<option value=\"$studyRow[type_of_study_id]\" selected>$studyRow[study_name]</option>";
                        }
                        else
                        {
                            echo "<option value=\"$studyRow[type_of_study_id]\">$studyRow[study_name]</option>";
                        }
                    }
                    echo "</select>";
                }
                else
                {
                    echo "No Study Type exists for the selected institute";
                }
            ?>
        
<?php
    }
    elseif(isset($_REQUEST['institute_id']))
    {
        $studyQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE institute_id = '$_REQUEST[institute_id]' ORDER BY `study_name`" );
        if(mysqli_num_rows($studyQ) >= 1 )
        {
            echo "<div class=\"radio-group-block\">";
                while($studyR = mysqli_fetch_assoc($studyQ))
                {
                    echo "
                        <div class=\"radio-group\">
                            <input type=\"radio\" name=\"study\" id=\"study$studyR[type_of_study_id]\" value=\"$studyR[type_of_study_id]\" onchange=\"showMajor(this.value)\">
                            <label for=\"study$studyR[type_of_study_id]\">$studyR[study_name]</label>
                        </div>";
                }
            echo "</div>";
        }
        else
        {
            echo "No record exists for the selected institute";
        }
    }

    elseif(isset($_REQUEST['fetchMajorData'])) 
    {
?>
    <?php 
        $majorQ = mysqli_query($connection, "SELECT * FROM `major` WHERE type_of_study_id = '$_REQUEST[fetchMajorData]' ORDER BY `major_name`" );
        if(mysqli_num_rows($majorQ) >= 1 )
        {
            echo "<select name=\"major\" id=\"major\" class=\"form-control\">
                    <option value=\"\">Select Major</option>";
                    while($majorRow = mysqli_fetch_assoc($majorQ))
                    {
                        echo "<option value=\"$majorRow[major_id]\">$majorRow[major_name]</option>";
                    }
            echo "</select>";        
        }
        else
        {
            echo "No major exists for the selected study type.";
        }
    ?>
   

<?php
    }
    elseif(isset($_REQUEST['fetchSubjectsData']))
    {
?>
        <label for="subject">Select Subject<span class="text-red">*</span></label>
        <select name="subject" id="subject" class="form-control">
            <option value="">Select Subject</option>
            <?php 
                $subjectsQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE major_id = '$_REQUEST[fetchSubjectsData]' ORDER BY `subject_name`" );
                if(mysqli_num_rows($subjectsQ) >= 1 )
                {
                    while($subjectRow = mysqli_fetch_assoc($subjectsQ))
                    {
                        echo "<option value=\"$subjectRow[subject_id]\">$subjectRow[subject_name]</option>";
                    }
                }
            ?>
        </select>
<?php
    }
    elseif( isset($_REQUEST['subject_id']) && isset($_REQUEST['topics']))
    {
        $topicQ = mysqli_query($connection, "SELECT * FROM `subject_topic` WHERE subject_id = '$_REQUEST[subject_id]' ORDER BY `subject_topic_name`" );
        if(mysqli_num_rows($topicQ) >= 1 )
        {
            if($_REQUEST['topics'] == 'multiple')
            {   
                echo "<div class=\"radio-group-block form-group-length \" >";

                    while($topicR = mysqli_fetch_assoc($topicQ))
                    {
                        echo "
                            <div class=\"radio-group\">
                                <input type=\"checkbox\" name=\"topic[]\" id=\"topic$topicR[subject_topic_id]\" value=\"$topicR[subject_topic_id]\">
                                <label for=\"topic$topicR[subject_topic_id]\">$topicR[subject_topic_name]</label>
                            </div>";
                    }
                echo "</div>";
            }
            if($_REQUEST['topics'] == 'single')
            { 
                echo "<select class=\"form-control\" name=\"topic\">";
                    echo "<option value=\"\">--SELECT TOPIC--</option>";
                    while($topicR = mysqli_fetch_assoc($topicQ))
                    {
                        echo "<option value=\"$topicR[subject_topic_id]\">$topicR[subject_topic_name]</option>";
                    }
                echo "</select>";    
            }
        }
        else
        {
            echo "No topic exists for this subject.";
        }
    }
    elseif( isset($_REQUEST['question_id']) && isset($_REQUEST['type']))
    {
        $questionQ = mysqli_query($connection, 
            "SELECT * FROM `question_bank` 
                LEFT JOIN subject_topic ON subject_topic.subject_topic_id = question_bank.subject_topic_id
                WHERE question_bank.question_id = '$_REQUEST[question_id]'
            " );
        
        if(mysqli_num_rows($questionQ) >= 1 )
        {
            $questionR = mysqli_fetch_assoc($questionQ);

            echo "<div class=\"relative-block\">";

                echo "<div class=\"topic-heading\">
                    <span>$questionR[subject_topic_name] <span class=\"badge badge-red\">$questionR[question_abbr]</span></span>";

                    if( isset( $_SESSION['questions'][$questionR['question_id']]) )
                    {
                        echo "<span class=\"btn-plus\" id=\"plusbtn$questionR[question_id]\">
                                &#x2713;
                            </span>";
                    }
                    else
                    {
                       echo  "<span id=\"plusbtn$questionR[question_id]\" class=\"btn-plus\">
                                <a href=\"javascript:void(0)\" onclick=\"addQuestionToExam($questionR[question_id], $questionR[score])\"  >&#43; </a>
                            </span>";
                    }
                echo "</div>";

                echo "<div class=\"right-question-block\">";

                    $newScore = '';
                    
                    if( isset( $_SESSION['score'][$questionR['question_id']]))
                    {
                        if($_SESSION['score'][$questionR['question_id']] != $questionR['score'])
                        {
                            $newScore =  "<span>New Score: <span style=\"padding: 6px 0; display:inline-block;\">". $_SESSION['score'][$questionR['question_id']]."</span></span>";
                        }
                    }    


                    echo "<p class=\"score\">
                            $newScore
                            <span>
                                Score :   
                                <span class=\"editableScore\" id=\"editableScore$questionR[question_id]\" contenteditable=\"true\" onblur=\"updateExamScore($questionR[question_id], this.innerText)\">$questionR[score]</span> 
                            </span>
                        </p>";  

                       
                    if($_REQUEST['type'] == 'question')
                    {
                        echo "<label>$questionR[question]</label>";
                    }
                    else if($_REQUEST['type'] == 'answer')
                    {
                        echo "<label>$questionR[answer]</label>";
                    }

                    
                echo "</div>";
               
               

            echo "</div>";
           
        }
    }
    elseif(isset($_REQUEST['add_question_id']) && isset($_REQUEST['score']))
    {
        $_SESSION['questions'][$_REQUEST['add_question_id']] = $_REQUEST['add_question_id'];
        $_SESSION['score'][$_REQUEST['add_question_id']] = $_REQUEST['score'];

        $totalscore = 0;
        foreach($_SESSION['score'] as $value)
        {
            $totalscore += $value;
        }
        echo $totalscore;
    }
    elseif(isset($_REQUEST['remove_question_id']) && isset($_REQUEST['score']))
    {
        if(isset($_SESSION['questions'][$_REQUEST['remove_question_id']]))
        {
            unset($_SESSION['questions'][$_REQUEST['remove_question_id']]);
        }

        if( isset($_SESSION['score'][$_REQUEST['remove_question_id']] ))
        {
            unset($_SESSION['score'][$_REQUEST['remove_question_id']]);
        }
        $totalscore = 0;
        foreach($_SESSION['score'] as $value)
        {
            $totalscore += $value;
        }
        echo $totalscore;
    }
?>