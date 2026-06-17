<!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como Uploadphp.php -->
<html>
<head>
<title> UPLOAD IMAGENS </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<BODY BGCOLOR="#DEDDDE">
<font face="caviar dreams">
<h1> Subindo uma imagem para o servidor </h1>
<?php
session_start();
echo "Logado : ".$_SESSION['nome'];
if (($_SESSION['log'] == "ativo") &&($_SESSION['nivel'] == "adm")) {
 echo"<br/> <br/> ";
echo"<form method='post' enctype='multipart/form-data' action='Upload.php'> ";
echo"<h3>Selecione uma imagem: </h3>   <input name='arquivo'  type='file'  /> ";
echo"<br/> <br/>  <input type='submit' value='Salvar' />  ";
echo"</form>";
}
else {
echo"<script language='javascript' type='text/javascript'>
alert('Voce não tem acesso permitido');
window.location.href='cadastro.php';</script>";
}
?>

</BODY>
</HTML>
