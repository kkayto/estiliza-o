<!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como mostrar_cadastro.php -->
<?php
session_start();
	if ($_SESSION['log'] == "ativo"){
     $pnome=$_POST['fnome'];
     $ptipo=$_POST['ftipo'];
     $pdescricao=$_POST['fdescricao'];
     $pidcad=$_SESSION['id'];
     if (empty($pnome) || empty($ptipo) || empty($pdescricao)){
       echo"<script language='javascript' type='text/javascript'>alert('Tem campo em branco');window.location.href='cadastro.php'</script>";
     }else {
     echo "<h2> mostrando o valores digitado no cadastro </h2>";
     echo "nome: ".$pnome. "<br/>";
	 echo "tipo: ".$ptipo. "<br/>";
	 echo"descrição: ".$pdescricao. "<br/>";
	 echo "cadastrado por : ".$_SESSION['nome'];
	 require_once('conexao/conexao.php');
    $mysql = new BancodeDados();
	$mysql->conecta();
	 $sqlstring = "insert into tbproduto(nome,tipo,descricao,id_cadastrou,status)
     values('$pnome','$ptipo','$pdescricao','$pidcad','verificar')" ;
	$query = @mysqli_query($mysql->con, $sqlstring);
	 if($query){

     echo"<script language='javascript' type='text/javascript'>alert('Cadastrado efetuado com sucesso!')</script>";
        }else{
          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar');window.location.href='cadastro.php'</script>";
        }

	$mysql->fechar();
     echo"   <form name='' action='pesquisa.php' method='POST'> ";
     echo "<input type='submit'  name='nova' value='Nova pesquisa' >";
     echo "</form>";
     echo"   <form name='' action='Uploadphp.php' method='POST'> ";
     echo "<input type='submit'  name='imagens' value='perfil' >";
     echo"</form>";
     echo"   <form name='' action='fechar_sessao.php' method='POST'> ";
     echo "<input type='submit'  name='sair' value='logout' >";
     echo"</form>";

}
}
else {
echo"<script language='javascript' type='text/javascript'>
alert('VocÃª nÃ£o estava logado, faÃ§a o login primeiro');
window.location.href='index.php';</script>";
}

?>
