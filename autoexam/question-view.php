<?php 
    $title = "Question Bank";

    require_once './templates/header.php';
    require_once './includes/session.php';
     
    $topicIds = '';
    $topicArr = [];

//  GET TEACHER TOPIC TO HIDE / SHOW EDIT/ DELETE Starts

$topicIds1 = '';
$topicArr1 = [];

$teacherSubjectsQ1 = mysqli_query($connection, "SELECT * FROM `teacher_subject_relation` WHERE `teacherId` = '$_SESSION[userId]'");
$teacherSubjectsArr1 = [];

if(mysqli_num_rows($teacherSubjectsQ1) >= 1)
{
    while($teacherSubjectsR1 = mysqli_fetch_assoc($teacherSubjectsQ1))
    {
        $teacherSubjectsArr1[] = $teacherSubjectsR1['subjectId'];
    }

    if(count($teacherSubjectsArr1) >= 1)
    {
        $teacherSubjects1 = implode(",", $teacherSubjectsArr1);

        $subjectTopicsQ1 = mysqli_query($connection, "SELECT * FROM subject_topic WHERE subject_id IN ($teacherSubjects1)");
        
        if(mysqli_num_rows($subjectTopicsQ1) >= 1)
        {

            while($subjectTopicsR1 = mysqli_fetch_assoc($subjectTopicsQ1))
            {
                $topicArr1[] = $subjectTopicsR1['subject_topic_id'];
            }

            $topicIds1 = implode(",", $topicArr1);
            
        }

    }
} 

//  GET TEACHER TOPIC TO HIDE / SHOW EDIT/ DELETE Ends


    if(isset($_POST['subjectsubmit']))
    {
        $subject = $_POST['subject'];
        header("Location:question-view.php?subject=$subject");
    }

    if(isset($_GET['subject']))
    {
        $subject = $_GET['subject'];
        $subjectTopicsQ = mysqli_query($connection, "SELECT * FROM `subject_topic` WHERE `subject_id` = '$_GET[subject]' ");
    
        if(mysqli_num_rows($subjectTopicsQ) >= 1)
        {
            while($subjectTopicsR = mysqli_fetch_assoc($subjectTopicsQ))
            {
                $topicArr[] = $subjectTopicsR['subject_topic_id'];
            }

            $topicIds = implode(",", $topicArr);
        }
    }
    else
    {
        require_once './includes/teacher-subjects.php'; 
    }


    $limit = 10;

    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    }
    else
    {
        $page  = 1;
    }


    $start = ($page * $limit) - $limit;

    $serialNo = $start + 1;
    

    if( ($_SESSION['userType'] == 'Teacher') || isset($_GET['subject']) )
    {
        if($topicIds != '')
        {
            $countQuestionsQ = mysqli_query($connection, "SELECT count(`question_id`) as total FROM `question_bank` WHERE `subject_topic_id` IN ($topicIds)");
            $countQuestionR = mysqli_fetch_assoc($countQuestionsQ);
            $noOfQuestions = $countQuestionR['total'];

            $questionsQuery = mysqli_query($connection, 
            "SELECT * FROM question_bank
            LEFT JOIN subject_topic ON subject_topic.subject_topic_id = question_bank.subject_topic_id
            WHERE question_bank.subject_topic_id IN ($topicIds)
            ORDER BY question_id DESC
            LIMIT $start, $limit
            ");
        }
        else
        {
            $noOfQuestions = 0;
        }
    }
    else
    {
        $countQuestionsQ = mysqli_query($connection, "SELECT count(`question_id`) as total FROM `question_bank`");
        $countQuestionR = mysqli_fetch_assoc($countQuestionsQ);
        $noOfQuestions = $countQuestionR['total'];
        
        $questionsQuery = mysqli_query($connection, 
        "SELECT * FROM question_bank
        LEFT JOIN subject_topic ON subject_topic.subject_topic_id = question_bank.subject_topic_id
        ORDER BY question_id DESC
        LIMIT $start, $limit
        ");
    }

    $totalPages = ceil($noOfQuestions / $limit);

?>

<section>

    <h3 class="heading">My Question Bank</h3>

    <form action="" method="post" class="d-flex mt">
        <select name="subject" id="" class="form-control">
            <option value="">--SELECT SUBJECT--</option>
            <?php 
                $allSubjects = mysqli_query($connection, "SELECT * FROM subject_details ORDER BY subject_name");
                while ($allSubject = mysqli_fetch_assoc($allSubjects)) 
                {
                    if($subject == $allSubject['subject_id'])
                    {
                        echo "<option value=\"$allSubject[subject_id]\" selected>$allSubject[subject_name] ($allSubject[subject_code])</option>";
                    }
                    else
                    {
                        echo "<option value=\"$allSubject[subject_id]\">$allSubject[subject_name] ($allSubject[subject_code])</option>";
                    }
                }
            ?>
        </select>
        <span>&nbsp;</span>
        <button type="submit" name="subjectsubmit" class="btn btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>


    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Question List</h4>
                <p class="desc">Showing <?php echo $noOfQuestions; ?> out of <?= $noOfQuestions;?> Total Record(s).</p>
            </div>

            <a href="question-1.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Question</a>

        </div> 

        <?php 
            require './includes/message.php';
        ?>

        <?php 
            if($noOfQuestions > 0)
            {
                echo "<div class=\"view-question-block\">";
                while ($questionsRow = mysqli_fetch_assoc($questionsQuery)) 
                {
                    echo "<div class=\"question-block\">
                                <div class=\"mt\">
                                    $serialNo.
                                    <span class=\"text-red\">$questionsRow[subject_topic_name]</span> -
                                    <span class=\"text-red\"> $questionsRow[score] Points  </span> -
                                    <span class=\"badge-red\">$questionsRow[question_abbr]</span>

                                </div>

                                <article>$questionsRow[question] </article>                             
                                
                            <div class=\"mt text-right\">
                                <a href=\"question-detail.php?question=$questionsRow[question_id]\" class=\"text-info\">
                                <i class=\"fa-solid fa-eye\"></i>
                                </a>  ";
                               
                                if( ($_SESSION['userType'] == 'Admin') || ( $_SESSION['userType'] == 'Teacher' &&  in_array($questionsRow['subject_topic_id'], $topicArr1))) 
                                {
                                    if($questionsRow['question_abbr'] == 'MCQ')
                                    {
                                        echo " <a href=\"question-3-edit-mcq.php?edit=$questionsRow[question_id]\" class=\"text-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>";
                                    }
                                    else
                                    {
                                        echo " <a href=\"question-3-edit.php?edit=$questionsRow[question_id]\" class=\"text-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>";   
                                    }
                                    echo  " <a href=\"delete.php?delete_question=$questionsRow[question_id]\"  class=\"text-red\"><i class=\"fa-solid fa-trash-can\"></i></a>";
                                }

                        echo "</div>
                        </div>
                    ";
                    $serialNo++;
                }
                echo "</div>";
            }
            else
            {
                echo "<div>No Record found</div>";
            }
        ?>


        <?php 
            if($noOfQuestions > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        if(isset($_GET['subject']))
                        {
                            echo "<li><a href=\"question-view.php?subject=$_GET[subject]&&page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                        }
                        else
                        {
                            echo "<li><a href=\"question-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                        }
                    }
                echo "</ul>";
            }
        ?>  
    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>