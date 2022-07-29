<?php 

$title = "Generate Exam - 1";

require_once './templates/header.php';
require_once './includes/session.php';

$majorName = $studyId = $institute_id = $subject_name ='' ;

require_once './includes/teacher-subjects.php';
        

if($_SESSION['userType'] == 'Teacher')
{
    if(mysqli_num_rows($teacherSubjectsQ) < 1)
    {
        header("Location:dashboard.php?error=You can't add exam as you have not been assigned any subject.");

    }
}

$errList = [];
$errors = ["instituteErr" => "", "studyErr" => "", "majorErr" => ""];
$institute_id = $studyId = $majorId = '' ;
$institute = $study = $major = "";

 
if(isset($_POST['submit']))
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

        header("Location: setExam-2.php?institute=$institute&study=$study&&major=$major");
    }
}

?>

 
<section>

    <h3 class="heading">Set Exam</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">SET YOUR EXAM</h4>
            </div>

        </div>

        <form method="post" class="form-container g-xlarge">
            
            <?php 
                require './includes/message.php';
            ?>

            <?php 
                require './includes/step-1.php';
            ?>

            <div>
                <button type="submit" name="submit" class="btn btn-green">Next</button>
            </div>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>