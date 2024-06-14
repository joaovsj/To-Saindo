<?php 


session_start();
unset($_SESSION["statusGuard"]);   
unset($_SESSION["userGuard"]);   

unset($_SESSION["status"]);   
unset($_SESSION["mensagem"]);   



header('Location: ../index.php');
