<?php 

function checkEmpty($vars){
    
    $fields = [];

    // retira ultima posicao de array
    array_pop($vars);

    foreach ($vars as $key => $value) {
        
        if(empty($value)){
            return false;
        }

        $fields[$key] = $value;
    }

    return $fields;
}


function checkStudent($alunos, $id){

    $status = false;

    foreach($alunos as $aluno){
        if($aluno->idAluno === $id){
            $status = true;
        }
    }

    if($status === true){
        return true;
    }

    return false;
}

function checkGuards($guards, $id){
    
    $status = false;

    foreach($guards as $guard){
        if($guard->idAdmin === $id){
            $status = true;
        }
    }

    if($status === true){
        return true;
    }

    return false;
    
}

function isLoggedIn(){
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        return false;
    }
    return true;
}