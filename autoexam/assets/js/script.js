function instituteChanged(value)
{   
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("studyTypeResponse").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?fetchStudyData=" + value, true); 
    xmlhttp.send();    
}


function typeChanged(value)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("majorResponse").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?fetchMajorData=" + value, true); 
    xmlhttp.send();    
}


function showSubjects(value)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("subjectResponse").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?fetchSubjectsData=" + value, true); 
    xmlhttp.send();   
}


function getAnswerType(value)
{
    if(value == 'MCQ')
    {
        document.getElementById("answerHide").style.display = "none";
        document.getElementById("hide").style.display = "block";
    }
    else if(value == 'SAQ' || value == 'LAQ')
    {
        document.getElementById("hide").style.display = "none";
        document.getElementById("answerHide").style.display = "block";
    }
    else
    {
        document.getElementById("hide").style.display = "none";
    }
}

function showSTudyTypes(value) 
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("studyTypeResponse").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?institute_id=" + value, true); 
    xmlhttp.send();
}

function showMajor(value)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("majorResponse").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?fetchMajorData=" + value, true); 
    xmlhttp.send();   
}

function fetchTopics(value, topics)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("subjectTopicResponse").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?subject_id=" + value + "&topics=" + topics, true); 
    xmlhttp.send();  
}


function showQuestionDetails(value, type)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("question-details").innerHTML = this.responseText;
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?question_id=" + value +"&type=" +type, true); 
    xmlhttp.send(); 
}


function addQuestionToExam(questionId, questionScore)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("examScore").innerHTML = this.responseText;
            document.getElementById("plusbtn"+questionId).innerHTML = "&#x2713;";
            document.getElementById("plusbtn"+questionId).classList.add('btn-plus');
            document.getElementById("questionBlock"+questionId).classList.add("light-bg");
            document.getElementById("checked"+questionId).innerHTML = "<a class=\"btn btn-minus\" href='javascript:void(0)'><span>&#8722;</span></a>";
        }     
    };  
    xmlhttp.open("GET", "fetchData.php?add_question_id=" + questionId +"&score=" +questionScore, true); 
    xmlhttp.send(); 
}


function editExamQuestionScore(id)
{
    document.getElementById(`editableScore${id}`).setAttribute("contenteditable", true);

}

function updateExamScore(id, score)
{
    score = score.trim();
    score = Number(score);

    if(score == '' || ((typeof score) !== 'number'))
    {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
                document.getElementById(`editableScore${id}`).innerHTML = this.responseText;
            }    
        };  
        xmlhttp.open("GET", "updateData.php?getQuestionId=" + id +"&updateExamScore=" + score , true); 
        xmlhttp.send();
    }
    else
    {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
                document.getElementById("examScore").innerHTML = this.responseText;
                document.getElementById(`editableScore${id}`).innerHTML = score;
            }    
        };  
        xmlhttp.open("GET", "updateData.php?updateQuestionId=" + id +"&updateExamScore=" + score , true); 
        xmlhttp.send();
    }
}

function removeQuestionFromExam(questionId, score)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {      
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById("examScore").innerHTML = this.responseText;
            document.getElementById("questionBlock"+questionId).classList.toggle("light-bg");
            document.getElementById("checked"+questionId).innerHTML = " ";
            document.getElementById("plusbtn"+questionId).innerHTML = " <a href=\"javascript:void(0)\" onclick=\"addQuestionToExam("+questionId+", "+score+")\" >&#43; </a>";
        }    
    };  
    xmlhttp.open("GET", "fetchData.php?remove_question_id=" + questionId +"&score=" + score , true); 
    xmlhttp.send();
}

function makeEditable(id) {
    document.getElementById(`examName${id}`).setAttribute("contenteditable", true);
}

function updateExamName(id, name)
{
    if(name == '')
    {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
                document.getElementById(`examName${id}`).innerHTML = this.responseText;
                document.querySelector("title").innerText = `${this.responseText}`;
            }    
        };  
        xmlhttp.open("GET", "updateData.php?getExam_id=" + id +"&name=" + name , true); 
        xmlhttp.send();
    }
    else
    {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
                document.getElementById(`examName${id}`).innerHTML = this.responseText;
                document.querySelector("title").innerText = this.responseText;
            }    
        };  
        xmlhttp.open("GET", "updateData.php?exam_id=" + id +"&name=" + name , true); 
        xmlhttp.send();
    }
    
}