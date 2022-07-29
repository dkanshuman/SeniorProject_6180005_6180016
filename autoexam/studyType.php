<?php 
    $title = "Study Type";
    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php';
    
    $errList = [];
    $errors = ["instituteErr" => "", "studyErr" => ""];
    $studyName = $instituteId = '';

    if(isset($_GET['edit']))
    {
        $studyTypeQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE `type_of_study_id` = '$_GET[edit]'" );
        if(mysqli_num_rows($studyTypeQ) == 1 )
        {
            $studyRow = mysqli_fetch_assoc($studyTypeQ);
            $instituteId = $studyRow['institute_id'];
            $studyName = $studyRow['study_name'];
        }
    }

    if (isset($_POST['submit'])) 
    {
        $instituteId = sanitise_input($_POST['institute']);
        $studyName = sanitise_input($_POST['study']);

        if(empty($instituteId))
        {
            $errors["instituteErr"] = "<p>Please fill required Institute field</p>";
        }

        if(empty($studyName))
        {
            $errors["studyErr"] = "<p>Please fill required Study type field</p>";
        }
        elseif(!preg_match("/^[a-zA-Z0-9- ]{3,300}$/", $studyName)) 
        {
            $errors["studyErr"] = "<p>Please enter a valid Study name.</p>";
        }

        else
        {
            if(isset($_GET['edit']))
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE `study_name` = '$studyName' AND institute_id = '$instituteId'  AND type_of_study_id != '$_GET[edit]'" );
            }
            else
            {
                $existsQ = mysqli_query($connection, "SELECT * FROM `type_of_study` WHERE `study_name` = '$studyName' AND institute_id = '$instituteId'" );
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
                $query = mysqli_query($connection, "UPDATE `type_of_study` SET `institute_id` = '$instituteId', `study_name` = '$studyName' WHERE type_of_study_id = '$_GET[edit]'");   
            }
            else
            {
                $query = mysqli_query($connection, "INSERT INTO `type_of_study` (`study_name`, `institute_id`, `studyAddedBy`) VALUES ('$studyName', '$instituteId', '$_SESSION[userId]')");   
            }
            if($query)
            {
                header('Location:studyType-view.php?success=Action Done Successfully.');
            }
        }
    }

?>
 
<section>

    <h3 class="heading">Institute</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Add Study Type</h4>
            </div>

            <a href="studyType-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Study Type</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>
          
            <div>
                <label for="institute">Select Institute<span class="text-red">*</span></label>
                <select name="institute" id="institute" class="form-control" autofocus>
                    <option value="">Select Institute</option>
                <?php 
                    $instituteQ = mysqli_query($connection, "SELECT * FROM `institute`" );
                    if(mysqli_num_rows($instituteQ) >= 1 )
                    {
                        while($instituteRow = mysqli_fetch_assoc($instituteQ))
                        {
                            if($instituteId == $instituteRow['institute_id'])
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

            <div>
                <label for="study">Enter Study Type<span class="text-red">*</span></label>
                <input type="text" name="study" id="study" class="form-control" placeholder="Enter study" autofocus value="<?= $studyName; ?>">
            </div>


            <button type="submit" name="submit" class="btn btn-green">Submit</button>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>