<?php

    $mensagem = '';
    if(isset($_GET['status'])){

        switch ($_GET['status']) {
            case 'false':
                $mensagem = '<div class="error">
                                Erro ao fazer login!     
                            </div>';
                break;
            case 'doubt':
                $mensagem = '<div class="error">
                                Use seu email e seu CPF para logar!     
                            </div>';
                break;
            default:
                $mensagem = '';
                break;
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/login.css">
    <script src="https://kit.fontawesome.com/219248cbde.js" crossorigin="anonymous"></script>
    <title>Tô Saindo</title>
</head>
<body>
    <div class="container">
        <div class="bubbles">
            <span style="--i: 11;"></span>
            <span style="--i: 8;"></span>
            <span style="--i: 15;"></span>
            <span style="--i: 19;"></span>
            <span style="--i: 9;"></span>
            <span style="--i: 16;"></span>
            <span style="--i: 14;"></span>
            <span style="--i: 11;"></span>
            <span style="--i: 13;"></span>
            <span style="--i: 8;"></span>
            <span style="--i: 16;"></span>
            <span style="--i: 12;"></span>
            <span style="--i: 14;"></span>
            <span style="--i: 18;"></span>
            <span style="--i: 13;"></span>
            <span style="--i: 19;"></span>
            <span style="--i: 10;"></span>
            <span style="--i:  6;"></span>
            <span style="--i: 14;"></span>
            <span style="--i: 17;"></span>
            <span style="--i: 12;"></span>
            <span style="--i: 16;"></span>
            <span style="--i: 18;"></span>
            <span style="--i: 9;"></span>
            <span style="--i: 11;"></span>
            <span style="--i: 14;"></span>
            <span style="--i: 13;"></span>
            <span style="--i: 19;"></span>
            <span style="--i: 10;"></span>
            <span style="--i:  6;"></span>
            <span style="--i: 19;"></span>
            <span style="--i: 10;"></span>
            <span style="--i:  3;"></span>
        </div>
    </div>
    <section class="sectionTitulo">
        <div class="boxTitulo">
            <h1><span>Gerencie</span> seus<br> Horários...</h1>
        </div>
        <div class="secondText">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
        </div>
    </section>

    <?= $mensagem ?>
    <section class="form">
        <div class="content-form">
            <h1>Login</h1>
            <form action="login.php" method="post">
                <div class="inputBox">
                    <input type="text" name="user" id="" required="required">
                    <span>Login</span>
                </div>
                <div class="inputBox">
                    <input type="password" name="password" id="" required="required">
                    <span>Senha</span>
                </div>
                
                <div class="form-button">
                    <button type="submit">Entrar</button>
                </div>
            </form>
            <a href="index.php?status=doubt"><u>Esqueci a senha!</u></a>
        </div>
    </section>
</body>
</html>