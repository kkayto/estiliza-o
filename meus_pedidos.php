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

$id_usuario = (int) $_SESSION['id'];
$query = $mysql->query("
    SELECT p.id, pr.nome AS produto, pr.tipo, p.quantidade, p.observacao, p.data_pedido
    FROM tbpedido p
    JOIN tbproduto pr ON pr.id = p.id_produto
    WHERE p.id_usuario = $id_usuario
    ORDER BY p.data_pedido DESC
");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Meus Pedidos</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        min-height: 100vh;
        padding: 1.5rem;
        background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #ea80fc 100%);
    }

    .container {
        position: relative;
        z-index: 1;
        max-width: 860px;
        margin: 0 auto;
    }

    .topo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1.25rem;
    }

    .topo-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .icon-logo {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .6);
        box-shadow: 0 6px 18px rgba(240, 98, 146, .3);
        overflow: hidden;
        flex-shrink: 0;
    }

    .icon-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .page-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #613e9b;
    }

    .page-sub {
        font-size: .8rem;
        color: #8a6bb5;
    }

    .card {
        background: rgba(255, 255, 255, .45);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, .4);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(31, 38, 135, .13);
        margin-bottom: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.1rem;
        font-family: 'Montserrat', sans-serif;
        font-size: .82rem;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: transform .15s;
    }

    .btn:hover {
        transform: scale(1.03);
    }

    .btn-primary {
        color: #fff;
        background: linear-gradient(to right, #9c27b0, #e91e63);
        box-shadow: 0 4px 12px rgba(233, 30, 99, .3);
    }

    .btn-secondary {
        color: #613e9b;
        background: rgba(255, 255, 255, .65);
        border: 1.5px solid rgba(97, 62, 155, .25);
    }

    .btn-sair {
        color: #e91e63;
        background: rgba(255, 255, 255, .5);
        border: 1.5px solid rgba(233, 30, 99, .25);
    }

    .section-title {
        font-size: .95rem;
        font-weight: 800;
        color: #613e9b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .pedido-item {
        background: rgba(255, 255, 255, .6);
        border-radius: 14px;
        padding: 1rem 1.1rem;
        margin-bottom: .75rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
        border: 1px solid rgba(255, 255, 255, .5);
        transition: transform .15s;
    }

    .pedido-item:hover {
        transform: translateX(3px);
    }

    .pedido-item:last-child {
        margin-bottom: 0;
    }

    .pedido-info {
        flex: 1;
        min-width: 160px;
    }

    .pedido-nome {
        font-size: .95rem;
        font-weight: 700;
        color: #613e9b;
        margin-bottom: .2rem;
    }

    .pedido-tipo {
        font-size: .72rem;
        font-weight: 600;
        color: #9c27b0;
        background: rgba(156, 39, 176, .1);
        border-radius: 20px;
        padding: .15rem .65rem;
        display: inline-block;
        margin-bottom: .4rem;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .pedido-obs {
        font-size: .78rem;
        color: #6d5189;
        font-style: italic;
        margin-top: .3rem;
    }

    .pedido-right {
        text-align: right;
        flex-shrink: 0;
    }

    .pedido-qtd {
        font-size: 1.1rem;
        font-weight: 800;
        color: #613e9b;
    }

    .pedido-qtd span {
        font-size: .75rem;
        font-weight: 500;
        color: #8a6bb5;
    }

    .pedido-data {
        font-size: .72rem;
        color: #8a6bb5;
        margin-top: .25rem;
    }

    .empty {
        text-align: center;
        color: #8a6bb5;
        padding: 2.5rem;
        font-size: .9rem;
    }

    .empty-icon {
        font-size: 2.5rem;
        margin-bottom: .5rem;
    }

    .total-pedidos {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: .5rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(97, 62, 155, .12);
        margin-top: .75rem;
    }

    .total-label {
        font-size: .8rem;
        font-weight: 600;
        color: #8a6bb5;
    }

    .total-value {
        font-size: 1rem;
        font-weight: 800;
        color: #613e9b;
    }
  </style>
  </head>
<body>

<div class="container">

  <div class="topo">
    <div class="topo-left">
      <div class="icon-logo"><img src="logo.png" alt="Logo"></div>
      <div>
        <div class="page-title">Meus Pedidos</div>
        <div class="page-sub">Olá, <strong><?php echo htmlspecialchars($_SESSION['nome']); ?></strong>!</div>
      </div>
    </div>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
      <a href="principal.php" class="btn btn-secondary"><i class="fa-solid fa-store"></i> Voltar à loja</a>
      <form action="fechar_sessao.php" method="POST" style="margin:0">
        <button type="submit" class="btn btn-sair"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="section-title"><i class="fa-solid fa-bag-shopping"></i> Histórico de pedidos</div>

    <?php
    $pedidos = [];
    while ($row = $query->fetchArray()) {
        $pedidos[] = $row;
    }

    if (empty($pedidos)):
    ?>
      <div class="empty">
        <div class="empty-icon"><i class="fa-solid fa-store-slash"></i></div>
        <div>Você ainda não fez nenhum pedido.</div>
        <a href="principal.php" class="btn btn-primary" style="display:inline-flex;margin-top:1rem">
          <i class="fa-solid fa-store"></i> Ver produtos
        </a>
      </div>
    <?php else: ?>
      <?php
      $total_itens = 0;
      foreach ($pedidos as $p):
        $total_itens += $p['quantidade'];
        $data_fmt = date('d/m/Y H:i', strtotime($p['data_pedido']));
      ?>
      <div class="pedido-item">
        <div class="pedido-info">
          <div class="pedido-nome">🍬 <?php echo htmlspecialchars($p['produto']); ?></div>
          <span class="pedido-tipo"><?php echo htmlspecialchars($p['tipo']); ?></span>
          <?php if ($p['observacao']): ?>
            <div class="pedido-obs">📝 <?php echo htmlspecialchars($p['observacao']); ?></div>
          <?php endif; ?>
        </div>
        <div class="pedido-right">
          <div class="pedido-qtd"><?php echo $p['quantidade']; ?> <span>unid.</span></div>
          <div class="pedido-data"><i class="fa-regular fa-clock"></i> <?php echo $data_fmt; ?></div>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="total-pedidos">
        <span class="total-label">Total de pedidos: <strong><?php echo count($pedidos); ?></strong></span>
        <span class="total-value"><?php echo $total_itens; ?> itens no total</span>
      </div>
    <?php endif; ?>
  </div>

</div>
<?php $mysql->fechar(); ?>
</body>
</html>
