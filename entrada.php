<!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como entrada.php -->
<?php
require_once('session_init.php');
session_start();
require_once('conexao.php');

$mysql = new BancodeDados();
$mysql->conecta();

$plogin = $_POST['login'] ?? '';
$psenha = $_POST['senha'] ?? '';

$sqlstring = "select * from tbusuario where login='$plogin' and senha='$psenha'";
$result = $mysql->query($sqlstring);
$total = $result->num_rows;

if ($total == 1) {
    $dados = $result->fetchArray();
    $_SESSION['id']    = $dados['id'];
    $_SESSION['nome']  = $dados['nome'];
    $_SESSION['log']   = 'ativo';
    $_SESSION['nivel'] = $dados['nivel'];
    session_write_close();

    $sid = session_name() . '=' . session_id();

    if ($_SESSION['nivel'] == "adm") {
        echo "<script>alert('Voce esta logado'); window.location.href='cadastro.php?$sid';</script>";
    } else {
        echo "<script>alert('Bem vindo ao sistema'); window.location.href='principal.php?$sid';</script>";
    }
} else {
    echo "<script>alert('Usuario ou senha invalidos'); window.location.href='naoentrou.php';</script>";
}

$mysql->fechar();
?>

