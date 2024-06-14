<?php 

require __DIR__.'/vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');

use \App\Entity\Student;
use \App\Entity\Time;
use \App\Entity\Historic;

if(!isset($_GET['id'])){
    header('Location: index.php');
    exit;
}

// definindo variaveis
$id = $_GET['id'];
$obStudent = new Student();
$obTime = new Time();
$obHistoric = new Historic();

// dados do id
$student = $obStudent->getStudent($id);

$allData = $obTime->getHour($student->ano, $student->curso); 
$allHours = $obTime->onlyHour($allData);
$dayNow = $obTime->getDay();


$response = $obTime->checkHour('qui', $allHours);

if($response['status'] === true){
    // Registra Histórico
    $obHistoric->nome = $student->nome;
    $obHistoric->ano = $student->ano;
    $obHistoric->curso = $student->curso;
    $obHistoric->idAluno = $student->idAluno;
    $obHistoric->insertRecord();    
    //////////////////////////////////////////////////////////////
}

session_start();

$_SESSION['status'] = $response['status'];
$_SESSION['mensagem'] = $response['mensagem'];

header('Location: guardArea.php');
exit;