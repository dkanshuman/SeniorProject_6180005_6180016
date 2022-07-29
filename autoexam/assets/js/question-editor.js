
function closeEditorForm(value)
{
    document.getElementById(value).classList.remove("show");
}


function displayEditorForm(value, qContent, qEditor)
{
    console.log(value, qContent, qEditor);
    let valueArr = value.split('-');
    let val = valueArr[0];
    document.querySelector('#upload-block').classList.remove("show");   
    document.querySelector('#table-block').classList.remove("show");  
    document.getElementById(`${val}-editor`).value = qEditor;
    document.getElementById(`${val}-content`).value = qContent;

    document.getElementById(value).classList.add("show");        
} 

window.onload = loadContent;

function loadContent()
{
    let tableForm = document.getElementById("loadTableForm");
    tableForm.onsubmit = submitTable;
}

// CREATE A TABLE IN TEXT EDITOR
function submitTable(e)
{
    e.preventDefault();

    let cols = document.getElementById("cols").value;
    let rows = document.getElementById("rows").value;
    let caption = document.getElementById("caption").value;

    let header = '';

    if(document.getElementById("header").checked)
    {
        header = document.getElementById("header").value;
    }

    let formData = new FormData(); 

    formData.append('cols', cols);
    formData.append('rows', rows);
    formData.append('caption', caption);
    formData.append('header', header);

    let request = new XMLHttpRequest();

    request.onload = function () 
    {
        if (request.status == 200) 
        {
            let contentValue = document.getElementById("table-content").value;
            let editorValue = document.getElementById("table-editor").value;
            let cont = document.getElementById(contentValue);	
            let editor = document.getElementById(editorValue);

            cont.insertAdjacentText('beforeend', this.responseText);
            editor.insertAdjacentHTML('beforeend', this.responseText);
            document.querySelector('#loadTableForm').reset();
            document.querySelector('#table-block').classList.remove("show"); 
        } 
        else 
        {
            console.log("Error in table. Try again.");
        }
    };

    request.open("POST", "editorTable.php");
    request.send(formData);
    return false;
    
}



// ADD AN IMAGE IN TEXT EDITOR
let imgForm = document.getElementById("imgForm");

imgForm.addEventListener('submit', function(event)
{
    event.preventDefault();
    
    let myFile = document.getElementById('fileimg');

    let files = myFile.files;

    let formData = new FormData();
    
    let file = files[0];

    formData.append('fileAjax', file, file.name);

    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'editorImage.php', true);

    xhr.onload = function () 
    {
        if (xhr.status == 200) 
        {
            console.log(this.responseText);

            let contentValue = document.getElementById("upload-content").value;
            let editorValue = document.getElementById("upload-editor").value;
            let cont = document.getElementById(contentValue);	
            let editor = document.getElementById(editorValue);

            cont.insertAdjacentText('beforeend', this.responseText);
            editor.insertAdjacentHTML('beforeend', this.responseText);
            document.querySelector('#imgForm').reset();

            document.querySelector('#upload-block').classList.remove("show"); 
        } 
        else 
        {
            console.log("Upload error. Try again.");
        }
    };

    xhr.send(formData);
});


let editor = document.getElementById("questionEditor");

document.getElementById("questionContent").innerHTML =  editor.innerHTML;

function addContent(value, content)
{
    document.getElementById(content).innerHTML =  value;
}


// REMOVE FORMATTING WHILE COPY PASTE
document.getElementById("questionEditor").addEventListener("paste", removeFormatting);
document.getElementById("answerEditor").addEventListener("paste", removeFormatting);

function removeFormatting(e) 
{
    e.preventDefault();
    var text = e.clipboardData.getData("text/plain");
    document.execCommand("insertHTML", false, text);
}

// Get Option value and add it to the answer (MCQ)
function getOptionValue(optvalue)
{
    console.log(optvalue);
    let ovalue = document.getElementById(optvalue).value;
    // document.getElementById('answerEditor').innerHTML = ovalue;
    document.getElementById('answerContent').innerHTML = ovalue;
}


