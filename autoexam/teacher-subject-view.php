<?php 
    $title = "Teacher Subject";
    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php'; 


    if(isset($_GET['delete_teacher']) && isset($_GET['delete_subject']))
    {
        $examQuery = mysqli_query($connection, "DELETE FROM teacher_subject_relation WHERE teacherId = '$_GET[delete_teacher]' AND subjectId = '$_GET[delete_subject]' ");
        if($examQuery)
        {
            header("Location:teacher-subject-view.php?teacher=$_GET[delete_teacher]&&success=Record deleted successfully.");
        }
    }
    
    
    
    if(isset($_GET['teacher']))
    {

        $teacherQ = mysqli_query($connection, "SELECT * FROM teacher_profile WHERE teacher_id = '$_GET[teacher]'");
        $teacherR = mysqli_fetch_assoc($teacherQ);

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

        $countTeacherQ = mysqli_query($connection, "SELECT count(subjectId) as total FROM `teacher_subject_relation` WHERE `teacherId` = '$_GET[teacher]'");
        $countTeacherR = mysqli_fetch_assoc($countTeacherQ);
        $noOfTeachers = $countTeacherR['total'];

        $teacherQuery = mysqli_query($connection, 
        "SELECT * FROM `teacher_subject_relation` 
        LEFT JOIN subject_details ON `teacher_subject_relation`.`subjectId` = `subject_details`.`subject_id`
        LEFT JOIN major ON `major`.`major_id` = `subject_details`.`major_id`
        WHERE `teacher_subject_relation`.`teacherId` = '$_GET[teacher]'
        ORDER BY `major`.`major_name`, `subject_details`.`subject_name`

        LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfTeachers / $limit);
    }
?>

<section>

    <h3 class="heading">Teacher Subject</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading"><?= ucfirst($teacherR['teacher_firstname'])  .' '. ucfirst($teacherR['teacher_lastname']); ?></h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($teacherQuery); ?> out of <?= $noOfTeachers;?> Total Record(s).</p>
            </div>

        </div>

        <div class="table-responsive">
            <?php 
                require './includes/message.php';
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Major</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($teacherQuery) > 0)
                        {
                            while ($teacherRow = mysqli_fetch_assoc($teacherQuery)) 
                            {
                                echo "
                                    <tr>
                                        <td>$serialNo</td>
                                        <td>$teacherRow[major_name]</td>
                                        <td>$teacherRow[subject_name]</td>
                                        <td><a href=\"teacher-subject-view.php?delete_teacher=$teacherRow[teacherId]&&delete_subject=$teacherRow[subject_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a></td>
                                    </tr>
                                ";
                                $serialNo++;
                            }
                        }
                        else
                        {
                            echo "<tr><td colspan=\"5\">No record found.</td></tr>";
                        }
                    ?>
                   
                </tbody>
            </table>
        </div>

        <?php 
            if($noOfTeachers > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"teacher-subject-view.php?teacher=$_GET[teacher]&&page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>

    </div>

</section>

<?php 
    require_once './templates/footer.php';
?>