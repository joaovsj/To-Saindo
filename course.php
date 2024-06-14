<?php 

    include __DIR__.'/includes/header.php';
    require __DIR__.'/vendor/autoload.php';
    use \App\Entity\Student;
    use \App\Entity\Course;
    use \App\Entity\Time;


    if(!isset($_SESSION)){
        session_start();
    }
    
    // verifica se existe a sessao do admin
    if (!isset($_SESSION['statusAdmin']) || $_SESSION['statusAdmin'] !== true) {
        header('Location: index.php');
        exit;
    }
    

    if(!isset($_GET['ano']) or !isset($_GET['curso'])){
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

    foreach ($courses as $course) {
        if($_GET['curso'] == $course->curso){
            $curso = $_GET['curso'];
        }
    }

    if($curso === ''){
        header('Location: rooms.php');
        exit;
    } 
/*/////////////////////////////////////////////////////////////////*/


/*/////////////////////////////////////////////////////////////////*/
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
    <link rel="stylesheet" href="resources/css/course.css">
    <script src="resources/js/animationCourse.js" defer></script>
    <script type="text/javascript" src="resources/js/defineTime.js" defer ></script>
    <script type="text/javascript" src="resources/js/addColor.js"></script>

    <div class="homeContent">
        <h2>Curso</h2>
    </div>

    <div id="msg-time">
        Escolha no máximo quatro campos!!!
    </div>
    <?= $mensagem ?> 

    <span id="btn-back">
        <a href="courses.php?year=<?= $_GET['ano']  ?>">
            <i class='bx bx-left-arrow-alt bx-flip-vertical'></i>
        </a>
    </span>

    <section class="content-page">
        <article class="content-first">
            <span>
                <h3>Horários da Sala</h3>
            </span>
            <table>
                <thead>
                    <th>SEG</th>
                    <th>TER</th>
                    <th>QUA</th>
                    <th>QUI</th>
                    <th>SEX</th>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="javascript:definir(0)" id="seg-1">13:10 às 14:00</a> </td>
                        <td><a href="javascript:definir(1)" id="ter-1">13:10 às 14:00</a></td>
                        <td><a href="javascript:definir(2)" id="qua-1">13:10 às 14:00</a></td>
                        <td><a href="javascript:definir(3)" id="qui-1">13:10 às 14:00</a></td>
                        <td><a href="javascript:definir(4)" id="sex-1">13:10 às 14:00</a></td>
                    </tr>
                    <tr>
                        <td><a href="javascript:definir(5)" id="seg-2">14:00 às 14:50</a></td>
                        <td><a href="javascript:definir(6)" id="ter-2">14:00 às 14:50</a></td>
                        <td><a href="javascript:definir(7)" id="qua-2">14:00 às 14:50</a></td>
                        <td><a href="javascript:definir(8)" id="qui-2">14:00 às 14:50</a></td>
                        <td><a href="javascript:definir(9)" id="sex-2">14:00 às 14:50</a></td>
                    </tr> 
                    <tr>
                        <td><a href="javascript:definir(10)" id="seg-3">14:50 às 15:40</a></td>
                        <td><a href="javascript:definir(11)" id="ter-3">14:50 às 15:40</a></td>
                        <td><a href="javascript:definir(12)" id="qua-3">14:50 às 15:40</a></td>
                        <td><a href="javascript:definir(13)" id="qui-3">14:50 às 15:40</a></td>
                        <td><a href="javascript:definir(14)" id="sex-3">14:50 às 15:40</a></td>
                    </tr>
                    <tr>
                        <td><a href="javascript:definir(15)" id="seg-4">15:40 às 16:30</a></td>
                        <td><a href="javascript:definir(16)" id="ter-4">15:40 às 16:30</a></td>
                        <td><a href="javascript:definir(17)" id="qua-4">15:40 às 16:30</a></td>
                        <td><a href="javascript:definir(18)" id="qui-4">15:40 às 16:30</a></td>
                        <td><a href="javascript:definir(19)" id="sex-4">15:40 às 16:30</a></td>
                    </tr>
                    <tr>
                        <td><a href="javascript:definir(20)" id="seg-5">16:50 às 17:40</a></td>
                        <td><a href="javascript:definir(21)" id="ter-5">16:50 às 17:40</a></td>
                        <td><a href="javascript:definir(22)" id="qua-5">16:50 às 17:40</a></td>
                        <td><a href="javascript:definir(23)" id="qui-5">16:50 às 17:40</a></td>
                        <td><a href="javascript:definir(24)" id="sex-5">16:50 às 17:40</a></td>
                    </tr>
                    <tr>
                        <td><a href="javascript:definir(25)" id="seg-6">17:40 às 18:30</a></td>
                        <td><a href="javascript:definir(26)" id="ter-6">17:40 às 18:30</a></td>
                        <td><a href="javascript:definir(27)" id="qua-6">17:40 às 18:30</a></td>
                        <td><a href="javascript:definir(28)" id="qui-6">17:40 às 18:30</a></td>
                        <td><a href="javascript:definir(29)" id="sex-6">17:40 às 18:30</a></td>
                    </tr>
                </tbody>
            </table>

            <!-- style="display: none; -->
            <form action="receiveTime.php" method="post"  style="opacity: 0; z-index: -11111; height: 0px; pointer-events: none;" id="form">

                <input type="text" name="ano" id="ano" value="<?= $_GET['ano'] ?>"> <br>
                <input type="text" name="curso" id="curso" value="<?= $_GET['curso'] ?>"> <br> 

                <label class="form-label">Primeiro Dia</label>
                <input type="text" class="form-control" id="primeiroDia" name="primeiroDia" value=""> <br>

                <label class="form-label">Segundo Dia</label>
                <input type="text" class="form-control" id="segundoDia" name="segundoDia" value=""> <br>

                <label class="form-label">Terceiro Dia</label>
                <input type="text" class="form-control" id="terceiroDia" name="terceiroDia" value=""> <br>

                <label class="form-label">Quarto Dia</label>
                <input type="text" class="form-control" id="quartoDia" name="quartoDia" value=""> <br>

                <label class="form-label">Primeiro Horario</label>
                <input type="text" class="form-control" id="primeiroHorario" name="primeiroHorario" value=""> <br>

                <label class="form-label">Segundo Horario</label>
                <input type="text" class="form-control" id="segundoHorario" name="segundoHorario" value=""> <br>

                <label class="form-label">Terceiro Horario</label>
                <input type="text" class="form-control" id="terceiroHorario" name="terceiroHorario" value=""> <br>

                <label class="form-label">Quarto Horario</label>
                <input type="text" class="form-control" id="quartoHorario" name="quartoHorario" value=""> <br>
            </form>

            <div class="buttonBox">
                <button class="btn-cancel" onclick="reload()">Cancelar</button>
                <button class="btn-ok" onclick="submitForm()">Definir</button>
            </div>
        </article>
        <article class="content-last">
            <span>
                <h3>Alunos</h3>
            </span>
            <table>
                <thead>
                    <tr>        
                        <th>IMG</th>
                        <th>Nome</th>
                        <th>RM</th>
                        <th>Email</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $obStudent = new Student();
                        $alunos = $obStudent->getStudents($_GET['ano'], $curso);   

                        if(count($alunos) > 0){

                            foreach ($alunos as $aluno) { ?>

                                <tr>
                                    <td>
                                        <div>
                                            <img src="resources/img/<?= $aluno->foto ?>" alt="foto do aluno">
                                            <img id="foto-item" src="resources/img/<?= $aluno->foto ?>" alt="foto do aluno">
                                        </div>
                                    </td>
                                    <td><?= $aluno->nome ?></td>
                                    <td><?= $aluno->rm ?></td>
                                    <td><?= $aluno->email ?></td>
                                    <td>
                                        <a href="upStudent.php?ano=<?= $_GET['ano'] ?>&curso=<?= $_GET['curso']?>&id=<?= $aluno->idAluno ?>">
                                            <button><i class='bx bx-edit-alt' ></i></button>
                                        </a>
                                        <a href="confirm.php?ano=<?= $_GET['ano'] ?>&curso=<?= $_GET['curso']?>&id=<?= $aluno->idAluno ?>">
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
                <a href="register.php?ano=<?= $_GET['ano'] ?>&curso=<?= $_GET['curso'] ?>">
                    <button class="btn-ok">Novo</button>
                </a>
            </div>
        </article>
        <span>
            <h3><?= $title .' > '. $curso ?></h3>
        </span>
    </section>
<?php 
    //
    $objTime = new Time();
    $hours = $objTime->getHour($_GET['ano'], $_GET['curso']);   

    foreach ($hours as $hour) {
        $dia = $objTime->pullHour($hour); ?>

        <script>
                addColor("<?= $dia ?>");
        </script> <?php
    }
    include __DIR__.'/includes/footer.php';
?>