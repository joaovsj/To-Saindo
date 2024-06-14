<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxe Icons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://kit.fontawesome.com/219248cbde.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="resources/css/styles.css">
    <link rel="stylesheet" href="resources/css/panel.css">
    <title>Tô Saindo</title>
</head>
<body>
    <div class="sidebar">
        <div class="logoContent">
            <div class="logo">
                <i class='bx bx-message-square-dots'></i>
                <div class="logoName">Tô Saindo</div>
            </div>   <!-- logo -->
        
        <i class='bx bx-menu' id="btn"></i>
        </div> <!-- logoContent -->

        <ul class="nav_list">
            <li>
                <a href="panel.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Minha Conta</span>
                    <span class="toolipe">Minha Conta</span>
                </a>
            </li>
            <li>
                <a href="rooms.php">
                    <i class='bx bx-category-alt'></i>
                    <span class="links_name">Salas</span>
                    <span class="toolipe">Salas</span>
                </a>
            </li>
            <li>
                <a href="report.php">
                    <i class='bx bx-folder-open'></i>
                    <span class="links_name">Histórico</span>
                    <span class="toolipe">Histórico</span>
                </a>
            </li>
            <li>
                <a href="guards.php">
                    <i class='bx bx-group'></i>
                    <span class="links_name">Guardas</span>
                    <span class="toolipe">Guardas</span>
                </a>
            </li>
        </ul>         <!-- nav list-->

        <div class="profileContent">
            <div class="profile">
                <div class="profileDetails">
                    <a href="admin/closeAdmin.php">
                        <i class='bx bx-message-square-x'></i>
                        <span class="links_name">Sair</span>
                    </a>
                </div>  <!--  profileDetails  --> 
            </div>      <!--  profile  --> 
        </div>          <!--  profileContent  -->
    </div>            <!-- sidebar -->