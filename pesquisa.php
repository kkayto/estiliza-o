<?php
require_once('session_init.php');
session_start();
if ($_SESSION['log'] != "ativo") {
    echo "<script>alert('Precisa estar logado'); window.location.href='index.php';</script>";
    exit;
}
require_once('conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();
if (isset($_POST['buscar']) && !empty($_POST['textobusca'])) {
    $pbusca = $_POST['textobusca'];
    $sqlstring = "select * from tbproduto where tipo='$pbusca'";
} else {
    $sqlstring = 'select * from tbproduto order by nome';
}
$query = $mysql->query($sqlstring);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Produtos</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    body {
        font-family: 'Montserrat', sans-serif;
        min-height: 100vh;
        padding: 1.5rem;
        background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #ea80fc 100%);
    }

    .blob {
        position: fixed;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        filter: blur(80px);
        opacity: .4;
        pointer-events: none;
        z-index: 0;
    }

    .blob-top {
        top: -10%;
        left: -10%;
        background: #ff80ab;
        mix-blend-mode: multiply;
    }

    .blob-bottom {
        bottom: -10%;
        right: -10%;
        background: #d500f9;
        mix-blend-mode: multiply;
    }

    .container {
        position: relative;
        z-index: 1;
        max-width: 960px;
        margin: 0 auto;
    }

    .card-header {
        display: flex;
        flex-direction: row;
        text-align: center;
        margin-top: 2rem;
        gap: 1rem;
    }
    
    .icon-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 24px rgba(240, 98, 146, 0.35);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .icon-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card {
        background: rgba(255, 255, 255, .45);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, .4);
        border-radius: 24px;
        padding: 1.5rem 2rem;
        box-shadow: 0 8px 32px rgba(31, 38, 135, .15);
        margin-bottom: 1.25rem;
    }
    
    .card-title {
       margin-top: 0.8rem;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    h1.page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #613e9b;
        margin-bottom: .25rem;
    }

    .sub {
        font-size: .85rem;
        color: #8a6bb5;
    }

    .search-row {
        display: flex;
        gap: .75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-row input[type=text] {
        flex: 1;
        min-width: 160px;
        padding: .65rem 1rem;
        font-family: 'Montserrat', sans-serif;
        font-size: .9rem;
        color: #613e9b;
        background: rgba(255, 255, 255, .7);
        border: 1px solid rgba(255, 255, 255, .5);
        border-radius: 12px;
        outline: none;
    }

    .search-row input[type=text]:focus {
        border-color: #ce93d8;
        box-shadow: 0 0 0 3px rgba(206, 147, 216, .25);
    }

    .btn {
        padding: .6rem 1.2rem;
        font-family: 'Montserrat', sans-serif;
        font-size: .85rem;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: transform .15s;
    }

    .btn-primary {
        color: #fff;
        background: linear-gradient(to right, #9c27b0, #e91e63);
        box-shadow: 0 4px 12px rgba(233, 30, 99, .35);
    }

    .btn-primary:hover {
        transform: scale(1.03);
    }

    .btn-secondary {
        color: #613e9b;
        background: rgba(255, 255, 255, .65);
        border: 1.5px solid rgba(97, 62, 155, .25);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, .9);
    }

    .btn-danger {
        color: #e91e63;
        background: rgba(255, 255, 255, .5);
        border: 1.5px solid rgba(233, 30, 99, .25);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: .85rem;
    }

    th {
        text-align: left;
        padding: .6rem .75rem;
        color: #613e9b;
        font-weight: 700;
        border-bottom: 2px solid rgba(97, 62, 155, .15);
    }

    td {
        padding: .6rem .75rem;
        color: #4a3570;
        border-bottom: 1px solid rgba(97, 62, 155, .08);
    }

    tr:hover td {
        background: rgba(255, 255, 255, .4);
    }

    .badge {
        display: inline-block;
        padding: .2rem .6rem;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
    }

    .badge-liberado {
        background: #e8f5e9;
        color: #388e3c;
    }

    .badge-verificar {
        background: #fff8e1;
        color: #f57f17;
    }

    .badge-bloqueado {
        background: #fce4ec;
        color: #c62828;
    }

    .badge-banido {
        background: #f3e5f5;
        color: #6a1b9a;
    }

    a.action {
        font-size: 1.1rem;
        text-decoration: none;
        padding: .2rem .4rem;
        border-radius: 6px;
    }

    a.action:hover {
        background: rgba(255, 255, 255, .6);
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: .5rem;
        margin-bottom: 1.25rem;
    }
  </style>
  </head>
<body>
<div class="blob blob-top"></div>
<div class="blob blob-bottom"></div>
<div class="container">
  <div class="top-bar">
    <div>
      <div class="card-header">
        <div class="icon-wrap"><img src="logo.png" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"></div>
        <h1 class="card-title">Cadastro de Produto</h1>
        </div>
      <p class="sub">Ol&#225;, <strong><?php echo $_SESSION['nome']; ?></strong> &mdash; Lista de produtos</p>
    </div>
    <div style="display:flex;gap:.5rem;">
      <form action="cadastro.php" method="POST">
        <button type="submit" class="btn btn-primary">+ Novo produto</button>
      </form>
      <form action="fechar_sessao.php" method="POST">
        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
      </form>
    </div>
  </div>

  <div class="card">
    <form action="" method="POST">
      <div class="search-row">
        <input type="text" name="textobusca" placeholder="Buscar por tipo (ex: alimento)..." value="<?php echo htmlspecialchars($_POST['textobusca'] ?? ''); ?>">
        <button type="submit" name="buscar" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
        <a href="pesquisa.php" class="btn btn-secondary">Limpar</a>
      </div>
    </form>
  </div>

  <div class="card">
    <table>
      <tr>
        <th>#</th><th>Nome</th><th>Tipo</th><th>Descri&#231;&#227;o</th><th>Status</th>
        <th>Excluir</th><th>Tipo</th><th>Status</th>
      </tr>
      <?php while ($dados = $query->fetchArray()): ?>
        <?php
          $statusClass = match($dados['status']) {
            'liberado' => 'badge-liberado',
            'bloqueado' => 'badge-bloqueado',
            'banido' => 'badge-banido',
            default => 'badge-verificar'
          };
          $statusLabel = match($dados['status']) {
            'liberado'  => 'Em estoque',
            'bloqueado' => 'Em falta',
            'banido'    => 'Não vendemos mais',
            'verificar' => 'Verificar',
            default     => $dados['status']
          };
          $id = base64_encode($dados['id']);
        ?>
      <tr>
        <td><?php echo $dados['id']; ?></td>
        <td><strong><?php echo htmlspecialchars($dados['nome']); ?></strong></td>
        <td><?php echo htmlspecialchars($dados['tipo']); ?></td>
        <td><?php echo htmlspecialchars($dados['descricao']); ?></td>
        <td><span class="badge <?php echo $statusClass; ?>"><?php echo $statusLabel; ?></span></td>
        <td><a class="action" href="apagar.php?id=<?php echo $dados['id']; ?>" title="Excluir"><i class="fa-solid fa-trash-can"></i></a></td>
        <td><a class="action" href="alteratipo.php?id=<?php echo $id; ?>" title="Alterar tipo"><i class="fa-solid fa-pen-to-square"></i></a></td>
        <td><a class="action" href="alterastatus.php?id=<?php echo $id; ?>" title="Alterar status"><i class="fa-solid fa-chart-simple"></i></a></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
<?php $mysql->fechar(); ?>
</body>
</html>
