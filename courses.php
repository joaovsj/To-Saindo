<?php 

    include __DIR__.'/includes/header.php';
    require __DIR__.'/vendor/autoload.php';

    use \App\Entity\Course;
    use \App\Entity\Student;
    use \App\Entity\Time;
    
    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        header('Location: index.php');
        exit;
    }
    


    if($_GET['year'] and is_numeric($_GET['year'])){
        
        $year = [
            1 => 'Primeiro',
            2 => 'Segundo',
            3 => 'Terceiro'
        ];

        $title = $year[$_GET['year']] ?? $_POST['ano'] ?? false;

        if($title === false){
            header('Location: rooms.php');
            exit;    
        }

    }else{
        header('Location: rooms.php');
        exit;
    }
        
    $index = [
        'Primeiro' => 1,
        'Segundo'  => 2,
        'Terceiro' => 3
    ];

    $number = $index[$title] ? $index[$title] : false;

    if($number != false){
        $courses = Course::getCourses('ano = '.$number);
    }
    
    $mensagem = '';
/////////////// definindo cadastro////////////////////////
    
    if(isset($_POST['addCourse']) and !empty($_POST['nome'])){
    
        $objCourse = new Course();
        $objCourse->nome = addslashes($_POST['nome']);
        $objCourse->ano  = addslashes($_POST['ano']);
        $objCourse->cadastrar();
        header('Location: courses.php?status=success&year='.$_GET['year']);
        exit;

    }

//////////////// definindo exclusao ////////////////////////
    $status = 0;
    // remove
    if(isset($_POST['activeRemove'])){

        if($_POST['statusRemoving'] == 0){
            $status = 1;
            
        }else{

            unset($_POST['activeRemove'],$_POST['statusRemoving'], $_POST['nome']);
            $ano = $_POST['ano'];
            unset($_POST['ano']);
            
            $objCourse = new Course();
            $objStudent = new Student();
            $objTime = new Time();

            foreach ($_POST as $curso => $id) {

                $students = $objStudent->getStudents($ano, $curso);

                // se existe alunos eu vou deletar os alunos
                if(count($students) > 0){
                    foreach($students as $student) {

                        // pegando o nome da img
                        $img = $objStudent->getImg($student->idAluno);
                        // deletando o registro da iamgem do banco 
                        $objStudent->deleteImg($student->idAluno);
                        // deletetando o estudante 
                        $objStudent->deleteStudent($student->idAluno);        
                        unlink('resources/img/'.$img->nomeImagem);                        
                    }
                }
                
                // deletar o curso
                $objCourse->delete($id);
                $objTime->deleteHour($ano, $curso);
            
            }       

            header('Location: courses.php?status=success&year='.$ano);
            exit;
        }
    }

////////////// definindo mensagem ////////////////////////

    if(isset($_GET['status'])){
        switch ($_GET['status']) {
            case 'success':
                $mensagem = '<div class="msg">
                                Ação realizada com Sucesso!
                            </div>';
                break;
            case 'error':
                $mensagem = '<div class="msg-error">
                                Falha ao realizar a Ação!
                            </div>';
                break;
        }
    }

    
?>
    <link rel="stylesheet" href="resources/css/courses.css">
    <script type="text/javascript" src="resources/js/animation.js" defer></script>

    <div class="homeContent">
        <h2>Cursos</h2>
    </div>

    <?= $mensagem ?>

    <section class="box-rooms">
        <form action="" method="post" id="RemoveCourses">
        <input type="hidden" name="activeRemove" value="active"> 
        <input type="hidden" name="statusRemoving" value="<?php echo $status == 0 ? 0 : 1 ?>">
        <?php 

            if(count($courses)>0){
                
                foreach ($courses as $course) {
                    ?>
                        <a href="course.php?ano=<?= $course->ano ?>&curso=<?= $course->curso ?>">
                            <article class="box-item">
                                <h3><?= $course->curso ?></h3>
        
                                <?php   
                                    if(isset($_POST['activeRemove'])){
                                        ?>
                                            <input 
                                                type="checkbox" 
                                                name="<?= $course->curso ?>" 
                                                id="curso" 
                                                value="<?= $course->idClasse ?>"
                                            >
                                        <?php
                                    }
                                ?>
                            </article>
                        </a> 
                    <?php
                }

            }else{
                ?>
                    <h4> > Ainda não há cursos cadastrados!</h4>
                <?php
            }
        ?>

        <span class="ind-rodape">
            <h3><?= $title ?> > ...</h3>
        </span>
    </section>
            <div id="menu">
                <button id="add">
                    <i class="fa-solid fa-plus"></i>
                </button>
                    <main id="formCurso">
                        <fieldset>
                            <form id="contentMenu" method="POST">
                                <span id="title">Adicionar Curso</span>
                                <div class="inputBox">
                                    <input type="text" name="nome" class="" required="required">
                                    <span>Nome</span>
                                </div>

                                <input type="hidden" name="ano" value="<?= $_GET['year'] ?>">

                                <div class="buttonBox">
                                    <button type="submit" name="addCourse">Adicionar</button>
                                </div>
                            </form>     
                        </fieldset>
                    </main>
                <button onclick="submitForm()" id="remove" value="deleteCourse">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>       
        </form>
<?php 
    include __DIR__.'/includes/footer.php';
?>
