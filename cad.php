<?php
require_once "Classes/usuarios.php";                //puxando a classe de arquivo separado
$u = new Usuario;                                    //instanciando novo usuario

if (isset($_POST["nome"])) {
    $nome = $_POST["nome"];
    $cpf = addslashes($_POST["log"]);                        //add proteção contra sqlinjection "addslashes"
    $senha = addslashes($_POST["pass"]);
    //verificar se estar vazio
    if (!empty($nome)&&!empty($cpf)&&!empty($senha)) {
        $u->conectar("contas","localhost","root","");
        if ($u->msgError == "") {                               //se deu td certo
           if ($u->cadastrar($nome, $cpf, $senha)) {
            echo "cadastrado com sucesso";
           } else {
            echo "Conta existente";
           }
        } else {
            echo "Error:".$u->msgError;
        }
    } else {
        echo "Informe todos os dados";
    }
}
?>