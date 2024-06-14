<?php 
    
    include __DIR__.'/includes/header.php';
    require __DIR__.'/vendor/autoload.php';
    use \App\Entity\Admin;
    
    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        
        header('Location: index.php');
        exit;
    }

    $obAdmin = new Admin();
    $dados = $obAdmin->getGuard(8);
?>
    <link rel="stylesheet" href="resources/css/init.css">

    <main class="init">
        <i class='bx bxs-message-square-dots' ></i>
        <span>Tô Saindo</span>
    </main>

    <div class="homeContent">
        <h2>Home</h2>
    </div>

    <section>
        <div class="box_img">
            <img src="resources/img/admin.svg" alt="admin">
        </div>
        <h2>Bem-vindo <?= $dados->nome ?>!!!</h2>
    </section>

<?php 
    include __DIR__.'/includes/footer.php';
?>
