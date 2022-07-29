    window.onload = previewContent;

  
    function previewContent()
    {
        let  examid = document.getElementById("examId").value;
        let  examtype = document.getElementById("examtype").value;
        let  exammode = document.getElementById("examMode").value;
        
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
                var dragStartIndex = '';

                let response = JSON.parse(this.responseText);
                let examResponse = response.AllQuestionsArray[0];
                
                document.getElementById("examName"+examid).innerHTML = `${examResponse.examName}`;

                document.getElementById("prev-subtitle").innerHTML = `Subject : ${examResponse.subjectName}  (${examResponse.subjectCode})`;
                // document.getElementById("prev-subjectName").innerHTML = "Subject : " + examResponse.subjectName;
                document.getElementById("prev-teacherName").innerHTML = "Teacher : " + examResponse.teacherName;
                document.getElementById("prev-semester").innerHTML = examResponse.semester;

                let questionBlock = document.getElementById("question-block");

                let questionArr = examResponse.questions;

                let sr = 0;

                let tot = 0;

                for (let j = 1; j < response.AllQuestionsArray.length; j++) 
                {
                    let detailArr = response.AllQuestionsArray[j].questions[0];

                    console.log(detailArr);

                    let topicHeadingBlock = document.createElement("div");
                    topicHeadingBlock.classList.add("d-flex", "margin");

                    let topicheading = document.createElement("h2");
                    topicheading.innerHTML = `Topic: ${detailArr.topic}`;

                    let topicmarks = document.createElement("p");
                    let tmarkpan = document.createElement("span");

                    let pointSpan = document.createElement("span");
                    pointSpan.innerHTML = " Points";

                    tmarkpan.innerHTML = detailArr.maxMarks;
                    tmarkpan.setAttribute("id", `t${detailArr.topicId}`);

                    topicmarks.appendChild(tmarkpan);
                    topicmarks.appendChild(pointSpan);

                    topicHeadingBlock.appendChild(topicheading);
                    topicHeadingBlock.appendChild(topicmarks);

                    questionBlock.appendChild(topicHeadingBlock);   

                    let questionArr = detailArr.questionsDet;

                    for (let i = 0; i < questionArr.length; i++) 
                    {
                        sr++;
                        let fullQuesDiv = document.createElement("div");
                        fullQuesDiv.classList.add("draggable");
                        fullQuesDiv.setAttribute("draggable", true);
                        fullQuesDiv.setAttribute("data-index", i);
                        fullQuesDiv.setAttribute("id", `ques${i}`);

                        // Question
                        let divQues = document.createElement("div");
                        divQues.classList.add('pdf-question');
                        divQues.innerHTML = `<strong>Ques. ${sr}</strong>.  ${questionArr[i].question}`;

                        // Marks
                        let marksDiv = document.createElement("p");
                        marksDiv.classList.add('pdf-marks');
                        
                        let markspan = document.createElement("span");
                        markspan.setAttribute("contenteditable", "true");
                        markspan.classList.add("mark-span", `t${detailArr.topicId}`);
                        // markspan.setAttribute("data-mark", `t${detailArr.topicId}`);
                        // markspan.setAttribute("onblur", "updateMaxScore()");
                    
                        markspan.setAttribute("id", questionArr[i].questionId)
                        markspan.innerText = questionArr[i].score;

                        markspan.setAttribute("onblur", `updateMaxScore(${examResponse.examId}, ${questionArr[i].questionId}, this.innerText, t${detailArr.topicId})`);
                        
                        let points = document.createElement("span");
                        points.innerText = " Points";

                        marksDiv.appendChild(markspan);
                        marksDiv.appendChild(points);


                        fullQuesDiv.appendChild(divQues);
                        fullQuesDiv.appendChild(marksDiv);

                        if(examResponse.examType == "question")
                        {
                            // Type
                            if(questionArr[i].questionType == 'LAQ')
                            {
                                for (let j = 0; j < 12; j++) 
                                {
                                    let hr = document.createElement("hr");
                                    hr.classList.add("pdf-line");
                                    fullQuesDiv.appendChild(hr);
                                }
                            }
                            else if(questionArr[i].questionType == 'SAQ')
                            {
                                for (let j = 0; j < 6; j++) 
                                {
                                    let hr = document.createElement("hr");
                                    hr.classList.add("pdf-line");
                                    fullQuesDiv.appendChild(hr);
                                }
                            }
                            else if(questionArr[i].questionType == 'MCQ')
                            {
                                let optArr = questionArr[i].options;

                                let ol = document.createElement("div");

                                for (let j = 0; j < optArr.length; j++) 
                                {
                                    let optBlock = document.createElement("article");
                                    let box = document.createElement("span");
                                    box.classList.add("box");
                                    let li = document.createElement("span");
                                    li.innerHTML = optArr[j];
                                    optBlock.appendChild(box);
                                    optBlock.appendChild(li);
                                    ol.appendChild(optBlock);
                                }

                                fullQuesDiv.appendChild(ol);
                            }
                        
                        }
                        else if(examResponse.examType == "answer")
                        {
                            let ansdiv = document.createElement("div");
                            ansdiv.classList.add("text-light");
                            ansdiv.innerHTML = `<strong>Ans: </strong> ${questionArr[i].answer}`;
                            fullQuesDiv.appendChild(ansdiv);
                        }

                        questionBlock.appendChild(fullQuesDiv);   
                    }

                    tot += detailArr.maxMarks;
                }

                document.getElementById("prev-max-marks").innerHTML = "Max Marks: " + tot;
                

                addEventListeners();

                function dragStart() 
                {
                    dragStartIndex = +this.getAttribute('data-index');
                }
                
                function dragEnter() 
                {
                    this.classList.add('over');
                }

                function dragLeave() 
                {
                    this.classList.remove('over');
                }

                function dragOver(e) 
                {
                    e.preventDefault();
                }

                function dragDrop() 
                {
                    const dragEndIndex = +this.getAttribute('data-index');
                    swapItems(dragStartIndex, dragEndIndex);
                    this.classList.remove('over');
                }

                // Swap list items that are drag and drop
                function swapItems(fromIndex, toIndex) 
                {
                    console.log(`Start : ${fromIndex} End: ${toIndex}`);

                    const itemOne = document.querySelector(`#ques${fromIndex}`);
                    const itemTwo = document.querySelector(`#ques${toIndex}`);

                    console.log(itemOne, itemTwo);

                    function insertAfter(newNode, existingNode) {
                        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
                    }

                    insertAfter(itemOne, itemTwo);

                }


                function addEventListeners()
                {
                    let draggables  = document.querySelectorAll(".draggable");
                    console.log(draggables);
                    draggables.forEach(draggable => {
                        draggable.addEventListener('dragstart', dragStart);
                        draggable.addEventListener('dragover', dragOver);
                        draggable.addEventListener('drop', dragDrop);
                        draggable.addEventListener('dragenter', dragEnter);
                        draggable.addEventListener('dragleave', dragLeave);
                    });
                }

            }    
        };  
        xmlhttp.open("GET", "downloadContent.php?exam_id=" + examid +"&&type=" + examtype + "&&mode=" + exammode, true); 
        xmlhttp.send(); 
 
    }

    function updateMaxScore(examId, quesId, quesScore, topicid)
    {
        console.log(topicid);
        let iid = topicid.getAttribute("id");
        console.log(iid);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
                // TOTAL STARTS
                let markSpan = document.querySelectorAll(".mark-span");  
                let sum = 0;
                markSpan.forEach(mark => {
                    sum += parseInt(mark.innerText);
                });
                document.getElementById("prev-max-marks").innerHTML = `Max Marks: ${sum}`;
                // TOTAL ENDS


                // Topic Total starts
                let markSpan1 = document.querySelectorAll(`.${iid}`);  
                console.log(markSpan1);
                let sum1 = 0;
                markSpan1.forEach(mark1 => {
                    sum1 += parseInt(mark1.innerText);
                });
                document.getElementById(`${iid}`).innerHTML = `${sum1}`;
                // Topic Total ends

            }    
        };  
        xmlhttp.open("GET", "updateData.php?exam=" + examId + "&prevQuesId=" + quesId + "&prevScore=" +  quesScore, true); 
        xmlhttp.send();
    } 


    function submitExamQuestion()
    {
        let  examid = document.getElementById("examId").value;
        let  examtype = document.getElementById("examtype").value;
        let  exammode = document.getElementById("examMode").value;

        let markSpan = document.querySelectorAll(".mark-span"); 
        let quesObj = [];
        for (let i = 0; i < markSpan.length; i++) 
        {
            quesObj.push(
                {
                    "question": markSpan[i].getAttribute("id"),
                    "score" : markSpan[i].innerText,
                    "order" : `${i+1}`,
                    "examId": examid
                }
            );
            
        } 

        let passQuesData = JSON.stringify(quesObj);

        // console.log(passQuesData);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {      
            if (this.readyState == 4 && this.status == 200) 
            {  
               window.location.href = "preview.php?exam_id="+examid+"&&type="+examtype+"&&examMode="+exammode;
            }    
        };  
        xmlhttp.open("POST", "updateData.php?data="+passQuesData+"&&exam_id="+examid+"&&type="+examtype+"&&mode="+exammode, true); 
        xmlhttp.send();
    }


    function download(divName)
    {
		//Set the print button visibility to 'hidden' 
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
    }



    function updateSemester(id, name)
    {
        if(name == '')
        {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {      
                if (this.readyState == 4 && this.status == 200) 
                {  
                    if(this.responseText == '')
                    {
                        document.getElementById("prev-semester").innerHTML = '_';
                    }
                    else
                    {
                        document.getElementById("prev-semester").innerHTML = this.responseText;
                    }
                }    
            };  
            xmlhttp.open("GET", "updateData.php?getExam_id=" + id +"&semester=" + name , true); 
            xmlhttp.send();
        }
        else
        {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {      
                if (this.readyState == 4 && this.status == 200) 
                {  
                    document.getElementById("prev-semester").innerHTML = this.responseText;
                }    
            };  
            xmlhttp.open("GET", "updateData.php?exam_id=" + id +"&semester=" + name , true); 
            xmlhttp.send();
        }
        
    }

