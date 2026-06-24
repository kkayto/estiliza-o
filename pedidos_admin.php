<?php
require_once('session_init.php');
session_start();
if ($_SESSION['log'] != "ativo" || $_SESSION['nivel'] != "adm") {
    echo "<script>alert('Acesso restrito ao administrador.'); window.location.href='index.php';</script>";
    exit;
}
require_once('conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

$filtro_usuario = isset($_GET['usuario']) ? trim($_GET['usuario']) : '';
$filtro_produto = isset($_GET['produto']) ? trim($_GET['produto']) : '';

$where = [];
if ($filtro_usuario !== '') {
    $fu = addslashes($filtro_usuario);
    $where[] = "u.nome LIKE '%$fu%'";
}
if ($filtro_produto !== '') {
    $fp = addslashes($filtro_produto);
    $where[] = "pr.nome LIKE '%$fp%'";
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$query = $mysql->query("
    SELECT p.id, u.nome AS usuario, pr.nome AS produto, pr.tipo,
           p.quantidade, p.observacao, p.data_pedido
    FROM tbpedido p
    JOIN tbproduto pr ON pr.id = p.id_produto
    JOIN tbusuario u  ON u.id  = p.id_usuario
    $where_sql
    ORDER BY p.data_pedido DESC
");

$pedidos = [];
while ($row = $query->fetchArray()) {
    $pedidos[] = $row;
}
$mysql->fechar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Pedidos (Admin)</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Montserrat', sans-serif;
    min-height: 100vh;
    padding: 1.5rem;
    background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #ea80fc 100%);
  }

  .blob {
    position: fixed; width: 380px; height: 380px;
    border-radius: 50%; filter: blur(80px); opacity: .4;
    pointer-events: none; z-index: 0;
  }
  .blob-top    { top: -10%; left: -10%; background: #ff80ab; mix-blend-mode: multiply; }
  .blob-bottom { bottom: -10%; right: -10%; background: #d500f9; mix-blend-mode: multiply; }

  .container { position: relative; z-index: 1; max-width: 1000px; margin: 0 auto; }

  .top-bar {
    display: flex; justify-content: space-between;
    align-items: center; flex-wrap: wrap;
    gap: .75rem; margin-bottom: 1.25rem;
  }

  .brand { display: flex; align-items: center; gap: .75rem; }

  .icon-wrap {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.6);
    box-shadow: 0 6px 18px rgba(240,98,146,.3);
    overflow: hidden; flex-shrink: 0;
  }
  .icon-wrap img { width: 100%; height: 100%; object-fit: cover; }

  .page-title { font-size: 1.4rem; font-weight: 800; color: #613e9b; }
  .page-sub   { font-size: .8rem; color: #8a6bb5; }

  .card {
    background: rgba(255,255,255,.45);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,.4);
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 8px 32px rgba(31,38,135,.13);
    margin-bottom: 1rem;
  }

  .btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .55rem 1.1rem;
    font-family: 'Montserrat', sans-serif;
    font-size: .82rem; font-weight: 700;
    border: none; border-radius: 10px;
    cursor: pointer; text-decoration: none;
    transition: transform .15s;
  }
  .btn:hover { transform: scale(1.03); }
  .btn-primary   { color: #fff; background: linear-gradient(to right,#9c27b0,#e91e63); box-shadow: 0 4px 12px rgba(233,30,99,.3); }
  .btn-secondary { color: #613e9b; background: rgba(255,255,255,.65); border: 1.5px solid rgba(97,62,155,.25); }
  .btn-danger    { color: #e91e63; background: rgba(255,255,255,.5); border: 1.5px solid rgba(233,30,99,.25); }

  .filter-row {
    display: flex; gap: .65rem; flex-wrap: wrap; align-items: flex-end;
  }
  .filter-group { display: flex; flex-direction: column; gap: .3rem; flex: 1; min-width: 160px; }
  .filter-group label { font-size: .75rem; font-weight: 700; color: #613e9b; }
  .filter-group input {
    padding: .6rem .9rem;
    font-family: 'Montserrat', sans-serif; font-size: .85rem; color: #613e9b;
    background: rgba(255,255,255,.7); border: 1px solid rgba(255,255,255,.5);
    border-radius: 10px; outline: none;
  }
  .filter-group input:focus { border-color: #ce93d8; box-shadow: 0 0 0 3px rgba(206,147,216,.25); }

  .section-title {
    font-size: .95rem; font-weight: 800; color: #613e9b;
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: .4rem;
  }

  .stats-row {
    display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1rem;
  }
  .stat-chip {
    background: rgba(255,255,255,.6);
    border-radius: 12px; padding: .5rem .9rem;
    font-size: .78rem; font-weight: 700; color: #613e9b;
    border: 1px solid rgba(255,255,255,.5);
  }
  .stat-chip span { color: #9c27b0; font-size: 1rem; margin-right: .25rem; }

  table { width: 100%; border-collapse: collapse; }
  thead th {
    text-align: left; font-size: .75rem; font-weight: 700;
    color: #8a6bb5; text-transform: uppercase; letter-spacing: .5px;
    padding: .5rem .75rem; border-bottom: 1.5px solid rgba(97,62,155,.12);
  }
  tbody tr { transition: background .15s; }
  tbody tr:hover { background: rgba(255,255,255,.35); }
  tbody td {
    padding: .75rem .75rem; font-size: .83rem; color: #4a3570;
    border-bottom: 1px solid rgba(97,62,155,.07);
    vertical-align: middle;
  }
  tbody tr:last-child td { border-bottom: none; }

  .badge-usuario {
    display: inline-block; font-size: .72rem; font-weight: 600;
    background: rgba(156,39,176,.12); color: #7b1fa2;
    border-radius: 20px; padding: .15rem .65rem;
  }
  .badge-tipo {
    display: inline-block; font-size: .72rem; font-weight: 600;
    background: rgba(233,30,99,.1); color: #c2185b;
    border-radius: 20px; padding: .15rem .65rem;
  }
  .qty-badge {
    display: inline-block; font-weight: 800; color: #613e9b;
    font-size: .9rem;
  }
  .obs-text { font-style: italic; color: #8a6bb5; font-size: .78rem; }

  .empty {
    text-align: center; color: #8a6bb5;
    padding: 2.5rem; font-size: .9rem;
  }
  .empty-icon { font-size: 2.5rem; margin-bottom: .5rem; }

  @media (max-width: 640px) {
    table, thead, tbody, tr, th, td { display: block; }
    thead { display: none; }
    tbody td { padding: .4rem .75rem; }
    tbody td::before {
      content: attr(data-label) ': ';
      font-weight: 700; color: #613e9b; font-size: .72rem;
    }
    tbody tr {
      background: rgba(255,255,255,.45); border-radius: 12px;
      margin-bottom: .6rem; padding: .5rem;
    }
  }
</style>
</head>
<body>
<div class="blob blob-top"></div>
<div class="blob blob-bottom"></div>
<div class="container">

  <div class="top-bar">
    <div class="brand">
      <div class="icon-wrap"><img src="logo.png" alt="Logo"></div>
      <div>
        <div class="page-title">Pedidos — Admin</div>
        <div class="page-sub">Todos os pedidos da loja</div>
      </div>
    </div>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
      <a href="pesquisa.php" class="btn btn-secondary"><i class="fa-solid fa-boxes-stacked"></i> Produtos</a>
      <form action="fechar_sessao.php" method="POST" style="margin:0">
        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
      </form>
    </div>
  </div>

  <div class="card">
    <form method="GET">
      <div class="filter-row">
        <div class="filter-group">
          <label for="usuario"><i class="fa-solid fa-user"></i> Filtrar por cliente</label>
          <input type="text" id="usuario" name="usuario"
                 placeholder="Nome do cliente..."
                 value="<?php echo htmlspecialchars($filtro_usuario); ?>">
        </div>
        <div class="filter-group">
          <label for="produto"><i class="fa-solid fa-candy-cane"></i> Filtrar por produto</label>
          <input type="text" id="produto" name="produto"
                 placeholder="Nome do produto..."
                 value="<?php echo htmlspecialchars($filtro_produto); ?>">
        </div>
        <div style="display:flex;gap:.5rem;align-items:flex-end;">
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Filtrar</button>
          <a href="pedidos_admin.php" class="btn btn-secondary">Limpar</a>
        </div>
      </div>
    </form>
  </div>

  <div class="card">
    <?php if (empty($pedidos)): ?>
      <div class="empty">
        <div class="empty-icon">📋</div>
        <div>Nenhum pedido encontrado.</div>
      </div>
    <?php else:
      $total_qtd = array_sum(array_column($pedidos, 'quantidade'));
      $usuarios_unicos = count(array_unique(array_column($pedidos, 'usuario')));
    ?>
      <div class="stats-row">
        <div class="stat-chip"><span><?php echo count($pedidos); ?></span> pedidos</div>
        <div class="stat-chip"><span><?php echo $total_qtd; ?></span> itens</div>
        <div class="stat-chip"><span><?php echo $usuarios_unicos; ?></span> clientes</div>
      </div>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Qtd</th>
            <th>Observação</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pedidos as $p):
            $data_fmt = date('d/m/Y H:i', strtotime($p['data_pedido']));
          ?>
          <tr>
            <td data-label="#"><?php echo $p['id']; ?></td>
            <td data-label="Cliente"><span class="badge-usuario">👤 <?php echo htmlspecialchars($p['usuario']); ?></span></td>
            <td data-label="Produto"><strong><?php echo htmlspecialchars($p['produto']); ?></strong></td>
            <td data-label="Tipo"><span class="badge-tipo"><?php echo htmlspecialchars($p['tipo']); ?></span></td>
            <td data-label="Qtd"><span class="qty-badge"><?php echo $p['quantidade']; ?></span></td>
            <td data-label="Observação">
              <?php if ($p['observacao']): ?>
                <span class="obs-text">📝 <?php echo htmlspecialchars($p['observacao']); ?></span>
              <?php else: ?>
                <span style="color:#bbb;font-size:.75rem;">—</span>
              <?php endif; ?>
            </td>
            <td data-label="Data" style="white-space:nowrap;font-size:.75rem;color:#8a6bb5">
              <i class="fa-regular fa-clock"></i> <?php echo $data_fmt; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
