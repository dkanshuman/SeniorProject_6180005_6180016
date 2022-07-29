<?php 
    $title = "Subject";
    require_once './templates/header.php';
    require_once './includes/session.php';
    // require_once './includes/admin-session.php';
     
    if(isset($_SESSION['user']))
    {
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

        $countSubjectsQ = mysqli_query($connection, "SELECT count(subject_id) as total FROM `subject_details` ");
        $countSubjectR = mysqli_fetch_assoc($countSubjectsQ);
        $noOfSubjects = $countSubjectR['total'];

        $subjectQuery = mysqli_query($connection, 
        "SELECT * FROM `subject_details` 
        LEFT JOIN `teacher_profile` ON `teacher_profile`.`teacher_id` = `subject_details`.`subjectAddedBy`  
        LEFT JOIN `major` ON `major`.`major_id` = `subject_details`.`major_id`
        ORDER BY `subject_details`.`subjectAddedOn` DESC
        LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfSubjects / $limit);

    }
?>

<section>

    <h3 class="heading">Subject</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Subject List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($subjectQuery); ?> out of <?= $noOfSubjects;?> Total Record(s).</p>
            </div>

            <?php
                if($_SESSION['userType'] == 'Admin')
                {
            ?>
                    <a href="subject.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Subject</a>
            <?php 
                }
            ?>
            
        </div>

        <div class="table-responsive">
            <?php 
                require './includes/message.php';
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Code</th>
                        <th>Major</th>
                        <th >Added By</th>
                        <th>Added On</th>
                        <th>Questions</th>
                        <?php
                            if($_SESSION['userType'] == 'Admin')
                            {
                        ?>
                            <th>Action</th>
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
                                        <td><a href=\"subject-detail.php?subject=$subject[subject_id]\">$subject[subject_code]</a></td>
                                        <td>$subject[major_name]</td>
                                        <td>$subject[teacher_firstname] $subject[teacher_lastname]</td>
                                        <td>".date("d M, Y", strtotime($subject['subjectAddedOn']))."</td>
                                        <td><a href=\"question-view.php?subject=$subject[subject_id]\" class=\"btn btn-info\"><i class=\"fa-solid fa-eye\"></i></a></td>
                                        <td>";
                                        if($_SESSION['userType'] == 'Admin')
                                        {
                                            echo " 
                                                <a href=\"subject.php?edit=$subject[subject_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>
                                                <a href=\"delete.php?delete_subject=$subject[subject_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>";
                                        }
                                    echo  "</td>
                                    </tr>
                                ";
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