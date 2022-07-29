<?php 
    $title = "Add Subject - 2";
    require_once './templates/header.php';
    require_once './includes/session.php';
    
    $errList = [];
    $errors = ["topicErr" => "", "subjectErr" => ""];
    $subject_topic_name = $subject_id = '' ;

    $addedSubjectIds = [];

    $subjectIds = [];


    if( isset($_GET['institute']) && isset($_GET['study']) && isset($_GET['major'])  && isset($_GET['teacher']) )
    {
        $subjectDetailQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE `major_id` = '$_GET[major]' ORDER BY `subject_name`");

        $subjectTeacherRelationQ = mysqli_query($connection, "SELECT * FROM teacher_subject_relation WHERE teacherId = '$_GET[teacher]'");
        if(mysqli_num_rows($subjectTeacherRelationQ) >= 1)
        {
            while ($subjectTeacherRelationR = mysqli_fetch_assoc($subjectTeacherRelationQ)) 
            {
                array_push($addedSubjectIds, $subjectTeacherRelationR['subjectId']);
            }
        }


        $subjectIdDetailQ = mysqli_query($connection, "SELECT subject_id FROM `subject_details` WHERE `major_id` = '$_GET[major]' ORDER BY `subject_id`");

        if(mysqli_num_rows($subjectIdDetailQ) >= 1 )
        {
            while($subjectRow = mysqli_fetch_assoc($subjectIdDetailQ))
            {
                array_push($subjectIds, $subjectRow['subject_id']);
            }
        }

    }



    if (isset($_POST['submit'])) 
    {

        $checkQ = mysqli_query($connection, "SELECT * FROM `teacher_subject_relation` WHERE teacherId = '$_GET[teacher]'");  
        
        if(mysqli_num_rows($checkQ) >= 1)
        {
            mysqli_query($connection, 
                "DELETE FROM `teacher_subject_relation` 
                    WHERE teacherId = '$_GET[teacher]' 
                        AND subjectId IN (".implode(',', $subjectIds).")
                ");
        }

        foreach($_POST['subjects'] as $value)
        {
            $subject = sanitise_input($value);
            mysqli_query($connection, "INSERT INTO `teacher_subject_relation`(`teacherId`, `subjectId`) VALUES ('$_GET[teacher]', '$subject')");
        }

        header("Location:teacher-subject-view.php?teacher=$_GET[teacher]&&success=Action done successfully.");
    }

?>
 
<section>

    <h3 class="heading">Topic</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Enter Topic</h4>
            </div>

            <a href="topic-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Topic</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>

            <fieldset class="form-box">
                
                <legend><span class="index">4</span> Select Subject</legend>
               
                <?php 
                    if(mysqli_num_rows($subjectDetailQ) >= 1 )
                    {
                        echo "<div class=\"radio-group-block form-group-length \" >";

                        while($subjectRow = mysqli_fetch_assoc($subjectDetailQ))
                        {
                            if(in_array($subjectRow['subject_id'], $addedSubjectIds))
                            {
                                echo "
                                    <div class=\"radio-group\">
                                        <input type=\"checkbox\" name=\"subjects[]\" id=\"subject$subjectRow[subject_id]\" value=\"$subjectRow[subject_id]\" checked>
                                        <label for=\"subject$subjectRow[subject_id]\">$subjectRow[subject_name]</label>
                                    </div>";
                            }
                            else
                            {
                                echo "
                                    <div class=\"radio-group\">
                                        <input type=\"checkbox\" name=\"subjects[]\" id=\"subject$subjectRow[subject_id]\" value=\"$subjectRow[subject_id]\">
                                        <label for=\"subject$subjectRow[subject_id]\">$subjectRow[subject_name]</label>
                                    </div>";
                            }
                            
                        }

                        echo "</div>";

                    }
                ?>

            </fieldset>

            <div>
                <button type="submit" name="submit" class="btn btn-green">Submit</button>
            </div>

        </form>

    </div>

</section>


<?php

    require_once './templates/footer.php';
?>