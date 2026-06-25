<!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como mostrar_cadastro.php -->
<?php
require_once('session_init.php');
session_start();
if ($_SESSION['log'] != "ativo") {
    echo "<script>alert('Voce nao esta logado'); window.location.href='index.php';</script>";
    exit;
}
$pnome     = $_POST['fnome']      ?? '';
$ptipo     = $_POST['ftipo']      ?? '';
$pdescricao = $_POST['fdescricao'] ?? '';
$pidcad    = $_SESSION['id'];

if (empty($pnome) || empty($ptipo) || empty($pdescricao)) {
    echo "<script>alert('Tem campo em branco'); window.location.href='cadastro.php';</script>";
    exit;
}

require_once('conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();
$sqlstring = "insert into tbproduto(nome,tipo,descricao,id_cadastrou,status) values('$pnome','$ptipo','$pdescricao','$pidcad','verificar')";
$query = $mysql->query($sqlstring);
if ($query) {
    echo "<script>alert('Cadastro efetuado com sucesso!');</script>";
} else {
    echo "<script>alert('Nao foi possivel cadastrar'); window.location.href='cadastro.php';</script>";
}
$mysql->fechar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Moranguete Doces &mdash; Cadastrado</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    body {
        font-family: 'Montserrat', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #ea80fc 100%);
    }

    .card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 480px;
        background: rgba(255, 255, 255, .45);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, .4);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(31, 38, 135, .15);
        text-align: center;
    }

    .icon {
        font-size: 2.5rem;
        margin-bottom: .75rem;
    }

    h2 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #613e9b;
        margin-bottom: .4rem;
    }

    .detalhes-pedido {
        font-size: .85rem;
        color: #8a6bb5;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .btn {
        display: block;
        width: 100%;
        padding: .8rem;
        font-family: 'Montserrat', sans-serif;
        font-size: .9rem;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        text-decoration: none;
        margin-top: .5rem;
        transition: transform .15s;
    }

    .btn-primary {
        color: #fff;
        background: linear-gradient(to right, #9c27b0, #e91e63);
        box-shadow: 0 4px 12px rgba(233, 30, 99, .35);
    }

    .btn-secondary {
        color: #613e9b;
        background: rgba(255, 255, 255, .65);
        border: 1.5px solid rgba(97, 62, 155, .25);
    }

    .btn:hover {
        transform: scale(1.02);
    }
  </style>
  </head>
<body>

<div class="card">
  <div class="icon"><i class="fa-solid fa-cart-flatbed"></i></div>
  <h2>Produto cadastrado!</h2>
  <div class="detalhes-pedido">
    <strong><?php echo htmlspecialchars($pnome); ?></strong><br>
    Tipo: <?php echo htmlspecialchars($ptipo); ?><br>
    <?php echo htmlspecialchars($pdescricao); ?><br>
    Cadastrado por: <strong><?php echo $_SESSION['nome']; ?></strong>
  </div>
  <a href="pesquisa.php" class="btn btn-primary">Ver todos os produtos &rarr;</a>
  <a href="cadastro.php" class="btn btn-secondary"><i class="fa-solid fa-dolly"></i>  Cadastrar outro</a>
  <form action="fechar_sessao.php" method="POST" style="margin-top:.5rem">
    <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
  </form>
</div>
</body>
</html>
