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


    // mensagem de retorno
    $mensagem = '';
    if(isset($_GET['mensagem'])){
        if($_GET['mensagem'] == 'true'){    
            $mensagem = '<div class="msg">
                            Ação realizada com Sucesso!
                        </div>';
        }else{
            header('Location: rooms.php');
            exit;
        }
    }
?>
    <link rel="stylesheet" href="resources/css/guards.css">

    <div class="homeContent">
        <h2>Guardas</h2>
    </div>

    <?= $mensagem ?>

    <main>
        <article class="content-one">
            <table>
                <thead>
                    <th>IMG</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th colspan="2">Opções</th>
                </thead>
                <tbody><?php

                    $obAdmin = new Admin();                    
                    $guards = $obAdmin->getAdmin();

                    if(count($guards) > 0){
                        foreach ($guards as $guard) { 
                            // verify if is admin
                            if($guard->idAdmin == 8){
                                continue;
                            }
                        ?>
                                <tr>
                                    <td>
                                        <div>
                                            <img src="resources/img/<?= $guard->foto ?>" alt="foto do guarda">
                                            <img id="foto-item" src="resources/img/<?= $guard->foto ?>" alt="foto do guarda">
                                        </div>
                                    </td>
                                    <td><?= $guard->nome ?></td>
                                    <td><?= $guard->rm ?></td>
                                    <td><?= $guard->email ?></td>
                                    <td>
                                        <a href="upGuards.php?idGuard=<?= $guard->idAdmin ?>">
                                            <button><i class='bx bx-edit-alt' ></i></button>
                                        </a>
                                        <a href="confirmGuard.php?idGuard=<?= $guard->idAdmin ?>">
                                            <button type="button"><i class='bx bxs-trash'></i></button>
                                        </a>
                                    </td> 
                                </tr>   
                            <?php } // close foreach
                        }   // close if
                    ?>  
                </tbody>
            </table>
            <div class="buttonBox">
                <a href="registerGuards.php">
                    <button class="btn-ok">Novo</button>
                </a>
            </div>
        </article>     
    </main>
<?php 
    include __DIR__.'/includes/footer.php';
?>