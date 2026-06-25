  <!-- Professora Célia Regina Bueno Figueira
  Etec de Poá
 salvar como naoentrou.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moranguete Doces &mdash; Acesso negado</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        position: relative;
        overflow: hidden;
    }

    .blob { position: absolute; width: 380px; height: 380px; border-radius: 50%; filter: blur(80px); opacity: 0.5; pointer-events: none; }
    .blob-top    { top: -10%; left: -10%; background: #ff80ab; mix-blend-mode: multiply; }
    .blob-bottom { bottom: -10%; right: -10%; background: #d500f9; mix-blend-mode: multiply; }

    .card {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 420px;
        background: rgba(255,255,255,0.45);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.15);
        text-align: center;
    }

    .card-header {
        text-align: center;
        margin-bottom: 0.3rem;
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
        margin-bottom: 0.2rem;
        overflow: hidden;
    }

    .icon-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    h1 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #613e9b;
        margin-bottom: 0.5rem;
    }

    p {
        font-size: 0.9rem;
        color: #8a6bb5;
        margin-bottom: 1.75rem;
        line-height: 1.5;
    }

    .btn-back {
        display: inline-block;
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
        text-decoration: none;
        box-shadow: 0 4px 15px 0 rgba(233,30,99,0.4);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-back:hover  { transform: scale(1.02); box-shadow: 0 6px 20px rgba(233,30,99,0.5); }
    .btn-back:active { transform: scale(0.97); }

    .card-footer {
        margin-top: 1.5rem;
        font-size: 0.78rem;
        color: #8a6bb5;
    }
</style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <div class="icon-logo"><img src="logo.png" alt="Moranguete Doces"></div>
        <h1 class="card-title">Acesso Negado</h1>
    </div>
    <p>Usu&aacute;rio ou senha inv&aacute;lidos.<br>Verifique seus dados e tente novamente.</p>
    <a href="index.php" class="btn-back">Voltar ao login &rarr;</a>
</div>

</body>
</html>

</html>


