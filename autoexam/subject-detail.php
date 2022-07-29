<?php 
    $title = "Subject Detail";
    require_once './templates/header.php';
    require_once './includes/session.php';
    // require_once './includes/admin-session.php';

    
    if(isset($_SESSION['user']))
    {
        if(isset($_GET['subject']))
        {
            $subjectQuery = mysqli_query($connection, 
                "SELECT * FROM `subject_details` 
                LEFT JOIN `teacher_profile` ON `teacher_profile`.`teacher_id` = `subject_details`.`subjectAddedBy`  
                LEFT JOIN `major` ON `major`.`major_id` = `subject_details`.`major_id`
                LEFT JOIN `type_of_study` ON `type_of_study`.`type_of_study_id` = `major`.`type_of_study_id`
                LEFT JOIN `institute` ON  `institute`.`institute_id` = `type_of_study`.`institute_id`
                WHERE `subject_details`.`subject_id` = '$_GET[subject]'
                ");
        }
    }
?>

<section>

    <h3 class="heading">Subject Detail</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Subject Detail</h4>
            </div>

            <a href="subject-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Subject</a>

        </div>

        <div class="table-responsive">
            <?php 
                require './includes/message.php';
            ?>
            <table class="table">
                <tbody>
                    <?php
                        if(mysqli_num_rows($subjectQuery) == 1)
                        {
                            $subject = mysqli_fetch_assoc($subjectQuery);
                                echo "
                                    <tr>
                                        <th class=\"text-left\" width=\"30% \">Subject Code</th>
                                        <td>$subject[subject_code]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Subject</th>
                                        <td>$subject[subject_name]</td>
                                     </tr>
                                    <tr>
                                        <th class=\"text-left\">Major</th>
                                        <td>$subject[major_name]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Study Type</th>
                                        <td>$subject[study_name]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Institute</th>
                                        <td>$subject[institute_name]</td>
                                    </tr>
                                    <tr>
                                        <th class=\"text-left\">Added By</th>
                                        <td>$subject[teacher_firstname] $subject[teacher_lastname]</td>
                                     </tr>
                                    <tr>
                                        <th class=\"text-left\">Added On</th>
                                        <td>".date("d M, Y", strtotime($subject['subjectAddedOn']))."</td>
                                    </tr>";
                                    if($_SESSION['userType'] == 'Admin')
                                    {
                                echo "<tr> 
                                        <td colspan=\"2\" class=\"text-center\">
                                            <a href=\"subject.php?edit=$subject[subject_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>
                                            <a href=\"delete.php?delete_subject=$subject[subject_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>
                                        </td>
                                    </tr>
                                ";
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

    </div>


</section>


<?php 
    require_once './templates/footer.php';
?>