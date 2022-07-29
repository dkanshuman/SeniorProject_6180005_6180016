<?php 
    session_start();
    require './includes/config.php'; 
    require_once './includes/connection.php';

    $ext = explode(".", $_FILES['fileAjax']['name']);
    $extension = end($ext)	;
    $name = time();
    $newname = $name.'.'.$extension;
    
    $tmpname = $_FILES['fileAjax']['tmp_name'];


    $dest = "./assets/images/exam/";

    if(move_uploaded_file($tmpname, $dest.$newname))
    {
        echo "<div id=\"div-$name\"><img src=\"./assets/images/exam/$newname\" class=\"w-img\" id=\"$name\" ondblclick=\"resize($name)\"/></div>";
    }
   