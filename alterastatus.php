<?php
require_once('session_init.php');
session_start();
if ($_SESSION['log'] != "ativo") {
    echo "<script>alert('Precisa estar logado'); window.location.href='index.php';</script>";
    exit;
}

if (isset($_POST["bstatus"])) {
    if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
        $id = base64_decode($_GET['id']);
    } else {
        header('Location: pesquisa.php'); exit;
    }
    require_once('conexao.php');
    $mysql = new BancodeDados();
    $mysql->conecta();
    $pstatus = $_POST['fstatus'];
    $query = $mysql->query("update tbproduto set status='$pstatus' where id=$id");
    if ($query) {
        echo "<script>alert('Status alterado com sucesso!'); window.location.href='pesquisa.php';</script>";
    } else {
        echo "<script>alert('Nao foi possivel alterar'); window.location.href='pesquisa.php';</script>";
    }
    $mysql->fechar();
}
$id_param = $_GET['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Moranguete Doces &mdash; Alterar Status</title>
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

        .blob {
            position: fixed;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .45;
            pointer-events: none;
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

        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, .45);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, .15);
        }

        .icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 20px rgba(240, 98, 146, .35);
            margin-bottom: .75rem;
            overflow: hidden;
        }

        .icon-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h2 {
            font-size: 1.2rem;
            font-weight: 800;
            color: #613e9b;
            margin-bottom: 1.25rem;
        }

        label {
            font-size: .85rem;
            font-weight: 600;
            color: #613e9b;
            display: block;
            margin-bottom: .4rem;
        }

        select {
            width: 100%;
            padding: .75rem 1rem;
            font-family: 'Montserrat', sans-serif;
            font-size: .9rem;
            color: #613e9b;
            background: rgba(255, 255, 255, .7);
            border: 1px solid rgba(255, 255, 255, .5);
            border-radius: 12px;
            outline: none;
            -webkit-appearance: none;
            appearance: none;
            margin-bottom: 1rem;
        }

        select:focus {
            border-color: #ce93d8;
            box-shadow: 0 0 0 3px rgba(206, 147, 216, .25);
        }

        .btn {
            width: 100%;
            padding: .8rem;
            font-family: 'Montserrat', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform .15s;
            margin-top: .4rem;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(to right, #9c27b0, #e91e63);
            box-shadow: 0 4px 12px rgba(233, 30, 99, .35);
        }

        .btn-back {
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
<div class="blob blob-top"></div>
<div class="blob blob-bottom"></div>
<div class="card">
  <div class="icon-wrap"><img src="logo.png" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"></div>
  <h2>Alterar Status do Produto</h2>
  <form name="status" action="?id=<?php echo htmlspecialchars($id_param); ?>" method="POST">
    <label for="fstatus">Novo status</label>
    <select name="fstatus" id="fstatus">
      <option value="liberado">Liberado</option>
      <option value="bloqueado">Em falta</option>
      <option value="verificar">Verificar</option>
      <option value="banido">Não vendemos mais</option>
    </select>
    <button type="submit" name="bstatus" class="btn btn-primary">Salvar altera&ccedil;&atilde;o &rarr;</button>
  </form>
  <a href="pesquisa.php" style="display:block;text-align:center;margin-top:.75rem;font-size:.85rem;color:#8a6bb5;text-decoration:none;"><i class="fa-solid fa-arrow-right-from-bracket"></i>Voltar</a>
</div>
</body>
</html>

