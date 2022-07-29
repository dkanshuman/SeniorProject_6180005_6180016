<?php

$topicIds = '';
$topicArr = [];

$teacherSubjectsQ = mysqli_query($connection, "SELECT * FROM `teacher_subject_relation` WHERE `teacherId` = '$_SESSION[userId]'");
$teacherSubjectsArr = [];

if(mysqli_num_rows($teacherSubjectsQ) >= 1)
{
    while($teacherSubjectsR = mysqli_fetch_assoc($teacherSubjectsQ))
    {
        $teacherSubjectsArr[] = $teacherSubjectsR['subjectId'];
    }

    if(count($teacherSubjectsArr) >= 1)
    {
        $teacherSubjects = implode(",", $teacherSubjectsArr);

        $subjectTopicsQ = mysqli_query($connection, "SELECT * FROM subject_topic WHERE subject_id IN ($teacherSubjects)");
        
        if(mysqli_num_rows($subjectTopicsQ) >= 1)
        {

            while($subjectTopicsR = mysqli_fetch_assoc($subjectTopicsQ))
            {
                $topicArr[] = $subjectTopicsR['subject_topic_id'];
            }

            $topicIds = implode(",", $topicArr);
            
        }

    }
}