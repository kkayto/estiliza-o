 <!-- Professora C�lia Regina Bueno Figueira
  Etec de Po�
 salvar como index.php -->
 <HTML>

 <HEAD>
     <TITLE>teste com sess�o</TITLE>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

     <style>
         body {
             font-family: 'Montserrat', sans-serif;
             background-color: #fff4fcff;
             color: #613e9bff;
             align-items: center;
             text-align: center;
             display: flex;
             flex-direction: column;
         }

         .container-login {
             width: 600px;
             height: 500px;
             border-radius: 10px;
             background-color: #fae6f5ff;
             border: 2px solid #613e9bff;
             box-shadow: 4px 4px 28px #3b3b3bff;
             align-items: center;
             text-align: center;
             display: flex;
             flex-direction: column;
             padding: 20px;
             margin-top: 170px;
         }

         .container-login-header {
             margin-top: 90px;
             align-items: center;
             text-align: center;
             display: flex;
             flex-direction: row;
         }

         .container-login h1 {
             font-size: 24px;
             font-weight: 700;
         }

         .container-login-content {
             flex: 1;
             padding: 25px 28px 0;
             display: flex;
             flex-direction: column;
             align-items: center;
         }

         .input-login {
             width: 80%;
             padding: 15px;
             border-radius: 16px;
             border: 1.5px solid #f5ddefff;
             font-size: 16px;
             font-weight: 400;
             font-family: 'Montserrat', sans-serif;
             text-align: center;
             text-decoration: none;
             cursor: pointer;
             transition: border-color 0.15s ease;
             margin-bottom: 18px;
         }

         .form p {
             font-size: 20px;
             font-weight: 700;
             color: #312f36;
             text-align: center;
             line-height: 1.55;
         }

         .form-btn {
             width: 30%;
             padding: 11px;
             border-radius: 16px;
             font-size: 16px;
             font-weight: 700;
             font-family: 'Montserrat', sans-serif;
             text-align: center;
             text-decoration: none;
             cursor: pointer;
             transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
             letter-spacing: 0.3px;
             margin-top: 18px;
             margin-bottom: 28px;
             background-color: #584391;
             color: #ffffff;
             border: none;
         }
     </style>

 </head>
 <!--<BODY BGCOLOR="#DEDDDE">    -->

 <BODY>
     <div class="container-login">
         <div class="container-login-header">
             <h1> Faça seu login abaixo </h1>
         </div>
         <div class="container-login-content">
             <form action="entrada.php" method="post" enctype="multipart/form-data">

                 <input class="input-login" type="text" name="login" placeholder="Email" id="login" required/>
                 <input class="input-login" type="text" name="senha" placeholder="senha" id="senha" required />
                 <input class="form-btn" type="submit" name="Cadastrar" value="logar">
         </div>
     </div>
 </BODY>

 </HTML>