function contentAdd()
{
    document.getElementById("questionContent").innerHTML = document.getElementById("questionEditor").innerHTML;
    document.getElementById("answerContent").innerHTML = document.getElementById("answerEditor").innerHTML;

    document.getElementById("op1").innerHTML = document.getElementById("answerEditorop1").innerHTML;
    document.getElementById("op2").innerHTML = document.getElementById("answerEditorop2").innerHTML;
    document.getElementById("op3").innerHTML = document.getElementById("answerEditorop3").innerHTML;
    document.getElementById("op4").innerHTML = document.getElementById("answerEditorop4").innerHTML;
}


function contentOptionAdd()
{
    document.getElementById("questionContent").innerHTML = document.getElementById("questionEditor").innerHTML;

    document.getElementById("op1").innerHTML = document.getElementById("answerEditorop1").innerHTML;
    document.getElementById("op2").innerHTML = document.getElementById("answerEditorop2").innerHTML;
    document.getElementById("op3").innerHTML = document.getElementById("answerEditorop3").innerHTML;
    document.getElementById("op4").innerHTML = document.getElementById("answerEditorop4").innerHTML;
}

// ********************* Change Dimension Starts *********************

// Get value from the form
function resize(name)
{
    let img = document.getElementById(name);
    console.log(img);
    // Get extension
    let imgSrc = img.src;
    let splitSrc = imgSrc.split(".");
    let ext = splitSrc.slice(-1);
    
    document.getElementById("old-image-name").value = `${name}.${ext}`;


    document.getElementById("resize-block").classList.add("show");  
    document.getElementById("image-editor").value = name;
    document.getElementById("resize-width").value = img.width;
    document.getElementById("old-resize-width").value = img.width;
    document.getElementById("resize-height").value = img.height;
    document.getElementById("old-resize-height").value = img.height;
}

// Change height in ratio
function changeHeight(width)
{
    let targetWidth = document.getElementById("old-resize-width").value;
    let targetHeight = document.getElementById("old-resize-height").value;

    let ratio = width / targetWidth;
    document.getElementById("resize-height").value = parseInt(targetHeight * ratio);
}

function changeWidth(height)
{
    let targetWidth = document.getElementById("old-resize-width").value;
    let targetHeight = document.getElementById("old-resize-height").value;

    let ratio = height / targetHeight;
    document.getElementById("resize-width").value = parseInt(targetWidth * ratio);
}


// On Submit Resize Form

let resizeForm = document.getElementById("resizeForm");


resizeForm.addEventListener('submit', function(event)
{
    event.preventDefault();

    let img = document.getElementById("image-editor").value;
    let oldname = document.getElementById("old-image-name").value;

    let resizeWidth = document.getElementById("resize-width").value;
    let resizeHeight = document.getElementById("resize-height").value;
    let quality = document.getElementById("resize-quality").value;

    let image_url = document.getElementById(`${img}`).src;

    let image = document.createElement("img");
    image.src = image_url;
    image.onload = (e) => {
        let canvas = document.createElement("canvas");
        canvas.width = resizeWidth;
        canvas.height = resizeHeight;
       
        const context = canvas.getContext("2d");
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
       
        let new_image_url = context.canvas.toDataURL("image/jpeg", 100);
       
        let new_image = document.createElement("img");
        new_image.src = new_image_url;
        new_image.setAttribute("id", `${img}`);
        new_image.setAttribute("ondblclick", `resize(${img})`);

        canvas.toBlob(function (blob) 
        {
            const form = new FormData()
            
            form.append('image', blob, `${img}.jpg`);
            form.append('oldname', oldname);
            form.append('imgname', img);

            const xhr = new XMLHttpRequest();
           
            xhr.onreadystatechange = function() {      
                if (this.readyState == 4 && this.status == 200) 
                {  
                    console.log(this.responseText);
                    document.getElementById(`div-${img}`).innerHTML = " ";

                    document.getElementById(`div-${img}`).innerHTML = this.responseText;
                    document.getElementById(`div-${img}`).setAttribute("id", `div-1${img}`);

                }      
            }; 

            xhr.open('POST', 'editorResize.php', true);
            xhr.send(form);

        });

    }

    // document.querySelector('#resizeForm').reset();
    document.getElementById("resize-block").classList.remove("show");  
});


// ********************* Change Dimension Ends *********************



