<?php 
    include __DIR__.'/includes/header.php';
    require __DIR__.'/vendor/autoload.php';
    use \App\Entity\Historic;
    $objReport = new Historic();


    $nome = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
    $data = filter_input(INPUT_GET, 'data', FILTER_SANITIZE_STRING);

    if($data != ""){
        // convertendo para o formato americano
        $data = str_replace('/', '-', $data);
        $data = date('Y-m-d', strtotime($data));
    }

    // condicoes de filtro
    $condicoes = [
        strlen($nome) ? 'nome LIKE "%'.str_replace(' ', '%', $nome).'%"' : null,
        strlen($data) ? 'hora LIKE "'.$data.'%"' : null
    ];

    $condicoes = array_filter($condicoes); // limpando indices vazios 
    $where = implode(' AND ', $condicoes);

    // pegando todos os registros
    $allRecords = $objReport->getRecords($where);

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
    <link rel="stylesheet" href="resources/css/filtrar.css">

    <div class="homeContent">
        <h2>Histórico</h2>
    </div>

    <?=  $mensagem ?>

    <main>

        <form method="get" class="container_filter">
            <span>
                <h4>Filtrar</h4>
            </span>

            <label for="nome">Nome </label>
            <input type="text" name="nome" id="nome">

            <label for="data">Data</label>
            <input type="text" name="data" id="data" class="data">

            <button type="submit" name="btn-buscar">Buscar</button>
        </form>

        <article class="content-one">
            <table>
                <thead>
                    <th>IMG</th>
                    <th>Nome</th>
                    <th>Ano</th>
                    <th>Curso</th>
                    <th>Data</th>
                    <th colspan="2">Opções</th>
                </thead>
                <tbody><?php
                // --------------------------------------------------- -->

                if(count($allRecords) > 0){
                        foreach ($allRecords as $record) { ?>
                            <tr>
                                <td>
                                    <div>
                                        <img src="resources/img/<?= $record->foto ?>" alt="foto do guarda">
                                        <img id="foto-item" src="resources/img/<?= $record->foto ?>" alt="foto do guarda">
                                    </div>
                                </td>
                                <td><?= $record->nome ?></td>
                                <td><?= $record->ano ?></td>
                                <td><?= $record->curso ?></td>
                                <td><?= date('d/m/Y à\s H:i:s', strtotime($record->hora)) ?></td>
                                <td>
                                    <a href="confirmTime.php?idTime=<?= $record->idHistorico ?>">
                                        <button type="button"><i class='bx bxs-trash'></i></button>
                                    </a>
                                </td> 
                            </tr>   
                        <?php } // close foreach
                    }   // close if
                ?>  
                <!-- --------------------------------------------------- -->
                </tbody>
            </table>
        </article>     
    </main>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $('.data').mask('00/00/0000');
    </script>

<?php 
    include __DIR__.'/includes/footer.php';
?>
