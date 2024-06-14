<?php 

session_start();
unset($_SESSION["statusAdmin"]);   
unset($_SESSION["userAdmin"]);   

header('Location: ../index.php');