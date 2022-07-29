<?php 

if(unlink("./assets/images/exam/$_POST[oldname]"))
{
    // print_r($_POST);
    // print_r($_FILES);

    $tmpname = $_FILES['image']['tmp_name'];
    $name = $_FILES['image']['name'];

    $name = 1 . $name;

    $dest = "./assets/images/exam/";

    $block = $_POST['imgname'];

    $block = 1 . $block;

    move_uploaded_file($tmpname, $dest.$name);
    // if(move_uploaded_file($tmpname, $dest.$name))
    // {
        echo "<img src=\"./assets/images/exam/$name\"  class=\"w-img\" id=\"$block\" ondblclick=\"resize($block)\"/>";
    // }

}
