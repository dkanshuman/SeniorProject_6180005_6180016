<?php 
    $title = "Subject";
    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php';
    
    $errList = [];
    $errors = ["instituteErr" => "", "studyErr" => "", "majorErr" => "", "subjectErr" => ""];
    $majorId = $studyId = $institute_id = $subject_name ='' ;

    if(isset($_GET['edit']))
    {
        $majorEditQ = mysqli_query($connection, 
            "SELECT * FROM `subject_details` 
            LEFT JOIN `major` ON `major`.`major_id` = `subject_details`.`major_id`
            LEFT JOIN `type_of_study` ON `major`.`type_of_study_id` = `type_of_study`.`type_of_study_id`
            WHERE `subject_details`.`subject_id` = '$_GET[edit]'" 
        );  
        if(mysqli_num_rows($majorEditQ) == 1 )
        {
            $majorRow = mysqli_fetch_assoc($majorEditQ);
            $studyId = $majorRow['type_of_study_id'];
            $majorId = $majorRow['major_id'];
            $institute_id = $majorRow['institute_id'];            
            $subject_name = $majorRow['subject_name'];            
        }
    }

    if (isset($_POST['submit'])) 
    {

        $institute = isset($_POST['institute']) ? sanitise_input($_POST['institute']) : '';
        $studytype = isset($_POST['study']) ? sanitise_input($_POST['study']) : '';
        $major = isset($_POST['major']) ? sanitise_input($_POST['major']) : '';
        $subject = sanitise_input($_POST['subject']);


        if(empty($institute))
        {
            $errors["instituteErr"] = "<p>Please fill the required institute field</p>";
        }

        if(empty($studytype))
        {
            $errors["studyErr"] = "<p>Please fill the required study type field</p>";
        }

        if(empty($major))
        {
            $errors["majorErr"] = "<p>Please fill the required major field</p>";
        }

        if(empty($subject))
        {
            $errors["subjectErr"] = "<p>Please fill the required subject field</p>";
        }
        else
        {
            if(isset($_GET['edit']))
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE `subject_name` = '$subject' AND major_id = '$majorId' AND subject_id != '$_GET[edit]'" );
            }
            else
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE `subject_name` = '$subject' AND major_id = '$majorId'" );
            }
            if(mysqli_num_rows($existsQ) >=1 )
            {
                $errors["studyErr"] = "<p>Subject already exists.</p>";
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
                $query = mysqli_query($connection, "UPDATE `subject_details` SET `subject_name` = '$subject', `major_id` = '$major' WHERE subject_id = '$_GET[edit]'");   
            }
            else
            {
                $query1 = mysqli_query($connection, "INSERT INTO `subject_details` (`subject_name`, `major_id`, `subjectAddedBy`) VALUES ('$subject', '$major', '$_SESSION[userId]')");  
                if($query1)
                {
                    $subId = $connection->insert_id;
                    $majorQ = mysqli_fetch_assoc(mysqli_query($connection, "SELECT major_name FROM major WHERE major_id = '$major'"));
                    $subjectCode = strtoupper(substr($majorQ['major_name'], 0,3)).'-0'.$subId;
                    $subjectCode = str_replace(" ", "", $subjectCode);
                    $query = mysqli_query($connection, "UPDATE `subject_details` SET subject_code = '$subjectCode' WHERE subject_id = '$subId' "); 
                } 
            }
            if($query)
            {
                header('Location:subject-view.php?success=Action Done Successfully.');
            }
        }
    }

?>
 
<section>

    <h3 class="heading">Subject</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Add Subject</h4>
            </div>

            <a href="subject-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Subject</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>
          
            <?php
                require './includes/step-1.php';
            ?>

            <fieldset class="form-box">
                <legend><span class="index">4</span> Enter Subject</legend>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject" value="<?= $subject_name; ?>">
            </fieldset>

            <button type="submit" name="submit" class="btn btn-green">Submit</button>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>