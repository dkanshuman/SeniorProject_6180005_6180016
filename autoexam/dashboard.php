<?php 
    $title = "Dashboard";
    require_once './templates/header.php';
    require_once './includes/session.php';
    
    if(isset($_SESSION['user']))
    {

        $userQuery = mysqli_query($connection, "SELECT * FROM teacher_profile WHERE email = '$_SESSION[user]'");
        $userRow = mysqli_fetch_assoc($userQuery);
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

    $countExamQ = mysqli_query($connection, "SELECT count(`examId`) as total FROM exam  WHERE exam.examAddedBy = '$_SESSION[userId]'");
    $countExamR = mysqli_fetch_assoc($countExamQ);
    $noOfExams = $countExamR['total'];

    $examList = mysqli_query($connection, 
        "SELECT * FROM exam 
        LEFT JOIN teacher_profile ON teacher_profile.teacher_id = exam.examAddedBy
        WHERE exam.examAddedBy = '$_SESSION[userId]'
        ORDER BY exam.examId DESC
        LIMIT $start, $limit
        ");

    $totalPages = ceil($noOfExams / $limit);

?>

        
<section>

    <?php 
        if(isset($_GET['examId']))
        {
            $exmQ = mysqli_query($connection, "SELECT * FROM exam WHERE examId = '$_GET[examId]'");
            if(mysqli_num_rows($exmQ) == 1)
            {
                $exmR = mysqli_fetch_assoc($exmQ);

                echo "

                    <div class=\"card text-center \" style=\"margin-bottom: 20px;\">
    
                        <h4>
                            <span id=\"examName$exmR[examId]\" ondblclick=\"makeEditable($exmR[examId])\" onblur=\"updateExamName($exmR[examId], this.innerText)\">$exmR[examName]</span>
                        </h4>   

                        <h4 class=\"sub-heading\"> 
                            <a class=\"text-dark\" title=\"Download Question Paper\" href=\"preview.php?exam_id=$exmR[examId]&&type=question&&examMode=$exmR[examMode]\">
                               Question Paper
                                <i class=\"fa-solid fa-download\"></i>
                            </a>
                        </h4>
                        <h4 class=\"sub-heading\">
                            <a class=\"text-dark\" title=\"Download Answers\" href=\"javascript:void(0)\" onclick=\"downloadExamPdf($exmR[examId], 'answer')\">
                                Answer Sheet
                                <i class=\"fa-solid fa-download\"></i>
                            </a>
                        </h4>   
                </div>";
            }
        }

    ?>

<h3 class="heading">Dashboard</h3>

    <?php 
        require './includes/message.php';
    ?>
 
    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Question Paper List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($examList); ?> out of <?= $noOfExams;?> Total Record(s).</p>
            </div>

            <a href="setExam-1.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Generate Exam</a>

        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question Paper</th>
                        <th>Mode</th>
                        <th>Added On</th>
                        <th>Added By</th>
                        <th class="text-center">Answers</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if(mysqli_num_rows($examList) >= 1) 
                    {
                        while ($exam = mysqli_fetch_assoc($examList)) 
                        {
                            $countExamTypesQ = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `exam_type` WHERE examId = '$exam[examId]'"));

                            $answerLink = '';

                            $delLink = "";

                            if($countExamTypesQ == 0)
                            {
                                $link = "<a class=\"text-dark\" title=\"Edit Exam Type\"  
                                            href=\"setExam-3.php?examId=$exam[examId]\">
                                                <i class=\"fa-solid fa-edit\"></i>
                                        </a>";
                                
                                $delLink = "<a class=\"text-red\" title=\"Edit Exam Type\"  
                                             href=\"delete.php?delete_exam=$exam[examId]\">
                                                <i class=\"fa-solid fa-trash\"></i>
                                    </a>";
                            }
                            else
                            {
                                $countQuesQ = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `exam_questions` WHERE examId = '$exam[examId]'"));

                                if($countQuesQ == 0)
                                {
                                    if($exam['examMode'] == 'Random')
                                    {
                                        $link = "<a class=\"text-dark\" title=\"Edit Exam Questions\"  
                                            href=\"setExam-4-Random.php?examId=$exam[examId]\">
                                                <i class=\"fa-solid fa-edit\"></i>
                                        </a>";
                                        $delLink = "<a class=\"text-red\" title=\"Edit Exam Type\"  
                                                href=\"delete.php?delete_exam=$exam[examId]\">
                                                <i class=\"fa-solid fa-trash\"></i>
                                    </a>";
                                    }
                                    elseif($exam['examMode'] == 'Manual')
                                    {
                                        $link = "<a class=\"text-dark\" title=\"Edit Exam Questions\"  
                                            href=\"setExam-4.php?examId=$exam[examId]\">
                                                <i class=\"fa-solid fa-edit\"></i>
                                        </a>";

                                        $delLink = "<a class=\"text-red\" title=\"Edit Exam Type\"  
                                                    href=\"delete.php?delete_exam=$exam[examId]\">
                                                    <i class=\"fa-solid fa-trash\"></i>
                                        </a>";
                                    }
                                   
                                }
                                else
                                {
                                    $link = "<a class=\"text-dark\" title=\"Download Question Paper\"  
                                            href=\"preview.php?exam_id=$exam[examId]&&type=question&&examMode=$exam[examMode]\">
                                                <i class=\"fa-solid fa-download\"></i>
                                        </a>";
                                    $answerLink = "<a class=\"text-dark\" title=\"Download Answers\" 
                                                    href=\"preview.php?exam_id=$exam[examId]&&type=answer&&examMode=$exam[examMode]\">
                                                        <i class=\"fa-solid fa-download\"></i>
                                                </a>";
                                }                                
                            }

                            echo " <tr>
                                    <td>$serialNo</td> 
                                    <td>
                                        <span id=\"examName$exam[examId]\" contenteditable=\"true\" onblur=\"updateExamName($exam[examId], this.innerText)\">$exam[examName]</span>
                                        $link
                                        $delLink
                                    </td>
                                    <td>$exam[examMode]</td>
                                    <td>".date("d M, Y - h:i A", strtotime($exam['examAddedOn']))."</td>
                                    <td>$exam[teacher_firstname] $exam[teacher_lastname]</td>
                                    <td class=\"text-center\"> 
                                        $answerLink
                                    </td> 
                                    <td>
                                        <a href=\"setExam-4.php?examId=$exam[examId]&&mode=$exam[examMode]\" class=\"text-edit\"><i class=\"fa fa-pen\"></i></a>
                                        <a class=\"text-red\" title=\"Edit Exam Type\"  
                                                    href=\"delete.php?delete_exam=$exam[examId]\">
                                                    <i class=\"fa-solid fa-trash\"></i>
                                        </a>
                                    </td>
                                </tr>";
                            $serialNo++;
                        }
                    }
                    else
                    {
                        echo "<tr><td colspan=\"5\">No Record found</td></tr>";
                    }
                    
                ?>
                </tbody>
            </table>
        </div>
        <?php 
            if($noOfExams > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"dashboard.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>
    </div>

    

    <!-- SUBJECT LIST -->

     
<?php
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

    $countSubjectsQ = mysqli_query($connection, "SELECT count(subjectId) as total FROM `teacher_subject_relation` WHERE teacherId = '$_SESSION[userId]'  ");
    $countSubjectR = mysqli_fetch_assoc($countSubjectsQ);
    $noOfSubjects = $countSubjectR['total'];

    $subjectQuery = mysqli_query($connection, 
    "SELECT * FROM `teacher_subject_relation` 
    LEFT JOIN `subject_details` ON `subject_details`.`subject_id`  =  `teacher_subject_relation`.`subjectId`
    LEFT JOIN `major` ON `major`.`major_id` = `subject_details`.`major_id`
    LEFT JOIN `type_of_study` ON `type_of_study`.`type_of_study_id` = `major`.`type_of_study_id`
    LEFT JOIN `institute` ON `institute`.`institute_id` = `type_of_study`.`institute_id`
    WHERE `teacher_subject_relation`.`teacherId` = '$_SESSION[userId]'
    ORDER BY `subject_details`.`subject_name` DESC
    LIMIT $start, $limit
    ");

    $totalPages = ceil($noOfSubjects / $limit);

?>


<h3 class="heading" style="margin-top: 50px;">My Subjects</h3>

<div class="card">

    <div class="card-heading">

        <div>
            <h4 class="sub-heading">My Subject List</h4>
            <p class="desc">Showing <?php echo mysqli_num_rows($subjectQuery); ?> out of <?= $noOfSubjects;?> Total Record(s).</p>
        </div>

        <?php 
            if($_SESSION['userType'] == 'Admin')
            {
        ?>
            <a href="add-subject-1.php?teacher=<?= $_SESSION['userId'];?>" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add My Subject</a>
        <?php
            }
        ?>

    </div>

    <div class="table-responsive">
       
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th width="15%">Add Question</th>
                    <th width="15%">Set Exam</th>
                    <?php 
            if($_SESSION['userType'] == 'Admin')
            {
        ?>
                    <th width="15%">Action</th>
                    <?php
            }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(mysqli_num_rows($subjectQuery) > 0)
                    {
                        while ($subject = mysqli_fetch_assoc($subjectQuery)) 
                        {
                            echo "
                                <tr>
                                    <td>$serialNo</td>
                                    <td><a href=\"subject-detail.php?subject=$subject[subject_id]\">$subject[subject_name] ($subject[subject_code])</a></td>
                                    <td>
                                        <a href=\"question-2.php?institute=$subject[institute_id]&&study=$subject[type_of_study_id]&&major=$subject[major_id]&&subject=$subject[subject_id]\"  class=\"btn btn-info\"><i class=\"fa-solid fa-plus\"></i></a>
                                    </td>
                                    <td>
                                        <a href=\"setExam-2.php?institute=$subject[institute_id]&&study=$subject[type_of_study_id]&&major=$subject[major_id]&&subject=$subject[subject_id]\"  class=\"btn btn-info\"><i class=\"fa-solid fa-plus\"></i></a>
                                    </td>";

                                    if($_SESSION['userType'] == 'Admin')
                                    {
                                        echo "<td>
                                                <a href=\"delete.php?delete_teacher_subject=$subject[subject_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>
                                        </td>";
                                    }
                    echo   "</tr>";
                            $serialNo++;
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

    <?php 
        if($noOfSubjects > $limit)
        {
            echo "<ul class=\"pagination\">";
                for ($i=1; $i <= $totalPages; $i++) 
                { 
                    echo "<li><a href=\"subject-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                }
            echo "</ul>";
        }
    ?>

</div>

</section>


<?php 
    require_once './templates/footer.php';
?>