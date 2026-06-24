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
    $sqlstring = "select * from tbproduto where tipo='$pbusca' and status='liberado'";
} else {
    $sqlstring = "select * from tbproduto where status='liberado' order by nome";
}
$query = $mysql->query($sqlstring);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Loja</title>
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
        
        .icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 24px rgba(240, 98, 146, 0.35);
            margin-bottom: 1rem;
            overflow: hidden;
        }


        .card-title {
          margin-top: 0.5rem;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        
        .icon-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-subtitle {
            margin-top: 0.4rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #8a6bb5;
        }

          .container {
              position: relative;
              z-index: 1;
              max-width: 900px;
              margin: 0 auto;
          }

        .card-header {
            display: flex;
            flex-direction: row;
            text-align: center;
            margin-top: 2rem;
            gap: 1rem;
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

          .btn-pedidos {
              color: #613e9b;
              background: rgba(255, 255, 255, .65);
              border: 1.5px solid rgba(97, 62, 155, .25);
              margin-left: 16.7rem;
          }
          
          .btn-pedidos:hover {
                transform: scale(1.03);
            }

          .btn-danger {
              color: #e91e63;
              background: rgba(255, 255, 255, .5);
              border: 1.5px solid rgba(233, 30, 99, .25);
          }

          .products-grid {
              display: grid;
              grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
              gap: 1rem;
          }

          .product-card {
              background: rgba(255, 255, 255, .6);
              border-radius: 16px;
              padding: 1.25rem;
              border: 1px solid rgba(255, 255, 255, .5);
              transition: transform .15s, box-shadow .15s;
          }

          .product-card:hover {
              transform: translateY(-3px);
              box-shadow: 0 12px 30px rgba(31, 38, 135, .15);
          }

          .product-name {
              font-size: .95rem;
              font-weight: 700;
              color: #613e9b;
              margin-bottom: .3rem;
          }

          .product-type {
              font-size: .75rem;
              color: #8a6bb5;
              margin-bottom: .5rem;
          }

          .product-desc {
              font-size: .8rem;
              color: #4a3570;
              margin-bottom: .75rem;
              line-height: 1.4;
          }

          .btn-buy {
              width: 100%;
              padding: .6rem;
              font-family: 'Montserrat', sans-serif;
              font-size: .85rem;
              font-weight: 700;
              color: #fff;
              background: linear-gradient(to right, #9c27b0, #e91e63);
              border: none;
              border-radius: 10px;
              cursor: pointer;
              text-decoration: none;
              display: block;
              text-align: center;
          }

          .btn-buy:hover {
              opacity: .9;
          }

          .top-bar {
              display: flex;
              justify-content: space-between;
              align-items: center;
              flex-wrap: wrap;
              gap: .5rem;
              margin-bottom: 1.25rem;
          }

          .empty {
              text-align: center;
              color: #8a6bb5;
              padding: 2rem;
              font-size: .9rem;
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
      <div class="icon-wrap"><img src="logo.png" alt="Moranguete Doces"></div>
      <h1 class="card-title">Moranguete Doces</h1></div
      <p class="sub">Bem-vindo, <strong><?php echo $_SESSION['nome']; ?></strong>! Escolha seus doces.</p>
    </div>
        <a href="meus_pedidos.php" class="btn btn-pedidos"><i class="fa-solid fa-bag-shopping"></i> Meus Pedidos</a>
    <form action="fechar_sessao.php" method="POST">
      <button type="submit" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
    </form>
  </div>

  <div class="card">
    <form action="" method="POST">
      <div class="search-row">
        <input type="text" name="textobusca" placeholder="Buscar por tipo (ex: alimento, bebida)..." value="<?php echo htmlspecialchars($_POST['textobusca'] ?? ''); ?>">
        <button type="submit" name="buscar" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
        <a href="principal.php" class="btn btn-secondary">Limpar</a>
      </div>
    </form>
  </div>

  <div class="products-grid">
    <?php
    $found = false;
    while ($dados = $query->fetchArray()):
      $found = true;
      $id = base64_encode($dados['id']);
    ?>
    <div class="product-card">
      <div class="product-name"><?php echo htmlspecialchars($dados['nome']); ?></div>
      <div class="product-type">&#127857; <?php echo htmlspecialchars($dados['tipo']); ?></div>
      <div class="product-desc"><?php echo htmlspecialchars($dados['descricao']); ?></div>
      <a href="comprar.php?id=<?php echo $id; ?>" class="btn-buy"><i class="fa-solid fa-basket-shopping"></i> Comprar</a>
    </div>
    <?php endwhile; ?>
    <?php if (!$found): ?>
    <div class="empty" style="grid-column:1/-1">Nenhum produto encontrado. &#128549;</div>
    <?php endif; ?>
  </div>
</div>
<?php $mysql->fechar(); ?>
</body>
</html>
