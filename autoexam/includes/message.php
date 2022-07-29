<?php

if(isset($success))
{
    echo success($success);
}
else if(isset($error))
{
    foreach ($error as $value) {
        echo error($error);
    }
}
elseif(isset($_GET['success']))
{
    echo success($_GET['success']);
}
elseif(isset($_GET['error']))
{
    echo error($_GET['error']);
}

if(isset($errList))
{
    if(count($errList) > 0) 
{
    echo "<div class=\"error\">";
        foreach($errList as $value)
        {
            echo $value;
        }
    echo "</div>";
}
}
