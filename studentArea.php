<?php

    require __DIR__.'/vendor/autoload.php';
    use \App\Entity\Student;

    if(!isset($_SESSION)){
        session_start();
    }

    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusStudent']) || $_SESSION['statusStudent'] !== true) {
        header('Location: index.php');
        exit;
    } 

    $obStudent = new Student();
    $dados = $obStudent->getStudent($_SESSION['userStudent']);
    $img = $obStudent->getImg($_SESSION['userStudent']);

    $nome = $dados->nome;
    $nome = explode(' ', $nome);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/areaStudent.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="resources/css/init.css">
    <!-- Sem defer não funciona -->
    <script src="resources/js/animateMenu.js" defer></script>
    <script src="resources/js/qrcode.min.js"></script>
    <script src="resources/js/qrcode.js"></script>
    <title>Tô Saindo!</title>
</head>
<body>

    <article class="init">
        <i class='bx bxs-message-square-dots' ></i>
        <span>Tô Saindo</span>
    </article>

    <main>
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
                  <li><a href="#">Horários</a></li>
                  <li><a href="admin/closeStudent.php">Sair</a></li>
                </ul>  
            </nav>  
        </header>
        <section class="content">
            <article class="first-content">
                <div style="background-image: url(resources/img/<?= $img->nomeImagem ?>);" class="img">
                    <!-- <img src="img/bird.jpeg" alt="imagem do aluno"> -->
                </div>
                <p>Bem-vindo(a) <?= $nome[0] ?></p>
            </article>
            <article class="last-content">

            <input 
                type="hidden" name="url" id="url" 
                value="http://localhost/logica_tcc/checkStudent.php?id=<?= $dados->idAluno ?>">

                <div class="qrcode" id="qrcode">
                    <!-- Ele vai aqui -->
                </div>
            </article>
            <p>Seu QRCode</p> 
        </section>
    </main>
</body>
</html>