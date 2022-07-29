<?php 

function sanitise_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function success($success)
{
    return "<div class=\"success\">$success</div>";
} 

function error($error)
{
    return "<div class=\"error\">$error</div>";
}