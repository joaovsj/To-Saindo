<?php 

    include __DIR__.'/includes/header.php';
    require __DIR__.'/includes/function.php';
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
    

    $obGuard = new Admin();
    if(!isset($_GET['idGuard']) or !is_numeric($_GET['idGuard'])){ 

        header('Location: rooms.php');
        exit;
    }


////////////////////////////////////////////////////////////////

    if(isset($_GET['status']) ){
        if($_GET['status'] == 'true'){
            
            $id = $_GET['idGuard'];
            // nome da imagem
            $img = $obGuard->getImg($id);
            $obGuard->deleteImg($id);
            $obGuard->deleteAdmin($id);

            
            unlink('resources/img/'.$img->nomeImagem);
            header('Location: guards.php?mensagem=true');        
            exit;
        }   
    }

///////////////////////////////////////////////////////////////

        $guards = $obGuard->getAdmin(); 
        
        
        if(checkGuards($guards, $_GET['idGuard'])){
            
            $dados = $obGuard->getGuard($_GET['idGuard']); 

        }else{
            header('Location: rooms.php');
            exit;
        }   

    
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
                <p>Certeza que deseja excluir o(a) segurança<br><strong><?= $dados->nome ?>?</strong></p>
            </div>
            <div class="modal_option">
                <a href="guards.php">
                    <button>Não.</button>
                </a>
                <a href="confirmGuard.php?idGuard=<?= $dados->idAdmin ?>&status=true&id=">
                    <button type="submit">Sim, tenho certeza.</button>
                </a>
            </div>
        </section>
    </main>

<?php 
    include __DIR__.'/includes/footer.php';
?>