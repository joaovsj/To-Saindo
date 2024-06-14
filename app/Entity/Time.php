<?php 

namespace App\Entity;
use \App\Db\Database;
date_default_timezone_set('America/Sao_Paulo');


class Time{

    private $objDatabase;

    public function __construct(){
        $this->objDatabase = new Database('horarios');
    }

    // limpa os dias enviados
    public function checkDays($vars = []){

        $dias = [];
        foreach ($_POST as $key => $value) {

            if($key == 'primeiroDia'){
                $dia = empty($value) ? '' : $this->retornarDia($value); 
                $dia == '' ? null : array_push($dias, $dia);

            } else if($key == 'segundoDia'){
                $dia = empty($value) ? '' : $this->retornarDia($value);
                $dia == '' ? null : array_push($dias, $dia);

            } else if($key == 'terceiroDia'){
                $dia = empty($value) ? '' : $this->retornarDia($value);
                $dia == '' ? null : array_push($dias, $dia);

            } else if($key == 'quartoDia'){
                $dia = empty($value) ? null : $this->retornarDia($value);
                $dia == '' ? null : array_push($dias, $dia);

            } else{
                continue;

            }
        }

        return $dias;
    }

    // retorna o dia sem sem o numero
    public function retornarDia($dia){
        
        $dia = explode('-', $dia);
        $ultimoIndice = array_key_last($dia);
        unset($dia[$ultimoIndice]);
       
        $dia = $this->transformaString($dia);
        return $dia;
    }
    
    // metodo responsavel por transforma array em STRING
    public function transformaString($dia){        
        
        $dia = implode("", $dia);
        return $dia;
    }
    
    // funcao responsavel por retornar horarios enviados
    public function checkTime($vars = []){

        // horas
        $hours = [];
        foreach ($vars as $key => $value) {
    
            if($key == 'primeiroHorario'){

                $hour = empty($value) ? '' : $this->defineTime($value); 
                $hour == '' ? null : $hours['primeiroHorario'] = $hour; 

            } else if($key == 'segundoHorario'){
                
                $hour = empty($value) ? '' : $this->defineTime($value); 
                $hour == '' ? null : $hours['segundoHorario'] = $hour; 
    
            } else if($key == 'terceiroHorario'){
                
                $hour = empty($value) ? '' : $this->defineTime($value); 
                $hour == '' ? null : $hours['terceiroHorario'] = $hour; 
    
            } else if($key == 'quartoHorario'){
                
                $hour = empty($value) ? '' : $this->defineTime($value); 
                $hour == '' ? null : $hours['quartoHorario'] = $hour; 
    
            } else{
                continue;

            }        
        }

        return $hours;
    } 

    // define horario
    public function defineTime($time){
        
        $hour = explode(' às ', $time);
        $hour[0] = $hour[0].':00';
        $hour[1] = $hour[1].':00';

        return $hour;

    }

    // funcao responsavel por cadastrar o horario
    public function insertTime($dia, $horario = [], $ano, $curso){  

        // die(var_dump($dia, $horario, $ano, $curso));

        $this->objDatabase->insert([
            'dia' => $dia,
            'entrada' => $horario[0],
            'saida' => $horario[1],
            'ano' => $ano,
            'curso' => $curso,
        ]);

        return true;

    }

    public function deleteHour($ano, $curso){
        return $this->objDatabase
        ->delete('ano = '.$ano.' AND curso = "'.$curso.'"');
    }   


    public function getHour($ano, $curso){
        return $this->objDatabase
        ->select('ano = '.$ano.' AND curso = "'.$curso.'"')
        ->fetchAll(\PDO::FETCH_OBJ);
    }

    // metodo responsavel por retornar id no frontEnd da aula 
    public function pullHour($hour){

        $horarios = [
            1 => '13:10:00 às 14:00:00',
            2 => '14:00:00 às 14:50:00',
            3 => '14:50:00 às 15:40:00',
            4 => '15:40:00 às 16:30:00',
            5 => '16:50:00 às 17:40:00',
            6 => '17:40:00 às 18:30:00'
        ];

        $hora = $hour->entrada.' às '.$hour->saida;
        $index = array_search($hora, $horarios);

        return $hour->dia.'-'.$index;
    }

    // retorna um array, apenas com os horarios
    public function onlyHour($vars = []){
        
        $hours = [
            0 => [],
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
        ];

        // adicionado somente os numeros no array
        foreach ($vars as $key => $value) {

            $hours[$key][$value->dia] = [
                $value->entrada,
                $value->saida
            ];
        }

        // limpando indices vazios
        foreach ($hours as $key => $value) {
            if(empty($value)){
                unset($hours[$key]);
            }
        }

        return $hours;
    }

    // retorna o dia da semana
    public function getDay(){
    
        $diaSemana = array('dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab');        
        $data = date('Y-m-d');
        // Varivel que recebe o dia da semana (0 = Domingo, 1 = Segunda ...)
        $numeroSemana = date('w', strtotime($data));

        return $diaSemana[$numeroSemana];
    }
    
    // verificar horario
    public function checkHour($dayNow, $allHours){

        foreach ($allHours as $key => $day) {
            if(isset($day[$dayNow])){
                
                $entrada = $this->parseStrTotime($day[$dayNow][0]); 
                $saida   = $this->parseStrTotime($day[$dayNow][1]);
                $now = strtotime('17:50:00');

                if ($entrada <= $now && $now <= $saida) {

                    $response = [
                        'status' => true,
                        'mensagem' => 'Horário permitido.'
                    ];

                    return $response;
                }
            }
        }

        $response = [
            'status' => false,
            'mensagem' => 'Horário Inválido.'
        ];

        return $response;
    }

    // transforma horario em string
    public function parseStrTotime($var){
        $var = strtotime( date('Y-m-d' . $var));
        return $var;
    }
}