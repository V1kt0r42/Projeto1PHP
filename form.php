<?php
include_once "Classes/usuarios.php";
$u = new Usuario;

$login = $_POST["log"];
$senha = $_POST["pass"];
if (!empty($login)&&!empty($senha)) {
    $u->conectar("contas","localhost","root","");
    if ($u->msgError == "") {
        
    };
} else {
    echo "Espaço em branco";
}

if ($u->logar($login, $senha)) {

} else {
    echo "usuario ou senha incorretos";
}
;
?>