<?php 


$connection = mysqli_connect($host, $username, $password, $dbname);

if(!$connection)
{
    echo "Connection error :".mysqli_connect_error();
}
