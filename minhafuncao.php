
<?php
session_start();
if ($_SESSION['log'] != "ativo"){
 echo"<script language='javascript' type='text/javascript'>
alert('Precisa esta logado para acessar o conteúdo');
window.location.href='../naoentrou.php';</script>";
}
function iniciar(){
if ($_SESSION['nivel']=="adm"){
   $fundo="black";
   $corletra="blue";
}else{
 $fundo="green";
 $corletra="black";
}
echo"<body bgcolor=$fundo text='$corletra'>";
}
function titulo(){
$nome= $_SESSION['nome'];
if ($_SESSION['nivel']=="adm"){
   $imagens="conexao/icone.jpg";

}else{
     $imagens="conexao/icone2.jpg";

}
echo "<img src='$imagens' width=10% height=10%>";
echo " <h1> <font color='RED'>$nome</h1></font>";
}


?>

