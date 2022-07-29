<?php 
    $title = "Question - 1";
    require_once './templates/header.php';
    require_once './includes/session.php';

    require_once './includes/teacher-subjects.php';
 
    if($_SESSION['userType'] == 'Teacher')
    {
        if(mysqli_num_rows($teacherSubjectsQ) < 1)
        {
            header("Location:dashboard.php?error=You can't add questions as you have not been assigned any subject.");
        }
    }
    
    $errList = [];
    $errors = ["instituteErr" => "", "studyErr" => "", "majorErr" => ""];
    $institute_id = $studyId = $majorId = $subject_topic_name = $subject_id = $majorId = '' ;
    $institute = $study = $major = "";

    if (isset($_POST['submit'])) 
    {
        $institute = isset($_POST['institute']) ? sanitise_input($_POST['institute']) : '';
        $study = isset($_POST['study']) ? sanitise_input($_POST['study']) : '';
        $major = isset($_POST['major']) ? sanitise_input($_POST['major']) : '';

 
        if(empty($institute))
        {
            $errors["instituteErr"] = "<p>Please fill the required institute field</p>";
        }

        if(empty($study) )
        {
            $errors["studyErr"] = "<p>Please fill the required study type field</p>";
        }

        if(empty($major))
        {
            $errors["majorErr"] = "<p>Please fill the required major field</p>";
        }

        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            header("Location: question-2.php?institute=$institute&study=$study&&major=$major");
        }

    }
?>
 
<section>

    <h3 class="heading">Question Form</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Step -1</h4>
            </div>

            <a href="topic-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Topic</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>

            <?php 
                require './includes/step-1.php';
            ?>
          
            <button type="submit" name="submit" class="btn btn-green">Next</button>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>