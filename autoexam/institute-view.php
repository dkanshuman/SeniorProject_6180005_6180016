<?php 
    $title = "Institute";
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

        $countInstituteQ = mysqli_query($connection, "SELECT count(institute_id) as total FROM institute");
        $countInstituteR = mysqli_fetch_assoc($countInstituteQ);
        $noOfInstitutes = $countInstituteR['total'];

        $instituteQuery = mysqli_query($connection, 
        "SELECT * FROM institute 
        LEFT JOIN teacher_profile ON teacher_profile.teacher_id =  institute.instituteAddedBy    
        ORDER BY institute.institute_id DESC
        LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfInstitutes / $limit);
    }
?>

<section>

    <h3 class="heading">Institute</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Institute List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($instituteQuery); ?> out of <?= $noOfInstitutes;?> Total Record(s).</p>
            </div>

            <?php
                if($_SESSION['userType'] == 'Admin')
                {
            ?>
                    <a href="institute.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Institute</a>
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
                        if(mysqli_num_rows($instituteQuery) > 0)
                        {
                            while ($instituteRow = mysqli_fetch_assoc($instituteQuery)) 
                            {
                                echo "
                                    <tr>
                                        <td>$serialNo</td>
                                        <td>$instituteRow[institute_name]</td>
                                        <td>$instituteRow[teacher_firstname] $instituteRow[teacher_lastname]</td>
                                        <td>".date("d M, Y", strtotime($instituteRow['instituteAddedOn']))."</td>
                                        <td>";
                                    if($_SESSION['userType'] == 'Admin')
                                    {
                                        echo "<a href=\"institute.php?edit=$instituteRow[institute_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>
                                            <a href=\"delete.php?delete_institute=$instituteRow[institute_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>";
                                    }
                                echo "</td>
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
            if($noOfInstitutes > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"institute-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>

    </div>

</section>

<?php 
    require_once './templates/footer.php';
?>