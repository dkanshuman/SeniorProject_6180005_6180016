<?php 
    $title = "Signup"; 
    require './includes/config.php';
    session_start();
    if(isset($_SESSION['user']))
    {
        header("location:dashboard.php");
    }
    require_once './templates/main-header.php'; 

    require './includes/function.php';
    require './includes/connection.php';

    $errList = [];
    $errors = ["fnameErr" => "", "lnameErr" => "", "emailErr" => "", "passwordErr"=>"", "cpasswordErr"=>""];
    $fname = $lname = $email = '';

    if (isset($_POST['submit'])) 
    {
        $fname = sanitise_input($_POST['fname']);
        $lname = sanitise_input($_POST['lname']);
        $email = sanitise_input($_POST['email']);
        $password = sanitise_input($_POST['password']);
        $cpassword = sanitise_input($_POST['cpassword']);

        if(empty($fname))
        {
            $errors["fnameErr"] = "<p class='error'>Please fill required first name field</p>";
        }
        elseif(!preg_match("/^[a-zA-Z]{1,30}$/", $fname)) 
        {
            $errors["fnameErr"] = "<p class='error'>First name should only contain letters with maximum length 30</p>";
        }

        if(empty($lname))
        {
            $errors["lnameErr"] = "<p class='error'>Please fill required last name field</p>";
        }
        elseif(!preg_match("/^[a-zA-Z]{1,30}$/", $lname)) 
        {
            $errors["lnameErr"] = "<p class='error'>Last name should only contain letters with maximum length 30</p>";
        }

        if(empty($email))
        {
            $errors["emailErr"] = "<p class='error'>Please fill required email field</p>";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $errors["emailErr"] = "<p class='error'>Emailshould be valid</p>";
        }
        else
        {
            $userExistsQ = mysqli_query($connection, "SELECT `email` FROM `teacher_profile` WHERE `email` = '$email'" );
            if(mysqli_num_rows($userExistsQ) >=1 )
            {
                $errors["emailErr"] = "<p class='error'>Email already exists.</p>";
            }
        }

        if(empty($password))
        {
            $errors["passwordErr"] = "<p class='error'>Please fill required password field</p>";
        }
        elseif(strlen($password) < 8)
        {
            $errors["passwordErr"] = "<p class='error'>Password must be of length 8 characters.</p>";
        }

        if(empty($cpassword))
        {
            $errors["cpasswordErr"] = "<p class='error'>Please fill required password field</p>";
        }
        elseif($password !== $cpassword)
        {
            $errors["cpasswordErr"] = "<p class='error'>Password do not match.</p>";
        }

        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $query = mysqli_query($connection, "INSERT INTO `teacher_profile`(`teacher_firstname`, `teacher_lastname`, `password`, `email`, `type`) VALUES ('$fname', '$lname', '$pass', '$email', 'Teacher')");   
            if($query)
            {
                header("location: signup.php?success=You are registered successfully. Please <a href='login.php'>click here</a> to login");
            }
        }
    }


?>


    <article class="form-block">

        <form method="post" class="form-container g-small">
            <h1 class="heading">Teacher Signup</h1>

            <p class="subtitle">Hey, Enter your details to get sign up.</p>

            <?php 
                require './includes/message.php';
            ?>

            <div class="row">

                <div class="col">
                    <input type="text" id="fname" name="fname" class="form-control" placeholder="First name" value="<?= $fname; ?>">
                </div>

                <div class="col">
                    <input type="text" id="lname" name="lname" class="form-control" placeholder="Last name" value="<?= $lname; ?>">
                </div>

            </div>

            <div class="row">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= $email; ?>">
            </div>

            <div class="row">
                <div class="col">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="col">
                    <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Confirm Password">
                </div>
            </div>

            <div class="mt">
                <button type="submit" name="submit" class="btn btn-info">Register Now</button>
            </div>


            <div class="mt">
                <p>Already have an account? Please <a href="login.php"><em>Click here</em></a> to Login.
                </p>
            </div>

        </form>

    </article>

    
<?php 
    require_once './templates/main-footer.php';
?>