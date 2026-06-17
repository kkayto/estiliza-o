<html>
<head>
	<title> Mostra Produto</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="refresh" content="10">
</head>
<!-- <body bgcolor="cyan">  -->

<?php
require_once('conexao/minhafuncao.php');
iniciar();
titulo();
//session_start();
if ($_SESSION['log'] != "ativo"){
echo"<script language='javascript' type='text/javascript'>alert('Precisa esta logado para acessar o conteúdo');window.location.href='index.php';</script>";
}
?>

<h1> Lista dos produtos <h1>

	<h3> Pagina do sistema Celia  </h3>

<hr>
<!--<form action="cadastro.php"method="POST" name="cadastroprin">
<h1>cadastrar novo produto</h1>
<input type="submit" name="Cadastrar" value="cadastrar">
</form> -->
 <form action=""method="POST" name="">
<h1>busca por tipo </h1>
<input type = "text" name=textobusca><br>
<input type="submit" name="buscar" value="Buscar">
</form>
 <?php
   require_once('conexao/conexao.php');
	//criando o objeto mysql e conectando ao banco de dados
	$mysql = new BancodeDados();
	$mysql->conecta();
     if(isset($_POST['buscar']) && !empty($_POST['textobusca'])){
     $pbusca=$_POST['textobusca'] ;
      $sqlstring = "select * from tbproduto where tipo='$pbusca'";
    } else{
         $sqlstring = 'select * from tbproduto order by nome';
    }
    $query = @mysqli_query($mysql->con, $sqlstring);

	echo "<table border='1px'>";
	echo "<tr><th width='30px' align='center'>Id</th><th width='100px'>Nome</th><th width='100px'>tipo</th><th width='100px'>Descrição</th><th width='100px'>comprar</th> ";

	while($dados=mysqli_fetch_array($query))
	{
	$pstatus = $dados['status'];
    if($pstatus=="liberado"){
		echo "<tr>";
		echo "<td align='center'>". $dados['id']."</td>";
		echo "<td align='center'><b>". $dados['nome']."</b></td>";
		echo "<td align='center'><b>". $dados['tipo']."</b></td>";
		echo  "<td align='center'><b>". $dados['descricao']."</b></td>";

  		$id = base64_encode($dados['id']);
  	//$id = $dados['id'];
        echo "</td> <td align='center'><a href='comprar.php?id=$id'><img src='comprar.png' width='30px' height='30px'></a>";

echo "</tr>";
}
	}
	echo "</table>";

	$mysql->fechar();

?>
 <form name='' action='fechar_sessao.php' method='POST'>
   <input type='submit'  name='sair' value='logout' >
</form>



</body>
</html>
