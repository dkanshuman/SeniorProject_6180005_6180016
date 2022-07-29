<?php 
    $title = "Question Type";
    require_once './templates/header.php';
    require_once './includes/session.php';
    
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

        $countQuestionTypeQ = mysqli_query($connection, "SELECT count(question_type_id) as total FROM question_type");
        $countQuestionTypeR = mysqli_fetch_assoc($countQuestionTypeQ);
        $noOfQuestionType = $countQuestionTypeR['total'];

        $questionTypeQuery = mysqli_query($connection, 
        "SELECT * FROM question_type 
        LEFT JOIN teacher_profile ON teacher_profile.teacher_id =  question_type.questionTypeAddedBy    
        ORDER BY question_type.question_type_value
        LIMIT $start, $limit
        ");

        $totalPages = ceil($noOfQuestionType / $limit);

    } 
?>

<section>

    <h3 class="heading">Question Type</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">All Question Type List</h4>
                <p class="desc">Showing <?php echo mysqli_num_rows($questionTypeQuery); ?> out of <?= $noOfQuestionType;?> Total Record(s).</p>

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
                        <th>Question Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($questionTypeQuery) > 0)
                        {
                            while ($questionTypeRow = mysqli_fetch_assoc($questionTypeQuery)) 
                            {
                                echo "
                                    <tr>
                                        <td>$serialNo</td>
                                        <td>$questionTypeRow[question_type_value]</td>
                                    </tr>
                                ";
                                $serialNo++;
                            }
                        }
                    ?>
                   
                </tbody>
            </table>
        </div>

        <?php 
            if($noOfQuestionType > $limit)
            {
                echo "<ul class=\"pagination\">";
                    for ($i=1; $i <= $totalPages; $i++) 
                    { 
                        echo "<li><a href=\"questionType-view.php?page=$i\" class=\"btn-pagination\">".$i."</a></li>";
                    }
                echo "</ul>";
            }
        ?>

    </div>


</section>


<?php 
    require_once './templates/footer.php';
?>