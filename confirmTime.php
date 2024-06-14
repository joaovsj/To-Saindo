<?php 

    include __DIR__.'/includes/header.php';
    require __DIR__.'/includes/function.php';
    require __DIR__.'/vendor/autoload.php';

    use \App\Entity\Admin;
    use \App\Entity\Historic;

    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        header('Location: index.php');
        exit;
    }
    

    $obGuard = new Admin();
    if(!isset($_GET['idTime']) or !is_numeric($_GET['idTime'])){ 

        header('Location: rooms.php');
        exit;
    }


////////////////////////////////////////////////////////////////

    $objHistoric = new Historic();

    if(isset($_GET['status']) ){
        if($_GET['status'] == 'true'){
            
            $id = $_GET['idTime'];
            // nome da imagem
            $status = $objHistoric->deleteRecord($id);

            header('Location: report.php?mensagem=true');        
            exit;
        }   
    }

///////////////////////////////////////////////////////////////

        $records = $objHistoric->getRecord($_GET['idTime']); 
?>

    <link rel="stylesheet" href="resources/css/confirm.css">

    <main>

        <span id="btn-back">
            <a href="guards.php">
                <i class='bx bx-left-arrow-alt bx-flip-vertical'></i>
            </a>
        </span>

        <section>
            <div class="modal_text">
                <p>Certeza que deseja excluir o Registro? De<br><strong>
                    <?= date('d/m/Y à\s H:i:s', strtotime($records->hora)); ?></strong></p>
            </div>
            <div class="modal_option">
                <a href="report.php">
                    <button>Não.</button>
                </a>
                <a href="confirmTime.php?idTime=<?= $records->idHistorico ?>&status=true">
                    <button type="submit">Sim, tenho certeza.</button>
                </a>
            </div>
        </section>
    </main>

<?php 
    include __DIR__.'/includes/footer.php';
?>