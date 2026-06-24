<?php
class ResultWrapper {
    private $rows = [];
    private $index = 0;
    public $num_rows = 0;

    public function __construct(array $rows, $num_rows = null) {
        $this->rows = $rows;
        $this->num_rows = ($num_rows !== null) ? $num_rows : count($rows);
    }

    public function fetchArray() {
        if ($this->index < count($this->rows)) {
            return $this->rows[$this->index++];
        }
        return false;
    }
}

class BancodeDados {
    private $dbFile;
    private $pdo;
    public $con;

    public function __construct() {
        $this->dbFile = __DIR__ . '/banco.sqlite';
    }

    public function conecta() {
        $isNew = !file_exists($this->dbFile);
        $this->pdo = new PDO('sqlite:' . $this->dbFile);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($isNew) {
            $this->criarTabelas();
            $this->popularDados();
        }
        $this->criarTabelasPedido();
    }

    private function criarTabelasPedido() {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS tbpedido (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                id_produto INTEGER NOT NULL,
                id_usuario INTEGER NOT NULL,
                quantidade INTEGER NOT NULL DEFAULT 1,
                observacao TEXT,
                data_pedido TEXT DEFAULT (datetime('now','localtime'))
            );
        ");
    }

    private function criarTabelas() {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS tbusuario (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                login TEXT NOT NULL UNIQUE,
                senha TEXT NOT NULL,
                nivel TEXT NOT NULL DEFAULT 'user'
            );
            CREATE TABLE IF NOT EXISTS tbproduto (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                tipo TEXT NOT NULL,
                descricao TEXT,
                id_cadastrou INTEGER,
                status TEXT DEFAULT 'verificar'
            );
        ");
    }

    private function popularDados() {
        $this->pdo->exec("
            INSERT INTO tbusuario (nome, login, senha, nivel)
            VALUES ('Administrador', 'admin', '1234', 'adm');
            INSERT INTO tbusuario (nome, login, senha, nivel)
            VALUES ('Usuario Teste', 'user', '1234', 'user');
            INSERT INTO tbproduto (nome, tipo, descricao, id_cadastrou, status)
            VALUES ('Trufa de Morango', 'alimento', 'Trufa artesanal recheada com morango', 1, 'liberado');
            INSERT INTO tbproduto (nome, tipo, descricao, id_cadastrou, status)
            VALUES ('Brigadeiro Gourmet', 'alimento', 'Brigadeiro com granulado belga', 1, 'liberado');
            INSERT INTO tbproduto (nome, tipo, descricao, id_cadastrou, status)
            VALUES ('Suco de Fruta', 'bebida', 'Suco natural gelado', 1, 'liberado');
        ");
    }

    // Works for SELECT and also INSERT/UPDATE/DELETE
    public function query($sql) {
        try {
            $upper = strtoupper(ltrim($sql));
            if (strpos($upper, 'SELECT') === 0) {
                $stmt = $this->pdo->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return new ResultWrapper($rows);
            } else {
                $affected = $this->pdo->exec($sql);
                // Return truthy ResultWrapper on success, false on failure
                return new ResultWrapper([], 1);
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function fechar() {
        $this->pdo = null;
    }
}
