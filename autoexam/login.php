<?php 
    $title = "Login";

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
    $errors = ["userErr" => "", "passwordErr" => ""];

    if (isset($_POST['submit'])) 
    {
        $user = sanitise_input($_POST['user']);
        $password = sanitise_input($_POST['password']);

        if(empty($user))
        {
            $errors["userErr"] = "<p class='error'>Please fill required user name field</p>";
        }
        else if(empty($password))
        {
            $errors["passwordErr"] = "<p class='error'>Please fill required password field</p>";
        }
        else
        {
            $userExistsQ = mysqli_query($connection, "SELECT *  FROM `teacher_profile` WHERE `email` = '$user'" );
            if(mysqli_num_rows($userExistsQ) == 0 )
            {
                $errors["userErr"] = "<p class='error'>User does not exist.</p>";
            }
            else
            {
                $userRow = mysqli_fetch_assoc($userExistsQ);
                if(!password_verify($password, $userRow['password']))
                {
                    $errors["passwordErr"] = "<p class='error'>Password does not match.</p>";
                }
            }
        }

       
        if(array_filter($errors))
        {
            $errList = $errors;
        }
        else
        {
            $_SESSION['user'] = $user;
            $_SESSION['userType'] = $userRow['type'];
            $_SESSION['userId'] = $userRow['teacher_id'];
            header("Location: dashboard.php");
        }

    }


?>

    <article class="form-block ">

        <form action="" method="post" class="form-container small-form g-large">
            <h1 class="heading">Teacher Login</h1>

            <?php 
                require './includes/message.php';
            ?>

            <div class="row">
                <input type="text" name="user" class="form-control" placeholder="Enter Email / Username" autofocus>
            </div>

            <div class="row">
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
            </div>

            <div class="mt">
                <button type="submit" name="submit" class="btn btn-info">Sign in</button>
            </div>
            
            <div class="mt">
                <p>Don't have an account? <a href="signup.php"><em>Click here</em></a> for new registration.</p>
            </div>

        </form>

    </article>
    
<?php 
    require_once './templates/main-footer.php';
?>