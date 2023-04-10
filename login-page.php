<?php
require('./PHP_CLASSES/validacoes.php');
$Validacoes = new validacoes();
$Validacoes->Login();


?>

<!DOCTYPE html>

<head>


    <link rel="stylesheet" href="./CSS/reset.css">
    <link rel="stylesheet" href="./CSS/login-page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,700&display=swap" rel="stylesheet">


</head>

<body>
    <header></header>

    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>

        <div class="container-login">
            <div class="login-form">
                

                <form action="" id="form-login" method="post">
                    <div class="holder-inputs">
                        <div class="div_input">
                            <label for="email_login">Email</label>
                            <input type="email" name="email_login" id="login_input" placeholder="Insira seu email">
                        </div>

                        <div class="div_input">
                            <label for="senha_login">Senha</label>
                            <input type="password" name="senha_login" id="senha_input" placeholder="Insira sua senha">
                        </div>
                        <div class="div_input">
                            <input type="submit" id='submit-button' value="Logar">
                        </div>
                        <?php  if(isset($status_senha)){ echo "Usuário ou senha incorretos"; }?>
                    </div>



                </form>


            </div>
        </div>
    </div>
    <script>

    </script>
</body>

</html>