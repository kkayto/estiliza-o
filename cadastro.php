<!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como cadastro.php -->
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
require_once('conexao/minhafuncao.php');
iniciar();
titulo();
?>
<h3><center><font color="red" size=5> entrou teste sessão</h3> </center>  </font>
<?php
if ($_SESSION['log'] != "ativo"){
 echo"<script language='javascript' type='text/javascript'>
alert('Precisa esta logado para acessar o conteúdo');
window.location.href='../naoentrou.php';</script>";
}
echo "o usuario logado no momento é ";
echo $_SESSION['nome'];
 echo "<br> o nivel dele é ". $_SESSION['nivel']."\n \n";
?>
<h2>cadastro de uma pesquisa <h3>
<form name="cadastro" action="mostrar_cadastro.php" method="POST">
 <p><b>Nome: </b><u><b><font size=5><input type="text" name="fnome" ></font></u></b><br>
<p><b> tipo: </b>
         <select name="ftipo">
         <option value="alimento"> Alimento </option>
         <option value="limpeza"> Limpeza</option>
         <option value="bebida"> Bebida</option>
          <option value="diversos"> Diversos </option>
          </select>
<p><b>Descrição: </b><input type="text" name="fdescricao"><br>
<br><p>		<input type="submit"  name="cadastrar" value="cadastrar" >
</form>
<br>
  <form name='' action='pesquisa.php' method='POST'>
 <input type='submit'  name='nova' value='Nova pesquisa' >
 </form>
 <form name='' action='fechar_sessao.php' method='POST'>
   <input type='submit'  name='sair' value='logout' >
</form>
<br>  <br>
</body>
</html>

