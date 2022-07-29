<?php 
    $title = "Teacher";
    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php'; 
    
    if(isset($_GET['makeAdmin']))
    {
        $query = mysqli_query($connection, "UPDATE  teacher_profile SET type= 'Admin' WHERE teacher_id = '$_GET[makeAdmin]'");
        if($query)
        {
            header("Location:teacher-view.php?success=Admin created");
        }
    }

    
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

        $countTeacherQ = mysqli_query($connection, "SELECT count(teacher_id) as total FROM teacher_profile");
        $countTeacherR = mysqli_fetch_assoc($countTeacherQ);
        $noOfTeachers = $countTeacherR['total'];

        $teacherQuery = mysqli_query($connection, 
        "SELECT * FROM teacher_profile 
        ORDER BY teacher_profile.type, teacher_profile.teacher_id DESC
        LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfTeachers / $limit);
    }
?>

<section>

    <h3 class="heading">Teacher</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Teacher List</h4>
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
                        <th>Teacher</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Added On</th>
                        <th class="text-center">Action</th>
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
                                        <td><a href='teacher-subject-view.php?teacher=$teacherRow[teacher_id]' class=\"text-dark text-underline\">$teacherRow[teacher_firstname] $teacherRow[teacher_lastname]</a></td>
                                        <td>$teacherRow[email]</td>
                                        <td>$teacherRow[type]</td>
                                        <td>".date("d M, Y", strtotime($teacherRow['addedOn']))."</td>
                                        <td>";
                                        if($teacherRow['type'] == 'Teacher'){
                                            echo "<a href=\"teacher-view.php?makeAdmin=$teacherRow[teacher_id]\" class=\"btn btn-info\">
                                                    Make Admin
                                                </a>&nbsp;
                                                <a href=\"add-subject-1.php?teacher=$teacherRow[teacher_id]\" class=\"btn btn-green\">
                                                    Add Subjects
                                                </a>
                                                ";
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
            if($noOfTeachers > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"teacher-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>

    </div>

</section>

<?php 
    require_once './templates/footer.php';
?>