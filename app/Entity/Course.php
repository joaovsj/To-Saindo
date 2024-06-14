<?php 

namespace App\Entity;
use \App\Db\Database;

class Course{
    
    public $id;
    public $nome;
    public $ano;

    public function cadastrar(){

        $objDatabase = new Database('classes');

        $this->id = $objDatabase->insert([
            'curso' => $this->nome,
            'ano' => $this->ano
        ]);

        return true;
    }

    public static function getCourses($where = null){
        return(new Database('classes'))
        ->select($where)
        ->fetchAll(\PDO::FETCH_OBJ);
    }

    public function delete($idClasse){

        return (new Database('classes'))
        ->delete('idClasse = '.$idClasse);
        
    }

}