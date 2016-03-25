<?php


if($_POST["logout"]=="logout")
{
   session_start();
   session_destroy();
   header('location:index1.php');
}

if($_POST["beritebeng"]=="nebeng")
{
   header('location:http://www.google.com');
}


?>