<?php
require_once('session_init.php');
session_start();
if ($_SESSION['log'] != "ativo") {
    echo "<script>alert('Precisa estar logado'); window.location.href='index.php';</script>";
    exit;
}
require_once('conexao.php');
$id = intval($_GET['id'] ?? 0);
$mysql = new BancodeDados();
$mysql->conecta();
$query = $mysql->query("select * from tbproduto where id=$id");
$dados = $query->fetchArray();
$del = $mysql->query("delete from tbproduto where id=$id");
if ($del) {
    echo "<script>alert('Deletado com sucesso!'); window.location.href='pesquisa.php';</script>";
} else {
    echo "<script>alert('Nao foi possivel deletar'); window.location.href='pesquisa.php';</script>";
}
$mysql->fechar();
?>
