<?php 

namespace App\Db;
use \PDO;

class Database{
    
    const HOST = 'localhost';
    const NAME = 'tcc';
    const USER = 'root';
    const PASS = '';

    private $table;
    private $conn;

    public function __construct($table){
        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection(){
        try {
            $this->conn = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME.';charset=utf8', self::USER, self::PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch (\PDOException $e) {
            die('Erro: '.$e->getMessage());
        }
    }

    public function insert($values){

        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        $query = 'INSERT INTO '.$this->table.'('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';

        $this->execute($query, array_values($values));

        return $this->conn->lastInsertId();
   }

   public function execute($query, $params = []){
        try {
            $stmt = $this->conn->prepare($query); 
            $stmt->execute($params);

            return $stmt;
            
        } catch (\PDOException $e) {
            die("
                Erro na execução: {$e->getMessage()} 
            ");
        }
   }

   public function select($where = null){
    
        $where = strlen($where) ? 'WHERE '.$where : '';    
        $query = 'SELECT * FROM '.$this->table.' '.$where;

        return $this->execute($query); 
   }

    public function delete($where){
        
        $query = 'DELETE FROM '.$this->table.' WHERE '. $where;
        $this->execute($query);

        return true;
    }

    public function selectOne($where = null){
        
        $where = strlen($where) ? ' WHERE '.$where : '';

        $query = 'SELECT *,(SELECT nomeImagem FROM imagens WHERE fk_idAluno = alunos.idAluno) AS foto FROM alunos'.$where;
        // o apelido é sempre depois do campo
        return $this->execute($query);
    }

    public function selectHistoric($where = null){

        $where = strlen($where) ? ' WHERE '.$where : '';

        $query = 'SELECT *,(SELECT nomeImagem FROM imagens WHERE fk_idAluno = historico.idAluno) AS foto FROM historico'.$where;
        // o apelido é sempre depois do campo
        return $this->execute($query);

    }

    public function selectGuards(){

        $query = 'SELECT *,(SELECT nomeImagem FROM imagens_segurancas WHERE fk_idAdmin = admin.idAdmin) AS foto FROM admin';
    
        // o apelido é sempre depois do campo
        return $this->execute($query);

    }


    public function update($where, $values){
        
        // campos da query
        $fields = array_keys($values);

        $query = 'UPDATE '.$this->table. ' SET '.implode('=?,', $fields).'=? WHERE '.$where;
        
        $this->execute($query, array_values($values));

        return true;
    }
    
}