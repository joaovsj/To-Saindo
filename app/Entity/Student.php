<?php 

namespace App\Entity;
use \App\Db\Database;
use \App\Entity\Historic;

class Student{
    
    public $idAluno; 
    public $nome;
    public $cpf;
    public $email;
    public $telefone;
    public $cep;
    public $uf;
    public $cidade;
    public $rua;
    public $bairro;
    public $numero;
    public $rm;
    public $ano;
    public $curso;
    
    public $imagem = '';
    private $error = [];
    private $objDatabase;
    private $secondDatabase;

    public function __construct(){
        $this->objDatabase = new Database('alunos');
        $this->secondDatabase = new Database('imagens');
    }

    public function cadastrar(){
        
        $this->clearVars();

        // verifica se existe erros
        if($this->checkError()){
            header('Location: register.php?status=verify&ano='.$this->ano.'&curso='.$this->curso);
            exit;
        }

        $this->idAluno = $this->objDatabase->insert([
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'cep' => $this->cep,
            'uf' => $this->uf,
            'cidade' => $this->cidade,
            'rua' => $this->rua,
            'bairro' => $this->bairro,
            'numero' => $this->numero,
            'rm' => $this->rm,
            'ano' => $this->ano,
            'curso' => $this->curso
        ]);

        $this->registerIMG();

        return true;     
    }

    public function registerIMG(){
        
        $this->secondDatabase->insert([
            'nomeImagem' => $this->imagem,
            'fk_idAluno' => $this->idAluno
        ]);

        return true;
    }

    public function getImg($id){
        return $this->secondDatabase
        ->select('fk_idAluno = '.$id)
        ->fetch(\PDO::FETCH_OBJ);
    }

    public function deleteImg($id){
        return $this->secondDatabase
        ->delete('fk_idAluno = '.$id);
    }


    // funcoes de validacao 
    private function clearVars(){

        // die(var_dump($this));
        $this->checkCPF($this->cpf);
        $this->checkTelefone($this->telefone);
        $this->checkCEP($this->cep);
        $this->checkRM($this->rm);
    }

    //funcao de validacao CPF
    private function checkCPF($number){
        
        $cpf = preg_replace("/\D/", "", $number);
        
        // verifica se existem caractesres repetidos
        if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
            $this->error['cpf'] = 'CPF Inválido';
            
            return false;
        }

        $this->cpf = $cpf;
        return true;
    } 

    //funcao de validacao telefone
    private function checkTelefone($number){
        
        if(preg_match('^\(+[0-9]{2}\) [0-9]{5}-[0-9]{4}$^', $number)){
            return true;
        }

        $this->error['telefone'] = 'Telefone Inválido';
        return false;
    }  

    //funcao de validacao CEP
    private function checkCEP($number){
            
        if (preg_match("/^[0-9]{5}-[0-9]{3}$/", $number)) {
            return true;
        }

        $this->error['cep'] = 'CEP Inválido';
        return false;
    }

    //funcao de validacao CEP
    private function checkRM($number){

        if (preg_match("/^[0-9]{11}$/", $number)) {
            return true;
        } 

        $this->error['rm'] = 'RM Inválido';
        return false;
    }

    // funcao responsavel por verificar se existe algum erro
    private function checkError(){

        if(count($this->error) > 0){
            return true;
        }

        return false;
    }

    public function getStudent($id){
        return $this->objDatabase
        ->select("idAluno = ".$id)
        ->fetch(\PDO::FETCH_OBJ);
        
    }

    public function getAllStudents(){
        return $this->objDatabase
        ->select()
        ->fetchAll(\PDO::FETCH_OBJ);
    }

    public function deleteStudent($id){

        // apaga do historico
        $obHistoric = new Historic();   
        $obHistoric->deleteRecord($id);

        return $this->objDatabase
        ->delete('idAluno = '.$id);
    }


    public function getStudents($ano, $curso){
        return $this->objDatabase
        ->selectOne("ano = $ano AND curso = '$curso'")
        ->fetchAll(\PDO::FETCH_OBJ);
    }

    public function atualizar($id){
        
        $this->clearVars();

        // verifica se existe erros
        if($this->checkError()){
            header('Location: register.php?status=verify&ano='.$this->ano.'&curso='.$this->curso);
            exit;
        }

        $this->objDatabase->update('idAluno = '.$id, [
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'cep' => $this->cep,
            'uf' => $this->uf,
            'cidade' => $this->cidade,
            'rua' => $this->rua,
            'bairro' => $this->bairro,
            'numero' => $this->numero,
            'rm' => $this->rm,
            'ano' => $this->ano,
            'curso' => $this->curso
        ]);

        return true;  
    }
}




