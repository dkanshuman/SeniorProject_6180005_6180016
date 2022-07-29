<?php 
    if( isset($_GET['exam_id']) && isset($_GET['examMode']) && isset($_GET['type']) )
    {
        $title = "Preview Question Paper";

        require './includes/config.php'; 
        require_once './includes/connection.php';

        $examQ = mysqli_query($connection, "SELECT `examName`, `examMode` FROM `exam` WHERE `examId` = '$_GET[exam_id]'");

        if(mysqli_num_rows($examQ) == 1)
        {
            $examR = mysqli_fetch_assoc($examQ);
            $title = $examR['examName'];
            $mode  = $examR['examMode'];
        }

        require_once './templates/header.php';
        require_once './includes/session.php';      
?>


<input type="hidden" id="examId" value="<?= $_GET['exam_id']; ?>">
<input type="hidden" id="examtype" value="<?= $_GET['type']; ?>">
<input type="hidden" id="examMode" value="<?= $_GET['examMode']; ?>">


<section>

    <h3 class="heading">Preview </h3>

    <div class="card">

        <div class="card-heading">
            <h4 class="sub-heading"><?= ucfirst($_GET['type']); ?></h4>
            <div>
                
                <?php 
                    if($_GET['type'] == 'question')
                    {
                ?>
                        <a href="setExam-4.php?examId=<?= $_GET['exam_id']; ?>&&mode=<?= $mode; ?>" class="btn btn-edit"><i class="fa fa-pen"></i></a>
                <?php
                    }
                ?>        
                <button class="btn btn-green" onclick="download('download-content')"><i class="fa-solid fa-download"></i></button>
            </div>
        </div>

        <div id="download-content">
            
            <div id="preview-content">

                <div class="text-center mt">
                    <img src="./assets/images/logo.png" alt="Auto Exam Generator" height="60px">
                </div>
                
                <h1 class="pdf-title">
                    Exam: 
                        <span id="examName<?= $_GET['exam_id']; ?>" contenteditable="true" onblur="updateExamName(<?= $_GET['exam_id']; ?>, this.innerText)"></span>
                </h1>

                <h2 class="pdf-subtitle" id="prev-subtitle"></h2> 
               
                <h2 class="pdf-subtitle" id="prev-subjectName"></h2> 

                <h2 class="pdf-subtitle" id="prev-teacherName"></h2> 

                <h2 class="pdf-subtitle">Semester : &nbsp;<span id="prev-semester" contenteditable="true" onblur="updateSemester(<?= $_GET['exam_id']; ?>, this.innerText)">-</span></h2> 
                
                <p class="pdf-totalmarks" id="prev-max-marks"></p>


                <div style="page-break-after:always;"> </div>

                <div class="pdf-questions" id="question-block">

                </div>

                <div class="page"></div> 

            </div>

        </div>

        <?php 
            if($_GET['type'] == 'question')
            {
        ?>
                <div class="text-center">
                    <button class="btn btn-green" onclick="submitExamQuestion()">Confirm Sorting</button>
                </div>
        <?php
            }
        ?>

    </div>

</section>

<?php       

    }
    else
    {
        echo "Oops! something went wrong. PLease try again later.";
    }
?>


<script src="./assets/js/preview.js"></script>


<?php 
    require_once './templates/footer.php';
?>

