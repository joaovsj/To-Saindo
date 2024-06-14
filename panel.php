<?php 
    include __DIR__.'/includes/header.php';
    require __DIR__.'/vendor/autoload.php';
    require __DIR__.'/includes/function.php';

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
    $admin = $obAdmin->getGuard(8);
    $img = $obAdmin->getImg(8);


    if(isset($_POST['btn-salvar'])){

/*//////////////////////////////////////////////////////////////////////////////*/ 
        $response = checkEmpty($_POST);

        if($response === false){
            header('Location: panel.php?status=empty');
            exit;
        }

        $obAdmin->idAdmin = $admin->idAdmin; 
        $obAdmin->nome = $_POST['nome']; 
        $obAdmin->cpf  = $_POST['cpf'];
        $obAdmin->email = $_POST['email'];
        $obAdmin->telefone = $_POST['telefone'];
        $obAdmin->cep = $_POST['cep'];
        $obAdmin->uf = $_POST['uf'];
        $obAdmin->cidade = $_POST['cidade'];
        $obAdmin->rua = $_POST['rua'];
        $obAdmin->bairro = $_POST['bairro'];
        $obAdmin->numero = $_POST['numero'];
        $obAdmin->rm = $_POST['rm'];      

        $obAdmin->atualizar($admin->idAdmin);

        // upload de imagem
        if($_FILES['arquivo']['error'] === 0){

            $formats = array('jpeg', 'jpg', 'png');
            $extension = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

            if(in_array($extension, $formats)){
                
                // consulta tabela imagens 
                $img = $obAdmin->getImg($admin->idAdmin);
                $obAdmin->deleteImg($admin->idAdmin);
                unlink('resources/img/'.$img->nomeImagem);

                // novo nome da imagem
                $newName = uniqid().".$extension";
                $obAdmin->imagem = $newName;

                if(move_uploaded_file($_FILES['arquivo']['tmp_name'], 'resources/img/'.$newName)){
                    
                    $obAdmin->cadastrarImg();
                    // atualizado com imagem
                    header('Location: panel.php?status=success');
                    exit; 

                } else {
                    // erro ao fazer upload
                    header('Location: panel.php?status=failed');
                    exit;

                }
            } else {
            
                // extensão inválida
                header('Location: panel.php?status=failed');
                exit;
            } 

        } else{

            // atualizado, sem imagem
            header('Location: panel.php?status=success');
            exit;

        }  
/*//////////////////////////////////////////////////////////////////////////////*/ 
    }

    $mensagem = '';
    // verifica se existe mensagem
    if(isset($_GET['status'])){
        switch ($_GET['status']) {
            case 'success':
                $mensagem = '<div class="msg">
                                Atualizado com Sucesso!
                            </div>';
                break;
            case 'empty':
                $mensagem = '<div class="msg error">
                                Preencha todos os campos ou verifique os dados enviados!
                            </div>';
                break;
            case 'verify':              
                $mensagem = '<div class="msg error">
                                Insira Dados Válidos!
                            </div>';
                break;
            case 'failed':              
                    $mensagem = '<div class="msg error">
                                    Falha ao fazer Upload, use uma imagem válida. 
                                </div>';
                break;
        }
    }
?>
    
    <link rel="stylesheet" href="resources/css/panel.css">
    <script src="resources/js/buscaCep.js" defer ></script>

    <div class="homeContent">
        <h2>Painel</h2>
    </div>

    <div id="role" role="alert">
        <p>CEP Inválido!</p>
    </div>

    <?= $mensagem ?>

    <section class="painel">
        <form action="" method="post" enctype="multipart/form-data" class="form">
            <article class="content-left">
                <div style="background-image: url(resources/img/<?= $img->nomeImagem ?>);" class="left-img">
                </div>
                    <input type="file" name="arquivo" id="arquivo">
                    <label for="arquivo">
                        <i class='bx bx-upload'></i>
                        Escolher Imagem
                    </label>
            </article>
            <article class="content-right">
                <article class="form">
                    <h1>Seus Dados</h1>
                    <div class="row">
                        <div class="inputBox item col-4">
                            <input type="text" class="nome" name="nome" value="<?= $admin->nome ?>" required="required">
                            <span>Nome</span>
                        </div>
                        <div class="inputBox item col-1">
                            <input type="text" class="cpf" name="cpf" value="<?= $admin->cpf ?>"  required="required">
                            <span>CPF</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="inputBox item col-3">
                            <input type="email" class="email" name="email"value="<?= $admin->email ?>"  required="required">
                            <span>Email</span>
                        </div>
                        <div class="inputBox item col-3">
                            <input type="text" class="telefone" name="telefone" value="<?= $admin->telefone ?>" required="required">
                            <span>Telefone</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="inputBox item col-2">                    
                            <input type="text" class="cep" name="cep" id="cep" value="<?= $admin->cep ?>" required="required">
                            <span>CEP</span>
                        </div>
                        <div class="inputBox item col-2">                    
                            <input type="text" class="uf" name="uf" maxlength="2" value="<?= $admin->uf ?>" required="required">
                            <span>UF</span>
                        </div>
                        <div class="inputBox item col-2">                    
                            <input type="text" class="cidade" name="cidade" maxlength="50"value="<?= $admin->cidade ?>"  required="required">
                            <span>Cidade</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="inputBox item col-4">                    
                            <input type="text" class="rua" name="rua"value="<?= $admin->rua ?>"  required="required">
                            <span>Rua</span>
                        </div>
                        <div class="inputBox item col-2">                    
                            <input type="text" class="bairro" name="bairro" maxlength="50"value="<?= $admin->bairro ?>"  required="required">
                            <span>Bairro</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="inputBox item col-2">                    
                            <input type="text" class="numero" name="numero" maxlength="5"value="<?= $admin->numero ?>"  required="required">
                            <span>Número</span>
                        </div>
                        <div class="inputBox item col-4">                    
                            <input type="text" class="rm" name="rm" maxlength="11" value="<?= $admin->rm ?>" required="required">
                            <span>RM</span>
                        </div>
                    </div>
                    <div class="row-btn">
                        <button class="btn-right" type="submit" name="btn-salvar">Salvar</button>
                    </div>
                </article>
            </article>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
          $('.cpf').mask('000.000.000-00', {reverse: true});
          $('.telefone').mask('(00) 00000-0000');
          $('.cep').mask('00000-000');
    </script>
<?php 
    include __DIR__.'/includes/footer.php';
?>
