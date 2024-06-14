<?php 

    include __DIR__.'/includes/header.php';
    require __DIR__.'/includes/function.php';
    require __DIR__.'/vendor/autoload.php';

    use \App\Entity\Student;
    use \App\Entity\Course;

    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        header('Location: index.php');
        exit;
    }
    
    if(!isset($_GET['ano'],$_GET['curso'])){
        
        header('Location: rooms.php');
        exit;
    }

    $year = [
        1 => 'Primeiro',
        2 => 'Segundo',
        3 => 'Terceiro'
    ];

    $title = $year[$_GET['ano']] ? $year[$_GET['ano']] : false;

    if($title === false){
        header('Location: rooms.php');
        exit;    
    }

    $courses = Course::getCourses('ano = '.$_GET['ano']);
    $curso = '';

    if(isset($_GET)){
        foreach ($courses as $course) {
            if($_GET['curso'] == $course->curso){
                $curso = $_GET['curso'];
            }
        }

        if($curso === ''){  

            header('Location: rooms.php');
            exit;
        } 
    }

////////////////////////////////////////////////////////////////

    if(isset($_GET['status']) ){
        if($_GET['status'] == 'true'){
            
            $id = $_GET['id'];
            $student = new Student();
            // nome da imagem
            $img = $student->getImg($id);

            $student->deleteImg($id);
            $student->deleteStudent($id);

            
            unlink('resources/img/'.$img->nomeImagem);
            header('Location: course.php?ano='.$_GET['ano'].'&curso='.$_GET['curso'].'&mensagem=true');        
            exit;
        }   
    }

///////////////////////////////////////////////////////////////


    $student = new Student;

    if(isset($_GET['id'])){

        if(!is_numeric($_GET['id'])){
            header('Location: rooms.php');
            exit;
        }

        $alunos = $student->getStudents($_GET['ano'], $_GET['curso']); 

        if(checkStudent($alunos, $_GET['id'])){
            
            $dados = $student->getStudent($_GET['id']); 

        }else{
            header('Location: rooms.php');
            exit;
        }
    } 
    
?>

    <link rel="stylesheet" href="resources/css/confirm.css">

    <main>

        <span id="btn-back">
            <a href="course.php?ano=<?= $_GET['ano'] ?>&curso=<?= $_GET['curso'] ?>">
                <i class='bx bx-left-arrow-alt bx-flip-vertical'></i>
            </a>
        </span>

        <section>
            <div class="modal_text">
                <p>Tem certeza que deseja excluir o aluno(a) <br><strong><?= $dados->nome ?>?</strong></p>
            </div>
            <div class="modal_option">
                <a href="course.php?ano=<?= $_GET['ano'] ?>&curso=<?= $_GET['curso'] ?>">
                    <button>Não.</button>
                </a>
                <a href="confirm.php?ano=<?= $_GET['ano'] ?>&curso=<?= $_GET['curso']?>&status=true&id=<?= $dados->idAluno ?>">
                    <button type="submit">Sim, tenho certeza.</button>
                </a>
            </div>
        </section>
    </main>

<?php 
    include __DIR__.'/includes/footer.php';
?>