<!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como cadastro.php -->
<?php
require_once('session_init.php');
session_start();
if ($_SESSION['log'] != "ativo") {
    echo "<script>alert('Precisa estar logado'); window.location.href='naoentrou.php';</script>";
    exit;
}
$nome_usuario = $_SESSION['nome'];
$nivel_usuario = $_SESSION['nivel'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Cadastro</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #ea80fc 100%);
            position: relative;
            overflow: hidden;
        }

        .card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        .card-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .icon-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 24px rgba(240, 98, 146, 0.35);
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .icon-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #613e9b;
        }

        .user-info {
            margin-top: 0.5rem;
            font-size: 0.82rem;
            color: #8a6bb5;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            display: inline-block;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #613e9b;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(97, 62, 155, 0.15);
        }

        .campos-input {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1rem;
        }

        label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #613e9b;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            color: #613e9b;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            -webkit-appearance: none;
            appearance: none;
        }

        input[type="text"]::placeholder {
            color: #b39ddb;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #ce93d8;
            box-shadow: 0 0 0 3px rgba(206, 147, 216, 0.25);
        }

        .select-wrap {
            position: relative;
        }

        .select-wrap::after {
            content: '\25BE';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #a78bfa;
            pointer-events: none;
        }

        .btn-primary {
            width: 100%;
            padding: 0.85rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(to right, #9c27b0, #e91e63);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 15px 0 rgba(233, 30, 99, 0.4);
            transition: transform 0.15s, box-shadow 0.15s;
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.5);
        }

        .btn-primary:active {
            transform: scale(0.97);
        }

        .btn-secondary {
            width: 100%;
            padding: 0.75rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #613e9b;
            background: rgba(255, 255, 255, 0.6);
            border: 1.5px solid rgba(97, 62, 155, 0.25);
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 0.2rem;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.85);
        }

        .btn-sair {
            width: 100%;
            padding: 0.75rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #e91e63;
            background: rgba(255, 255, 255, 0.4);
            border: 1.5px solid rgba(233, 30, 99, 0.25);
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }

        .btn-sair:hover {
            background: rgba(255, 255, 255, 0.7);
        }

        .divider {
            border: none;
            border-top: 1px solid rgba(97, 62, 155, 0.1);
            margin: 1.0rem 0;
        }

        .card-footer {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.78rem;
            color: #8a6bb5;
        }


          .btn-pedidos {
              color: #f1f1f1;
              background: rgba(255, 255, 255, .65);
              border: 1.5px solid rgba(97, 62, 155, .25);
              background: linear-gradient(to right, #9c27b0, #e91e63);
              border: 1.5px solid rgba(97, 62, 155, 0.25);
          }
        
          .btn {
            display: block;
            width: 100%;
            padding: .85rem;
            font-family: 'Montserrat', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            margin-top: .6rem;
            transition: transform .15s, opacity .15s;
          }

          .btn-pedidos:hover {
                transform: scale(1.03);
            }
    </style>
    </head>
<body>

<div class="card">
    <div class="card-header">
        <div class="icon-logo"><img src="logo.png" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"></div>
        <h1 class="card-title">Cadastro de Produto</h1>
        <p class="user-info">&#128075; Ola, <strong><?php echo $nome_usuario; ?></strong> &nbsp;|&nbsp; Nivel: <?php echo $nivel_usuario; ?></p>
    </div>

    <p class="section-title"><i class="fa-solid fa-dolly"></i> Novo produto</p>

    <form name="cadastro" action="mostrar_cadastro.php" method="POST">
        <div class="campos-input">
            <label for="fnome">Nome do produto</label>
            <input type="text" id="fnome" name="fnome" placeholder="Ex: Trufa de morango" required>
        </div>

        <div class="campos-input">
            <label for="ftipo">Categoria</label>
            <div class="select-wrap">
                <select id="ftipo" name="ftipo">
                    <option value="alimento">&#127852; Alimento</option>
                    <option value="bebida">&#129380; Bebida</option>
                </select>
            </div>
        </div>

        <div class="campos-input">
            <label for="fdescricao">Descricao</label>
            <input type="text" id="fdescricao" name="fdescricao" placeholder="Ex: Trufa recheada com morango fresco">
        </div>

        <button type="submit" name="cadastrar" class="btn-primary">Cadastrar produto &rarr;</button>
    </form>

    <hr class="divider">

    <form name="" action="pesquisa.php" method="POST">
        <button type="submit" name="nova" class="btn-secondary"><i class="fa-solid fa-magnifying-glass"></i>  Nova pesquisa</button>
    </form>

    <form name="" action="fechar_sessao.php" method="POST">
        <button type="submit" name="sair" class="btn-sair"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
    </form>

    <a href="pedidos_admin.php" class="btn btn-pedidos"><i class="fa-solid fa-cart-shopping"></i> Pedidos</a>
</div>

</body>
</html>


