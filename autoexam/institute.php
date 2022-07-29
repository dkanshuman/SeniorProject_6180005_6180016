<?php 
    $title = "Institute";

    require_once './templates/header.php';
    require_once './includes/session.php';
    require_once './includes/admin-session.php';

    
    $errList = [];
    $errors = ["instituteErr" => ""];
    $institute = '';

    if(isset($_GET['edit']))
    {
        $instituteQ = mysqli_query($connection, "SELECT `institute_name` FROM `institute` WHERE `institute_id` = '$_GET[edit]'" );
        if(mysqli_num_rows($instituteQ) == 1 )
        {
            $instituteRow = mysqli_fetch_assoc($instituteQ);
            $institute = $instituteRow['institute_name'];
        }
    }

    if (isset($_POST['submit'])) 
    {
        $institute = sanitise_input($_POST['institute']);

        if(empty($institute))
        {
            $errors["instituteErr"] = "<p>Please fill required field</p>";
        }
        elseif(!preg_match("/^[a-zA-Z ]{3,100}$/", $institute)) 
        {
            $errors["instituteErr"] = "<p>Institute field should only contain letters of maximum length 50 characters.</p>";
        }
        else
        {
            if(isset($_GET['edit']))
            {
                $existsQ = mysqli_query($connection, "SELECT `institute_name` FROM `institute` WHERE `institute_name` = '$institute' AND institute_id != '$_GET[edit]'" );
            }
            else
            {
                $existsQ = mysqli_query($connection, "SELECT `institute_name` FROM `institute` WHERE `institute_name` = '$institute'" );
            }
            if(mysqli_num_rows($existsQ) >=1 )
            {
                $errors["instituteErr"] = "<p>Institute already exists.</p>";
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
                $query = mysqli_query($connection, "UPDATE `institute` SET `institute_name` = '$institute' WHERE institute_id = '$_GET[edit]'");   
            }
            else
            {
                $query = mysqli_query($connection, "INSERT INTO `institute`(`institute_name`, `instituteAddedBy`) VALUES ('$institute', '$_SESSION[userId]')");   
            }
            if($query)
            {
                header('Location:institute-view.php?success=Action Done Successfully.');
            }
        }
    }

?>
 
<section>

    <h3 class="heading">Institute</h3>

    <div class="card">

        <div class="card-heading">

            <div>
                <h4 class="sub-heading">Add Institute</h4>
            </div>

            <a href="institute-view.php" class="btn btn-green"><i class="fa-solid fa-eye"></i> View Institute</a>

        </div>

        <form method="post" class="form-container g-large">
            
            <?php 
                require './includes/message.php';
            ?>

            <div>
                <label for="institute">Enter Institute<span class="text-red">*</span></label>
                <input type="text" name="institute" id="institute" class="form-control" placeholder="Enter institute" autofocus value="<?= $institute; ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-green">Submit</button>

        </form>

    </div>

</section>


<?php 
    require_once './templates/footer.php';
?>