<?php 
    $title = "Major";
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

        $countMajorQ = mysqli_query($connection, "SELECT count(major_id) as total FROM major");
        $countMajorR = mysqli_fetch_assoc($countMajorQ);
        $noOfMajor = $countMajorR['total'];

        $majorQuery = mysqli_query($connection, 
        "SELECT * FROM major 
        LEFT JOIN teacher_profile ON teacher_profile.teacher_id = major.majorAddedBy  
        LEFT JOIN type_of_study ON major.type_of_study_id = type_of_study.type_of_study_id    
        LEFT JOIN institute ON type_of_study.institute_id = institute.institute_id
        ORDER BY type_of_study.study_name, major.major_name, institute.institute_name
        LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfMajor / $limit);

    }
?>

<section>

    <h3 class="heading">Major</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Major List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($majorQuery); ?> out of <?= $noOfMajor;?> Total Record(s).</p>
            </div>
            <?php
                if($_SESSION['userType'] == 'Admin')
                {
            ?>
                    <a href="major.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Major</a>
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
                        <th>Major</th>
                        <th>Study Type</th>
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
                        if(mysqli_num_rows($majorQuery) > 0)
                        {
                            while ($majorRow = mysqli_fetch_assoc($majorQuery)) 
                            {
                                echo "
                                    <tr>
                                        <td>$serialNo</td>
                                        <td>$majorRow[major_name]</td>
                                        <td>$majorRow[study_name]</td>
                                        <td>$majorRow[institute_name]</td>
                                        <td>$majorRow[teacher_firstname] $majorRow[teacher_lastname]</td>
                                        <td>".date("d M, Y", strtotime($majorRow['majorAddedOn']))."</td>
                                        <td>";
                                        if($_SESSION['userType'] == 'Admin')
                                        {
                                            echo  "<a href=\"major.php?edit=$majorRow[major_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>
                                            <a href=\"delete.php?delete_major=$majorRow[major_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>";
                                        }
                                    echo  "</td>
                                    </tr>
                                ";
                                $serialNo++;
                            }
                        }
                        else
                        {
                            echo "<tr><td colspan=\"7\">No Record Found</td></tr>";
                        }
                    ?>
                   
                </tbody>
            </table>
        </div>

        <?php 
            if($noOfMajor > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"major-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>               

    </div>


</section>


<?php 
    require_once './templates/footer.php';
?>