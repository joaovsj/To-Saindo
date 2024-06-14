<?php 

    require __DIR__.'/vendor/autoload.php';
    use \App\Entity\Time;

    $obTime = new Time();   

    $dias = $obTime->checkDays($_POST);
    $hours = $obTime->checkTime($_POST);
    
    extract($_POST);
    $obTime->deleteHour($ano, $curso);

    foreach ($dias as $key => $dia) {

        if($key == 0){
            $obTime->insertTime($dia, $hours['primeiroHorario'], $ano, $curso);    

        }else if($key == 1){
            $obTime->insertTime($dia, $hours['segundoHorario'], $ano, $curso);    

        }else if($key == 2){
            $obTime->insertTime($dia, $hours['terceiroHorario'], $ano, $curso);    

        }else if($key == 3){
            $obTime->insertTime($dia, $hours['quartoHorario'], $ano, $curso);    

        }else{
            null;
        }
    }    

    header('Location: course.php?ano='.$_POST['ano'].'&curso='.$_POST['curso'].'&mensagem=true');
    exit;

    
    


