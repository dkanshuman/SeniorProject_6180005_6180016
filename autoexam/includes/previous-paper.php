<?php 

// Get Previous 6 questions starts

    $prevQues = $exid =  '';
    $exIds =  $questionIds = $uniqueQuestionIds = [];

    $limit = 0;

    $examCountQ = mysqli_query($connection, "SELECT `examId` FROM `exam` WHERE examName != '' AND examAddedBy = '$_SESSION[userId]'");

    if(mysqli_num_rows($examCountQ) >= 1)
    {
       $count =  mysqli_num_rows($examCountQ);
       $limit = $count % 6;
    }


    $sql = "SELECT `examId` FROM `exam` WHERE examName != ''  AND examAddedBy = '$_SESSION[userId]' ORDER BY examId DESC LIMIT $limit";
   
    $exQ = mysqli_query($connection, $sql);

    if(mysqli_num_rows($exQ) >= 1)
    {
        while($exR = mysqli_fetch_assoc($exQ))
        {
            $exIds[] = $exR['examId'];
        } 

        $exid = implode(',', $exIds);


        $examQuestionsQ = mysqli_query($connection, "SELECT `questionId` FROM `exam_questions` WHERE examId IN ($exid)");

        if(mysqli_num_rows($examQuestionsQ) >= 1)
        {
            while($exR = mysqli_fetch_assoc($examQuestionsQ))
            {
                $questionIds[] = $exR['questionId'];
            }

            $uniqueQuestionIds = array_unique($questionIds);
        }

        $prevQues = implode(',', $uniqueQuestionIds); 

        // echo $prevQues;

    }

// Get Previous years questions ends

?>