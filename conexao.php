<?php
class BancodeDados {
    // Nas linhas abaixo você poderá colocar as informações do Banco de Dados.
    private $host = "localhost:3308";
   // private $host = "localhost"; 	// Nome ou IP do Servidor
    private $user = "root"; 		// Usuário do Servidor MySQL
    private $senha = ""; 		// Senha do Usuário MySQL
    private $banco = "testeaula"; 		// Nome do seu Banco de Dados
    public $con;

	// método responsável para conexão a base de dados
	function conecta(){
        $this->con = mysqli_connect($this->host,$this->user,$this->senha, $this->banco);
       //   $this->con = @mysqli_connect($this->host,$this->user,$this->senha, $this->banco);
        // Conecta ao Banco de Dados
        if(!$this->con){
      		// Caso ocorra um erro, exibe uma mensagem com o erro
			die ("Problemas com a conex&atildeo");
        }
    }

	// método responsável para fechar a conexão
	function fechar(){
		mysqli_close($this->con);
		return;
	}


}


?>
