<?php
class Usuario {

    private $pdo;                               //pdo privado para só ter acesso desta classe
    public $msgError = "";                      //variavel erro retornando vazio
    public function conectar($nome, $host, $user, $pass) {              //método externo para conectar o banco de dados
        global $pdo;
        try {                                           //evitar erros com o try
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$user,$pass);
        } catch(PDOException $e) {
            $msgError = $e->getMessage();
        }
    }
    public function cadastrar($nome, $cpf, $senha) {
        global $pdo;
        //verificar se há cadastro
        $sql = $pdo->prepare("SELECT id FROM usuario WHERE cpf = :cpf");
        $sql->bindValue(":cpf", $cpf);
        $sql->execute();
        if ($sql->rowCount() > 0) {         //verificar se há chaveprimaria existente
            return false;
        } else {                        //caso nao tenha
            $sql = $pdo->prepare("INSERT INTO usuario (nome, cpf, senha) VALUES (:n, :cpf, :s)");  //cadastro
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":s", $senha);
            $sql->execute();
            return true;
        }
    }
    public function logar($usuario, $senha) {
        global $pdo;
        $sql = $pdo->prepare("SELECT id FROM usuario WHERE nome = :n AND senha = :e");    //verificar se há conta
        $sql->bindValue(":n", $usuario);
        $sql->bindValue(":e", $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {                 //se tiver conta
            $dados = $sql->fetch();                 //guardar de forma string(fetch)
            session_start();
            $_SESSION["id"] = $dados ["id"];          //area privada do usuario
            return true;
        } else {                                //se nao tiver conta
            return false;
        }
    }
}
?>