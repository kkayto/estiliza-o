<?php

class BancodeDados {

    private $host = "localhost:3308";
    private $user = "root";
    private $senha = "";
    private $banco = "testeaula";

    public $con;

    // Conectar ao banco
    public function conecta() {

        $this->con = mysqli_connect(
            $this->host,
            $this->user,
            $this->senha,
            $this->banco
        );

        if (!$this->con) {
            die("Erro na conexão: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->con, "utf8");
    }

    // Executa qualquer SQL
    public function query($sql) {
        return mysqli_query($this->con, $sql);
    }

    // Fecha a conexão
    public function fechar() {
        mysqli_close($this->con);
    }
}

?>
