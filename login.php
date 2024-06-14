<?php 

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/includes/function.php';

use \App\Entity\Admin;
use \App\Entity\Student;

$obAdmin = new Admin();
$obStudent = new Student();
checkData();

$guards = $obAdmin->getAdmin();
$students = $obStudent->getAllStudents();


$responseStudent = verifyStudent($students);

if($responseStudent === false){
    $responseGuard = verifyGuard($guards);

    if($responseGuard === false){
        
        header('Location: index.php?status=false');
        exit;
    }
}


function verifyGuard($porters){

    foreach ($porters as $key => $porter) {

        if($_POST['user'] == $porter->email){
            
            if($_POST['password'] == $porter->cpf){

                session_start();

                if($porter->idAdmin == 8){


                    $_SESSION['statusAdmin'] = true;
                    $_SESSION['userAdmin'] = $porter->idAdmin;  
                    header('Location: home.php');
                    exit;
                }

                $_SESSION['statusGuard'] = true;
                $_SESSION['userGuard'] = $porter->idAdmin;  
                header('Location: guardArea.php');
                exit;
    
            } // close password
        } // close user
    }

    return false;   
}


function verifyStudent($boys){
    foreach ($boys as $key => $student) {
    
        if($_POST['user'] == $student->email){
            
            if($_POST['password'] == $student->cpf){
    
                session_start();
                $_SESSION['statusStudent'] = true;
                $_SESSION['userStudent'] = $student->idAluno;  
                header('Location: studentArea.php');
                exit;
    
            } // close password
        } // close user
    }

    return false;
}


// verifica se os dados existem
function checkData(){

    if(isset($_POST['user'], $_POST['password'])){

        if(!empty($_POST['user'] and !empty($_POST['password']))){
            return true;
        }
            
        header('Location: index.php');
        exit;
    }

    header('Location: index.php');
    exit;
}






