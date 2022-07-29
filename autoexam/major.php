<?php 
    $title = "Major";
    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php';
    
    $errList = [];
    $errors = ["instituteErr" => "", "studyErr" => "", "majorErr" => ""];
    $majorName = $studyId = $institute_id = '' ;

    if(isset($_GET['edit']))
    {
        $majorEditQ = mysqli_query($connection, 
            "SELECT * FROM `major` 
            LEFT JOIN `type_of_study` ON `type_of_study`.`type_of_study_id` = `major`.`type_of_study_id`
            WHERE `major_id` = '$_GET[edit]'" 
        );  
        if(mysqli_num_rows($majorEditQ) == 1 )
        {
            $majorRow = mysqli_fetch_assoc($majorEditQ);
            $studyId = $majorRow['type_of_study_id'];
            $majorName = $majorRow['major_name'];
            $institute_id = $majorRow['institute_id'];            
        }
    }

    if (isset($_POST['submit'])) 
    {
        $institute_id = sanitise_input($_POST['institute']);
        $studyId = isset($_POST['studytype']) ? sanitise_input($_POST['studytype']) : '';
        $majorName = sanitise_input($_POST['major']);
 
   
        if(empty($institute_id))
        {
            $errors["instituteErr"] = "<p>Please fill the required Institute required field</p>";
        }

        if(empty($studyId))
        {
            $errors["studyErr"] = "<p>Please fill the required Study Type field</p>";
        }

        if(empty($majorName))
        {
            $errors["majorErr"] = "<p>Please fill the required Major field</p>";
        }
        elseif(!preg_match("/^[a-zA-Z0-9,.-_ ]{3,}$/", $majorName)) 
        {
            $errors["majorErr"] = "<p>Please enter a valid Major name.</p>";
        }

        else
        {
            if(isset($_GET['edit']))
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `major` WHERE `major_name` = '$majorName' AND type_of_study_id = '$studyId'  AND major_id != '$_GET[edit]'" );
            }
            else
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `major` WHERE `major_name` = '$majorName' AND type_of_study_id = '$studyId'" );
            }
            if(mysqli_num_rows($existsQ) >=1 )
            {
                $errors["studyErr"] = "<p>Type of Study already exists.</p>";
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
                $query = mysqli_query($connection, "UPDATE `major` SET `type_of_study_id` = '$studyId', `major_name` = '$majorName' WHERE major_id = '$_GET[edit]'");   
            }
            else
            {
                $query = mysqli_query($connection, "INSERT INTO `major` (`major_name`, `type_of_study_id`, `majorAddedBy`) VALUES ('$majorName', '$studyId', '$_SESSION[userId]')");   
            }
            if($query)
            {
                header('Location:major-view.php?success=Action Done Successfully.');
            }
        }
    }

?>
 
<section>

    <h3 class="heading">Major</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Add Major</h4>
            </div>

            <a href="major-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Major</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>
          
            <div>
                <label for="institute">Select Institute<span class="text-red">*</span></label>
                <select name="institute" id="major_institute" class="form-control" autofocus onchange="instituteChanged(this.value)">
                    <option value="">Select Institute</option>
                <?php 
                    $instituteQ = mysqli_query($connection, "SELECT * FROM `institute` ORDER BY `institute_name`" );
                    if(mysqli_num_rows($instituteQ) >= 1 )
                    {
                        while($instituteRow = mysqli_fetch_assoc($instituteQ))
                        {
                            if($institute_id == $instituteRow['institute_id'])
                            {
                                echo "<option value=\"$instituteRow[institute_id]\" selected>$instituteRow[institute_name]</option>";
                            }
                            else
                            {
                                echo "<option value=\"$instituteRow[institute_id]\">$instituteRow[institute_name]</option>";
                            }
                        }
                    }
                ?>
                </select>
            </div>

            <div id="studyTypeResponse">
                <?php 
                    if(isset($_GET['edit']))
                    {
                ?>
                        <label for="studytype">Select Study Type<span class="text-red">*</span></label>
                        <select name="studytype" id="studytype" class="form-control">
                            <option value="">Select Study Type</option>
                            <?php 
                                $studyQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE institute_id = '$institute_id' ORDER BY `study_name`" );
                                if(mysqli_num_rows($studyQ) >= 1 )
                                {
                                    while($studyRow = mysqli_fetch_assoc($studyQ))
                                    {
                                        if($studyId == $studyRow['type_of_study_id'])
                                        {
                                            echo "<option value=\"$studyRow[type_of_study_id]\" selected>$studyRow[study_name]</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=\"$studyRow[type_of_study_id]\">$studyRow[study_name]</option>";
                                        }
                                    }
                                }
                            ?>
                        </select>
                <?php        
                    }
                ?>

            </div>

            <div>
                <label for="major">Enter Major<span class="text-red">*</span></label>
                <input type="text" name="major" id="major" class="form-control" placeholder="Enter major" value="<?= $majorName; ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-green">Submit</button>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>