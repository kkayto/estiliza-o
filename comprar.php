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

$id_produto = isset($_GET['id']) ? (int) base64_decode($_GET['id']) : 0;
if ($id_produto <= 0) {
    echo "<script>alert('Produto inválido.'); window.location.href='principal.php';</script>";
    exit;
}

$res = $mysql->query("SELECT * FROM tbproduto WHERE id=$id_produto AND status='liberado'");
$produto = $res->fetchArray();
if (!$produto) {
    echo "<script>alert('Produto não disponível.'); window.location.href='principal.php';</script>";
    exit;
}

$pedido_feito = false;
$erro = '';

if (isset($_POST['confirmar'])) {
    $quantidade  = max(1, (int) ($_POST['quantidade'] ?? 1));
    $observacao  = trim($_POST['observacao'] ?? '');
    $id_usuario  = (int) $_SESSION['id'];
    $obs_sql     = addslashes($observacao);

    $ins = $mysql->query("INSERT INTO tbpedido (id_produto, id_usuario, quantidade, observacao)
                          VALUES ($id_produto, $id_usuario, $quantidade, '$obs_sql')");
    if ($ins) {
        $pedido_feito = true;
    } else {
        $erro = 'Não foi possível registrar o pedido. Tente novamente.';
    }
}

$mysql->fechar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Comprar</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
    max-width: 460px;
    background: rgba(255,255,255,.45);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,.4);
    border-radius: 24px;
    padding: 2rem 2rem 1.5rem;
    box-shadow: 0 8px 32px rgba(31,38,135,.15);
    text-align: center;
  }

  .icon-logo {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 72px; height: 72px;
    border-radius: 50%;
    background: rgba(255,255,255,.6);
    box-shadow: 0 8px 24px rgba(240,98,146,.35);
    margin-bottom: 1rem;
    overflow: hidden;
  }
  .icon-logo img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
  }

  h2 {
    font-size: 1.3rem;
    font-weight: 800;
    color: #613e9b;
    margin-bottom: .25rem;
  }

  .product-tipo {
    display: inline-block;
    font-size: .72rem;
    font-weight: 600;
    color: #9c27b0;
    background: rgba(156,39,176,.1);
    border-radius: 20px;
    padding: .2rem .75rem;
    margin-bottom: .75rem;
    text-transform: uppercase;
    letter-spacing: .5px;
  }

  .produtos-desc {
    font-size: .85rem;
    color: #4a3570;
    line-height: 1.5;
    margin-bottom: 1.25rem;
    background: rgba(255,255,255,.5);
    border-radius: 12px;
    padding: .75rem 1rem;
  }

  .divider {
    border: none;
    border-top: 1px solid rgba(97,62,155,.12);
    margin: 1rem 0;
  }

  label {
    display: block;
    font-size: .8rem;
    font-weight: 700;
    color: #613e9b;
    text-align: left;
    margin-bottom: .35rem;
    margin-top: .85rem;
  }

  .qtd{
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .qtd-btn {
    width: 36px; height: 36px;
    border: none;
    border-radius: 10px;
    background: rgba(156,39,176,.12);
    color: #9c27b0;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .15s;
    flex-shrink: 0;
  }
  .qtd-btn:hover { background: rgba(156,39,176,.22); }

  input[type=number], textarea {
    width: 100%;
    font-family: 'Montserrat', sans-serif;
    font-size: .9rem;
    color: #613e9b;
    background: rgba(255,255,255,.7);
    border: 1px solid rgba(255,255,255,.5);
    border-radius: 12px;
    padding: .65rem 1rem;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
  }
  input[type=number]:focus, textarea:focus {
    border-color: #ce93d8;
    box-shadow: 0 0 0 3px rgba(206,147,216,.25);
  }
  input[type=number] {
    text-align: center;
    flex: 1;
    -moz-appearance: textfield;
  }
  input[type=number]::-webkit-inner-spin-button { display: none; }

  textarea { resize: none; height: 80px; margin-top: 0; }

  .btn {
    display: block;
    width: 100%;
    padding: .85rem;
    font-family: 'Montserrat', sans-serif;
    font-size: .95rem;
    font-weight: 700;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    margin-top: .6rem;
    transition: transform .15s, opacity .15s;
  }
  .btn:hover { transform: scale(1.02); }

  .btn-primary {
    color: #fff;
    background: linear-gradient(to right, #9c27b0, #e91e63);
    box-shadow: 0 4px 14px rgba(233,30,99,.35);
  }
  .btn-secondary {
    color: #613e9b;
    background: rgba(255,255,255,.65);
    border: 1.5px solid rgba(97,62,155,.25);
  }


  .success-icon { font-size: 3rem; margin-bottom: .5rem; }
  .success-title { font-size: 1.4rem; font-weight: 800; color: #613e9b; margin-bottom: .4rem; }
  .success-sub { font-size: .85rem; color: #8a6bb5; margin-bottom: 1.25rem; line-height: 1.5; }

  .error-msg {
    background: rgba(233,30,99,.1);
    border: 1px solid rgba(233,30,99,.25);
    color: #c62828;
    border-radius: 10px;
    padding: .6rem 1rem;
    font-size: .82rem;
    margin-bottom: .75rem;
  }
</style>
</head>
<body>

<div class="card">

<?php if ($pedido_feito): ?>

  <div class="success-icon">🎉</div>
  <div class="success-title">Pedido registrado!</div>
  <div class="success-sub">
    Seu pedido de <strong><?php echo htmlspecialchars($produto['nome']); ?></strong>
    foi enviado com sucesso.<br>Em breve entraremos em contato!
  </div>
  <a href="principal.php" class="btn btn-primary"><i class="fa-solid fa-store"></i> Voltar à loja</a>

<?php else: ?>

  <div class="icon-logo"><img src="logo.png" alt="Moranguete Doces"></div>
  <h2><?php echo htmlspecialchars($produto['nome']); ?></h2>
  <span class="produtos-tipo"><?php echo htmlspecialchars($produto['tipo']); ?></span>
  <div class="produtos-desc"><?php echo htmlspecialchars($produto['descricao']); ?></div>

  <hr class="divider">

  <?php if ($erro): ?>
    <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $erro; ?></div>
  <?php endif; ?>

  <form method="POST">
    <label for="quantidade">Quantidade</label>
    <div class="qtd">
      <button type="button" class="qtd-btn" onclick="changeQty(-1)">−</button>
      <input type="number" id="quantidade" name="quantidade" value="1" min="1" max="99">
      <button type="button" class="qtd-btn" onclick="changeQty(1)">+</button>
    </div>

    <label for="observacao">Observação <span style="font-weight:400;color:#8a6bb5">(opcional)</span></label>
    <textarea id="observacao" name="observacao" placeholder="Ex: sem açúcar, embalagem especial..."></textarea>

    <button type="submit" name="confirmar" class="btn btn-primary" style="margin-top:1.1rem">
      <i class="fa-solid fa-basket-shopping"></i> Confirmar pedido
    </button>
  </form>

  <a href="principal.php" class="btn btn-secondary">← Voltar à loja</a>

<?php endif; ?>

</div>

<script>
function changeQty(delta) {
  const input = document.getElementById('quantidade');
  const newVal = Math.max(1, Math.min(99, parseInt(input.value || 1) + delta));
  input.value = newVal;
}
</script>
</body>
</html>
