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
    


    if(!isset($_GET['idGuard'])){
    
        header('Location: rooms.php');
        exit;
    }


    ////////////////////////////////////////////////////////// Configuração de Edição

    $obGuard = new Admin();

    if(isset($_GET['idGuard'])){

        if(!is_numeric($_GET['idGuard'])){

            header('Location: rooms.php');
            exit;
        }

        $guards = $obGuard->getAdmin(); 
        
        
        if(checkGuards($guards, $_GET['idGuard'])){
            
            $dados = $obGuard->getGuard($_GET['idGuard']); 

        }else{
            header('Location: rooms.php');
            exit;
        }


    }   


    ////////////////////////////////////////////////// Cadastro

    if(isset($_POST['btn-editar'])){

        $response = checkEmpty($_POST);

        if($response === false){
            header('Location: upGuards.php?status=empty&idGuard='.$_GET['idGuard']);
            exit;
        }

        $obGuard->idAdmin = $_GET['idGuard']; 
        $obGuard->nome = $_POST['nome']; 
        $obGuard->cpf  = $_POST['cpf'];
        $obGuard->email = $_POST['email'];
        $obGuard->telefone = $_POST['telefone'];
        $obGuard->cep = $_POST['cep'];
        $obGuard->uf = $_POST['uf'];
        $obGuard->cidade = $_POST['cidade'];
        $obGuard->rua = $_POST['rua'];
        $obGuard->bairro = $_POST['bairro'];
        $obGuard->numero = $_POST['numero'];
        $obGuard->rm = $_POST['rm'];      
        
        $obGuard->atualizar($_GET['idGuard']);

        // upload de imagem
        if($_FILES['arquivo']['error'] === 0){

            $formats = array('jpeg', 'jpg', 'png');
            $extension = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

            if(in_array($extension, $formats)){
                
                // consulta tabela imagens 
                $img = $obGuard->getImg($_GET['idGuard']);
                $obGuard->deleteImg($_GET['idGuard']);
                unlink('resources/img/'.$img->nomeImagem);

                // novo nome da imagem
                $newName = uniqid().".$extension";
                $obGuard->imagem = $newName;

                if(move_uploaded_file($_FILES['arquivo']['tmp_name'], 'resources/img/'.$newName)){
                    
                    $obGuard->cadastrarImg();
                    // atualizado com imagem
                    header('Location: upGuards.php?status=success&idGuard='.$_GET['idGuard']);
                    exit; 

                } else {
                    // erro ao fazer upload
                    header('Location: upGuards.php?status=failed&idGuard='.$_GET['idGuard']);
                    exit;

                }
            } else {
            
                // extensão inválida
                header('Location: upGuards.php?status=failed&idGuard='.$_GET['idGuard']);
                exit;
            } 

        } else{

            // atualizado, sem imagem
            header('Location: upGuards.php?status=success&idGuard='.$_GET['idGuard']);
            exit;

        }  


    }    

    $mensagem = '';
    // verifica se existe mensagem
    if(isset($_GET['status'])){
        switch ($_GET['status']) {
            case 'success':
                $mensagem = '<div class="msg">
                                Guarda atualizado com Sucesso!
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

    <link rel="stylesheet" href="resources/css/register.css">
    <script src="resources/js/checkImg.js" defer></script>
    <script src="resources/js/buscaCep.js" defer></script>
    

    <div class="homeContent">
        <h2>Cadastro</h2>
    </div>

    <div id="role" role="alert">
        <p>CEP Inválido!</p>
    </div>

    <?= $mensagem ?>

    <section class="box-all">   
        <form method="post" enctype="multipart/form-data">
            <!-- Container IMG -->
            <article class="row-one">
                <span>
                    <h3>Dados do Aluno</h3>
                </span>
                <div class="container-img">
                    <label for="arquivo" id="contImg">
                        <i class='bx bxs-user-account'></i>
                    </label>
                    <input type="file" name="arquivo" id="arquivo">
                </div>
            </article> 
            <!-- Container Inputs -->

            <article class="row-two">
                <div class="row">
                    <div class="inputBox item col-4">
                        <input type="text" class="nome" name="nome" required="required" value="<?= isset($dados->nome) ? $dados->nome : '' ?>">
                        <span>Nome</span>
                    </div>
                    <div class="inputBox item col-1">
                        <input type="text" class="cpf" name="cpf" required="required" value="<?= isset($dados->cpf) ? $dados->cpf : '' ?>">
                        <span>CPF</span>
                    </div>
                </div>
                <div class="row">
                    <div class="inputBox item col-3">
                        <input type="email" class="email" name="email" required="required" value="<?= isset($dados->email) ? $dados->email : ''  ?>">
                        <span>Email</span>
                    </div>
                    <div class="inputBox item col-3">
                        <input type="text" class="telefone" name="telefone" required="required" value="<?= isset($dados->telefone) ? $dados->telefone : ''  ?>">
                        <span>Telefone</span>
                    </div>
                </div>

                <div class="row">
                    <div class="inputBox item col-2">                    
                        <input type="text" class="cep" name="cep" id="cep" required="required" value="<?= isset($dados->cep) ? $dados->cep : ''  ?>">
                        <span>CEP</span>
                    </div>
                    <div class="inputBox item col-2">                    
                        <input type="text" class="uf" name="uf" maxlength="2" required="required" value="<?= isset($dados->uf) ? $dados->uf : ''  ?>">
                        <span>UF</span>
                    </div>
                    <div class="inputBox item col-2">                    
                        <input type="text" class="cidade" name="cidade" maxlength="50" required="required" value="<?= isset($dados->cidade) ? $dados->cidade : ''  ?>">
                        <span>Cidade</span>
                    </div>
                </div>
                <div class="row">
                    <div class="inputBox item col-4">                    
                        <input type="text" class="rua" name="rua" required="required" value="<?= isset($dados->rua) ? $dados->rua : ''  ?>">
                        <span>Rua</span>
                    </div>
                    <div class="inputBox item col-2">                    
                        <input type="text" class="bairro" name="bairro" maxlength="50" required="required" value="<?= isset($dados->bairro) ? $dados->bairro : ''  ?>">
                        <span>Bairro</span>
                    </div>
                </div>
                <div class="row">
                    <div class="inputBox item col-2">                    
                        <input type="text" class="numero" name="numero" maxlength="5" required="required" value="<?= isset($dados->numero) ? $dados->numero : ''  ?>">
                        <span>Número</span>
                    </div>
                    <div class="inputBox item col-4">                    
                        <input type="text" class="rm" name="rm" maxlength="11" required="required" value="<?= isset($dados->rm) ? $dados->rm : ''  ?>">
                        <span>RM</span>
                    </div>
                </div>
            
                <div class="row-btn">
                    <button class="btn-right" type="submit" name="btn-editar">Salvar</button>
                </div>
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
