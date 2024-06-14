<?php 

    include __DIR__.'/includes/header.php';
    require __DIR__.'/includes/function.php';
    require __DIR__.'/vendor/autoload.php';

    use \App\Entity\Admin;

    if(isset($_POST['btn-enviar'])){

        $response = checkEmpty($_POST);

        if($response === false or $_FILES['arquivo']['error'] === 4){
            header('Location: registerGuards?status=empty');
            exit;
        }

        $formats = array('jpeg', 'jpg', 'png');
        $extension = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

        if(in_array($extension, $formats)){

            $newName = uniqid().".$extension";

            if(move_uploaded_file($_FILES['arquivo']['tmp_name'], 'resources/img/'.$newName)){

                $obAdmin = new Admin();
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
                $obAdmin->imagem = $newName;

                $obAdmin->cadastrar();

                header('Location: registerGuards.php?status=success');
                exit;

            }else{

                header('Location: register.php?status=failed');
                exit;
            }

        } else{
            
                header('Location: registerGuards.php?status=failed');
                exit;
        }  
    }    

    $mensagem = '';
    // verifica se existe mensagem
    if(isset($_GET['status'])){
        switch ($_GET['status']) {
            case 'success':
                $mensagem = '<div class="msg">
                                Segurança cadastrado com Sucesso!
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
                    <h3>Seguranças</h3>
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
                        <input type="text" class="nome" name="nome" required="required">
                        <span>Nome</span>
                    </div>
                    <div class="inputBox item col-1">
                        <input type="text" class="cpf" name="cpf" required="required">
                        <span>CPF</span>
                    </div>
                </div>
                <div class="row">
                    <div class="inputBox item col-3">
                        <input type="email" class="email" name="email" required="required">
                        <span>Email</span>
                    </div>
                    <div class="inputBox item col-3">
                        <input type="text" class="telefone" name="telefone" required="required">
                        <span>Telefone</span>
                    </div>
                </div>

                <div class="row">
                    <div class="inputBox item col-2">                    
                        <input type="text" class="cep" name="cep" id="cep" required="required">
                        <span>CEP</span>
                    </div>
                    <div class="inputBox item col-2">                    
                        <input type="text" class="uf" name="uf" maxlength="2" required="required">
                        <span>UF</span>
                    </div>
                    <div class="inputBox item col-2">                    
                        <input type="text" class="cidade" name="cidade" maxlength="50" required="required">
                        <span>Cidade</span>
                    </div>
                </div>
                <div class="row">
                    <div class="inputBox item col-4">                    
                        <input type="text" class="rua" name="rua" required="required">
                        <span>Rua</span>
                    </div>
                    <div class="inputBox item col-2">                    
                        <input type="text" class="bairro" name="bairro" maxlength="50" required="required">
                        <span>Bairro</span>
                    </div>
                </div>
                <div class="row">
                    <div class="inputBox item col-2">                    
                        <input type="text" class="numero" name="numero" maxlength="5" required="required">
                        <span>Número</span>
                    </div>
                    <div class="inputBox item col-4">                    
                        <input type="text" class="rm" name="rm" maxlength="11" required="required">
                        <span>RM</span>
                    </div>
                </div>
        
                <div class="row-btn">
                    <button class="btn-right" type="submit" name="btn-enviar">Salvar</button>
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
