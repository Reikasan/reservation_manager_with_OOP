<?php 
require_once("classes/init.php"); 

$session->logout();
redirect("login.php");

?>