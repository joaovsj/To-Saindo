<?php

namespace App\Entity;
use \App\Db\Database;

date_default_timezone_set('America/Sao_Paulo');

class Historic{


    public $nome = "";
    public $ano = 0;
    public $curso = "";
    public $idAluno;
    
    private $objDatabase; 

    public function __construct(){
        $this->objDatabase = new Database('historico');
    }

    public function insertRecord(){
       
        // AAAA-MM-DD HH:MM:SS
        $today = date('Y-m-d H:i:s'); 

        $this->objDatabase->insert([
            'nome' => $this->nome,
            'ano' => $this->ano,
            'curso' => $this->curso,
            'hora' => $today,
            'idAluno' => $this->idAluno
        ]);

        return true;
    }

    public function deleteRecord($id){
        return $this->objDatabase
        ->delete('idHistorico = '.$id);
    }

    public function getRecords($where = null){
        return $this->objDatabase
        ->selectHistoric($where)
        ->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRecord($id){
        return $this->objDatabase
        ->select("idHistorico = ".$id)
        ->fetch(\PDO::FETCH_OBJ);   
    }




}