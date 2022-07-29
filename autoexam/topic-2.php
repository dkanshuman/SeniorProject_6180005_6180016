<?php 
    $title = "Topic";
    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php';
    
    $errList = [];
    $errors = ["topicErr" => "", "subjectErr" => ""];
    $subject_topic_name = $subject_id = '' ;

    if( isset($_GET['institute']) && isset($_GET['study']) && $_GET['major'] )
    {
        $subjectDetailQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE `major_id` = '$_GET[major]' ORDER BY `subject_name`");

        if(isset($_GET['subject']))
        {
            $subject_id = $_GET['subject'];
        }
    }


    if(isset($_GET['edit']))
    {
        $topicEditQ = mysqli_query($connection, 
            "SELECT * FROM `subject_topic` 
            LEFT JOIN `subject_details` ON `subject_details`.`subject_id` = `subject_topic`.`subject_id`
            WHERE `subject_topic`.`subject_topic_id` = '$_GET[edit]'" 
        );  
        
        if(mysqli_num_rows($topicEditQ) == 1 )
        {
            $topicRow = mysqli_fetch_assoc($topicEditQ);
            $subject_topic_name = $topicRow['subject_topic_name'];
            $subject_id = $topicRow['subject_id'];

            $subjectQ = mysqli_query($connection, "SELECT * FROM subject_details WHERE subject_id = '$subject_id'");
            if(mysqli_num_rows($subjectQ) >= 1)
            {
                $subjectR = mysqli_fetch_assoc($subjectQ);
                $major = $subjectR['major_id'];
                $subjectDetailQ = mysqli_query($connection, "SELECT * FROM `subject_details` WHERE `major_id` = '$major' ORDER BY `subject_name`");
            }

        }
    }

    if (isset($_POST['submit'])) 
    {
       
        $subject_id = sanitise_input($_POST['subject']);

        $subject_topic_name = sanitise_input($_POST['topic']);

        if(empty($subject_id))
        {
            $errors["subjectErr"] = "<p>Please fill the required subject field</p>";
        }

        if(empty($subject_topic_name))
        {
            $errors["topicErr"] = "<p>Please fill the required topic field</p>";
        }
        else
        {
            if(isset($_GET['edit']))
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `subject_topic` WHERE `subject_topic_name` = '$subject_topic_name' AND subject_id = '$subject_id' AND subject_topic_id != '$_GET[edit]'" );
            }
            else
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `subject_topic` WHERE `subject_topic_name` = '$subject_topic_name' AND subject_id = '$subject_id'" );
            }
            if(mysqli_num_rows($existsQ) >=1 )
            {
                $errors["topicErr"] = "<p>Topic already exists.</p>";
            }
        }

        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            if(isset($_GET['edit']))
            {
                $query = mysqli_query($connection, "UPDATE `subject_topic` SET `subject_topic_name` = '$subject_topic_name', `subject_id` = '$subject_id' WHERE subject_topic_id = '$_GET[edit]'"); 
                if($query)
                {
                    header("Location:topic-view.php?success=Action Done Successfully.");
                }  
            }
            else
            {
                $query = mysqli_query($connection, "INSERT INTO `subject_topic` (`subject_topic_name`, `subject_id`, `topicAddedBy`) VALUES ('$subject_topic_name', '$subject_id', '$_SESSION[userId]')");  
                if($query)
                {
                    $topicId = $connection->insert_id;
                    header("Location:topic-2.php?institute=$_GET[institute]&study=$_GET[study]&major=$_GET[major]&subject=$subject_id&success=Action Done Successfully. You can add more topics or <a href='topic-detail.php?topic=$topicId'>view here</a>.");
                }
            }
            
        }
    }

?>
 
<section>

    <h3 class="heading">Topic</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Enter Topic</h4>
            </div>

            <a href="topic-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Topic</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>

            <fieldset class="form-box">
                
                <legend><span class="index">4</span> Select Subject</legend>
                    <?php 
                        if(mysqli_num_rows($subjectDetailQ) >= 1 )
                        {
                            echo "<select name=\"subject\" id=\"subject\" class=\"form-control\">
                                    <option value=\"\">Select Subject</option>";
                            while($subjectRow = mysqli_fetch_assoc($subjectDetailQ))
                            {
                                if($subject_id == $subjectRow['subject_id'])
                                {
                                    echo "<option value=\"$subjectRow[subject_id]\" selected>$subjectRow[subject_name] ($subjectRow[subject_code])</option>";
                                }
                                else
                                {
                                    echo "<option value=\"$subjectRow[subject_id]\">$subjectRow[subject_name] ($subjectRow[subject_code])</option>";
                                }
                            }
                            echo "</select>";
                        }
                        else
                        {
                            echo "No Subject exists";
                        }
                    ?>

            </fieldset>

            <fieldset class="form-box">
                <legend><span class="index">5</span> Enter topic</legend>
                <input type="text" name="topic" id="topic" class="form-control" placeholder="Enter Topic" value="<?= $subject_topic_name; ?>">
            </fieldset>

            <div>
                <button type="submit" name="submit" class="btn btn-green">Submit</button>
            </div>

        </form>

    </div>

</section>


<?php

    require_once './templates/footer.php';
?>