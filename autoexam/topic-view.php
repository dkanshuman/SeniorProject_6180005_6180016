<?php 
    $title = "Topic";

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

        $countSubjectTopicQ = mysqli_query($connection, "SELECT count(`subject_topic_id`) as total FROM `subject_topic`");
        $countSubjectTopicR = mysqli_fetch_assoc($countSubjectTopicQ);
        $noOfSubjectTopic = $countSubjectTopicR['total'];


        $topicQuery = mysqli_query($connection, 
            "SELECT * FROM `subject_topic` 
            LEFT JOIN `teacher_profile` ON `teacher_profile`.`teacher_id` = `subject_topic`.`topicAddedBy`  
            LEFT JOIN `subject_details` ON `subject_details`.`subject_id` = `subject_topic`.`subject_id`
            ORDER BY `subject_topic`.`topicAddedOn` DESC
            LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfSubjectTopic / $limit);

    }
?>

<section>

    <h3 class="heading">Topic</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Topic List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($topicQuery); ?> out of <?= $noOfSubjectTopic;?> Total Record(s).</p>
            </div>

            <?php
                if($_SESSION['userType'] == 'Admin')
                {
            ?>
                <a href="topic-1.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Topic</a>
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
                        <th>Topic</th>
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
                        if(mysqli_num_rows($topicQuery) > 0)
                        {
                            while ($topic = mysqli_fetch_assoc($topicQuery)) 
                            {
                                echo "
                                    <tr>
                                        <td>$serialNo</td>
                                        <td>$topic[subject_code]</td>
                                        <td><a href=\"topic-detail.php?topic=$topic[subject_topic_id]\">$topic[subject_topic_name]</a></td>
                                        <td>$topic[teacher_firstname] $topic[teacher_lastname]</td>
                                        <td>".date("d M, Y", strtotime($topic['topicAddedOn']))."</td>
                                        <td>";
                                    
                                    if($topic['topicAddedBy'] == $_SESSION['userId']){
                                        echo  "<a href=\"topic-2.php?edit=$topic[subject_topic_id]\" class=\"btn btn-edit\"><i class=\"fa-solid fa-pen-to-square\"></i></a>
                                            <a href=\"delete.php?delete_topic=$topic[subject_topic_id]\"  class=\"btn btn-delete\"><i class=\"fa-solid fa-trash-can\"></i></a>";
                                    }

                                echo    "</td>
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
            if($noOfSubjectTopic > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"topic-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?> 

    </div>


</section>


<?php 
    require_once './templates/footer.php';
?>