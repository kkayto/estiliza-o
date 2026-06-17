<body>
<h3><center><font color="red" size=5> Alteração do tipo</h3> </center>  </font>

<form name="status" action="" method="POST">
         <p><b> STATUS: </b>
         <select name="fstatus">
         <option value="liberado"> Liberado </option>
         <option value="bloqueado"> Bloqueado</option>
         <option value="verificar"> Verificar</option>
          <option value="banido"> Banido </option>

         </select>
	<br><p>		<input type="submit" name="bstatus" value="alterar">
</form>



</body>
</html>


<?php
if(isset($_POST["bstatus"])) {
	if(isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))){
			$id = base64_decode($_GET['id']);
	} else {
		header('Location: cadastro.php');
	}
        require_once('conexao/conexao.php');

    	$mysql = new BancodeDados();
	   $mysql->conecta();
	   $pstatus=$_POST['fstatus'];


			$sqlstring = "update tbproduto  set status='$pstatus' where id=$id ";

               		$query = @mysqli_query($mysql->con, $sqlstring);
          		if($query){

				echo"<script language='javascript' type='text/javascript'>alert('Alterou com sucesso !');window.location.href='cadastro.php'</script>";
      			  }else{
         			 echo"<script language='javascript' type='text/javascript'>alert('Não foi possível alterar o tipo');window.location.href='cadastro.php'</script>";

		}

$mysql->fechar();
}
?>
