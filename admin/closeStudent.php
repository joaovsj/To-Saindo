<?php 


session_start();
unset($_SESSION["statusStudent"]);   
unset($_SESSION["userStudent"]);   

header('Location: ../index.php');

