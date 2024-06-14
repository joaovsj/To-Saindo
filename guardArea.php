<?php 

    require __DIR__.'/vendor/autoload.php';
    use \App\Entity\Admin;

    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusGuard']) || $_SESSION['statusGuard'] !== true) {
        header('Location: index.php');
        exit;
    }
    
    $obAdmin = new Admin();
    $dados = $obAdmin->getGuard($_SESSION['userGuard']);
    $img = $obAdmin->getImg($_SESSION['userGuard']);

    $mensagem = '';
    if(isset($_SESSION['mensagem'])){
        
        if($_SESSION['status'] == true){    
            $mensagem = '
            <section class=box-msg id="allMsg">    
                <button class=close id="btn-close">
                    <i class="bx bx-x bx-rotate-90"></i>
                </button>
                <div class="response success">
                    <i class="bx bx-check-circle"></i>
                    <p class="text-mg">'.$_SESSION['mensagem'].'</p>
                </div>
            </section>';
        }else {
            $mensagem = '
            <section class=box-msg id="allMsg">    
                <button class=close id="btn-close">
                    <i class="bx bx-x bx-rotate-90"></i>
                </button>
                <div class="response error">
                    <i class="bx bx-x-circle"></i>
                    <p class="text-mg">'.$_SESSION['mensagem'].'</p>
                </div>
            </section>';
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="resources/css/areaGuard.css">
    <link rel="stylesheet" href="resources/css/init.css">

    <!-- <script type="text/javascript" src="resources/js/readQrcode.js"></script> -->
    <script type="text/javascript" src="resources/js/animateMenu.js" defer></script>
    <script type="text/javascript" src="resources/js/mensagem.js" defer></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <title>Guarda</title>
</head>
<body>

    <article class="init">
        <i class='bx bxs-message-square-dots' ></i>
        <span>Tô Saindo</span>
    </article>

    <header>
        <span class="title">
            <i class='bx bxs-message-square-dots' ></i>
            <a id="logo" href="">Tô Saindo</a>  
        </span>
        <nav id="nav">
            <!--button criado dentro da nav-->
            <button id="btn-mobile">
              <span id="hamburguer"></span>
            </button>
            <ul id="menu">
              <li><a href="#">Meus Dados</a></li>
              <li><a href="#">Histórico</a></li>
              <li><a href="admin/closeGuard.php">Sair</a></li>
            </ul>  
        </nav>  
    </header>   

    <?= $mensagem ?>

    <main>
        <div class="info">
            <div 
                style="background-image: url(resources/img/<?= $img->nomeImagem ?>);" class="img">
            </div>
            <p>Bem-vindo <?= $dados->nome ?> </p>
        </div>

        <div class="box-video" id="video">
            <video id="preview"></video>
        </div>
        <p>Aguardando Leitura....</p>
    </main>
</body>
<script>
    // instanciamos a classe camera e dissmos que elemento vai fazer a leitura
    let scanner = new Instascan.Scanner(
        {
            video: document.getElementById('preview')
        }
    );

    // meio de campo que vai fazer a leitura
    scanner.addListener('scan', function(content){
        window.location.href = content;
    });

    // verificando se existe alguma camera
    Instascan.Camera.getCameras().then(cameras => {
        if(cameras.length > 0){
            scanner.start(cameras[0]);
        }else{
            console.error('Não existe cameras no dispositivo');
        }
    });
</script>
</html>