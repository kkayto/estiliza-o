 <!-- Professora C�lia Regina Bueno Figueira
  Etec de Po�
 salvar como index.php -->
 <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moranguete Doces — Login</title>
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
            padding: 1rem;
            background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #ea80fc 100%);
            position: relative;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
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
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .icon-wrap {
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

        .icon-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .card-subtitle {
            margin-top: 0.4rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #8a6bb5;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #613e9b;
        }

        .forgot {
            font-size: 0.75rem;
            font-weight: 500;
            color: #d500f9;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            font-size: 1rem;
            pointer-events: none;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.5rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            color: #613e9b;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: #b39ddb;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #ce93d8;
            box-shadow: 0 0 0 3px rgba(206, 147, 216, 0.25);
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
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

        .btn-login:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.5);
        }

        .btn-login:active {
            transform: scale(0.97);
        }

        .card-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.8rem;
            color: #8a6bb5;
        }
    </style>
    </head>
<body>

    <div class="blob blob-top"></div>
    <div class="blob blob-bottom"></div>

    <div class="card">
        <div class="card-header">
            <div class="icon-wrap"><img src="logo.png" alt="Moranguete Doces"></div>
            <h1 class="card-title">Moranguete Doces</h1>
            <p class="card-subtitle">Acesse sua conta para continuar comprando</p>
        </div>

        <form action="entrada.php" method="post" enctype="multipart/form-data">
            <div class="field">
                <label for="login">Usu&aacute;rio</label>
                <div class="input-wrap">
                    <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                    <input type="text" id="login" name="login" placeholder="ex: user" required>
                </div>
            </div>

            <div class="field">
                <div class="field-row">
                    <label for="senha">Senha</label>
                    <a href="#" class="forgot">Esqueceu a senha?</a>
                </div>
                <div class="input-wrap">
                    <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="senha" name="senha" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Entrar &rarr;
            </button>
        </form>

        <p class="card-footer">🍬 Doces que melhoram o seu dia!</p>
    </div>

</body>
</html>

 </HTML>
