<?php 
    include __DIR__.'/includes/header.php';
    use \App\Entity\Admin;
    
    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        
        header('Location: index.php');
        exit;
    }

    
?>

    <link rel="stylesheet" href="resources/css/rooms.css">

    <div class="homeContent">
        <h2>Classes</h2>
    </div>

    <section class="container">
            <a href="courses?year=1">
                <article class="item">
                    <i class='bx bxs-graduation'></i>
                    <span>Primeiro</span>
                </article>
            </a>
            <a href="courses?year=2">
                <article class="item">
                    <i class='bx bxs-graduation'></i>
                    <span>Segundo</span>
                </article>
            </a>
            <a href="courses?year=3">
                <article class="item">
                    <i class='bx bxs-graduation'></i>
                    <span>Terceiro</span>
                </article>
            </a>
    </section>

<?php 
    include __DIR__.'/includes/footer.php';
?>