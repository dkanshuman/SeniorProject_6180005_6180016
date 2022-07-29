<?php 
    $title = "Study Type";

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

        $countStudyTypeQ = mysqli_query($connection, "SELECT count(type_of_study_id) as total FROM type_of_study");
        $countStudyTypeR = mysqli_fetch_assoc($countStudyTypeQ);
        $noOfStudyType = $countStudyTypeR['total'];


        $studyTypeQuery = mysqli_query($connection, 
        "SELECT * FROM type_of_study 
        LEFT JOIN institute ON institute.institute_id = type_of_study.institute_id    
        LEFT JOIN teacher_profile ON teacher_profile.teacher_id = type_of_study.studyAddedBy    
        ORDER BY type_of_study.type_of_study_id DESC
        LIMIT $start, $limit
        "); 

        $totalPages = ceil($noOfStudyType / $limit);

    }
?>

<section>

    <h3 class="heading">Study Type</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Study Type List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($studyTypeQuery); ?> out of <?= $noOfStudyType;?> Total Record(s).</p>

            </div>

            <?php
                if($_SESSION['userType'] == 'Admin')
                {
            ?>
                    <a href="StudyType.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Study Type</a>
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
                        <th>Study</th>
                        <th>Institute</th>
                        <th>Added By</th>
                        <th>Added On</th>
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
                        if(mysqli_num_rows($studyTypeQuery) > 0)
                        {
                            while ($studyRow = mysqli_fetch_assoc($studyTypeQuery)) 
                            {
                                echo "
                                    <tr>
                                        <td>$serialNo</td>
                                        <td>$studyRow[study_name]</td>
                                        <td>$studyRow[institute_name]</td>
                                        <td>$studyRow[teacher_firstname] $studyRow[teacher_lastname]</td>
                                        <td>".date("d M, Y", strtotime($studyRow['studyAddedOn']))."</td>
                                        <td>
                                        ";
                                        if($_SESSION['userType'] == 'Admin')
                                        {
                                            echo "<a href=\"studyType.php?edit=$studyRow[type_of_study_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>
                                            <a href=\"delete.php?delete_study=$studyRow[type_of_study_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>";
                                        }
                                    echo "</td>
                                    </tr>
                                ";
                                $serialNo++;
                            }
                        }
                        else
                        {
                            echo "<tr><td colspan=\"6\">No record found.</td></tr>";
                        }
                    ?>
                   
                </tbody>
            </table>
        </div>

        <?php 
            if($noOfStudyType > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"studyType-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>

    </div>


</section>


<?php 
    require_once './templates/footer.php';
?>