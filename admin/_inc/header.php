<?php
ob_start();
include_once("conexao/conecta.php");

$login = new Login(3);
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$Limpa = filter_input(INPUT_GET, 'limpacache', FILTER_DEFAULT);
if (!empty($Limpa) && $Limpa == true):
    $limparcache = Funcoes::LimparCache();
endif;

if (!$login->CheckLogin()):
    unset($_SESSION['userAdminlogin']);
    header('Location: index.php?exe=restrito');
else:
    $readUsuarios = new Read;
    $readUsuarios->ExeRead(PREFIX . "users", "WHERE user_id = :id", "id={$_SESSION['userAdminlogin']->user_id}");
    if ($readUsuarios->getResult()):
        $userlogin = $readUsuarios->getResult()[0];
    endif;

endif;

if ($logoff):
    unset($_SESSION['userAdminlogin']);
    header('Location: index.php?exe=logoff');
endif;
if (isset($getexe)):
    $linkto = explode('/', $getexe);
    $paginaSemSnoFinal = explode('/', $getexe);
    $paginasRecuperada = $funcoes->tirarUltimoCaracter($paginaSemSnoFinal[0]);

else:
    $linkto = array();
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- start: Meta -->
        <meta charset="utf-8">
        <title>Painel de Administração</title>
        <!-- end: Meta -->
        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- end: Mobile Specific -->
        <!-- start: CSS -->
        <link id="bootstrap-style" href="<?php echo ADMIN; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo ADMIN; ?>/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link id="base-style" href="<?php echo ADMIN; ?>/css/style.css" rel="stylesheet">
        <link id="base-style-responsive" href="<?php echo ADMIN; ?>/css/style-responsive.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
        <!-- end: CSS -->
        <script src="<?php echo ADMIN; ?>/js/jmask.js"></script>
        <script src="<?= ADMIN ?>/js/cep.js" type="text/javascript"></script>
        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <link id="ie-style" href="css/ie.css" rel="stylesheet">
        <![endif]-->
        <!--[if IE 9]>
                <link id="ie9style" href="css/ie9.css" rel="stylesheet">
        <![endif]-->
        <!-- start: Favicon -->
        <link rel="shortcut icon" href="<?php echo ADMIN; ?>/img/favicon.ico">
        <!-- end: Favicon -->
    </head>
    <body>
        <!-- start: Header -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?php echo ADMIN; ?>/"><span>ProjetoFacul</span></a>

                    <!-- start: Header Menu -->
                    <div class="nav-no-collapse header-nav">
                        <ul class="nav pull-right">
                            <!-- start: User Dropdown -->
                            <li class="dropdown">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="halflings-icon white user"></i> <?= ucfirst($userlogin->user_name); ?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-menu-title">
                                        <span>Configurações Gerais</span>
                                    </li>
                                    <li><a href="<?php echo ADMIN; ?>/painel.php?exe=users/profile"><i class="halflings-icon user"></i> Perfil</a></li>
                                    <li><a href="<?php echo ADMIN; ?>/painel.php?limpacache=true"><i class="halflings-icon refresh"></i> Limpar Cache</a></li>
                                    <li><a href="<?php echo ADMIN; ?>/painel.php?logoff=true"><i class="halflings-icon off"></i> Logout</a></li>
                                </ul>
                            </li>
                            <!-- end: User Dropdown -->
                        </ul>
                    </div>
                    <!-- end: Header Menu -->

                </div>
            </div>
        </div>
        <div class="container-fluid-full">
            <div class="row-fluid">
                <!-- start: Main Menu -->
                <div id="sidebar-left" class="span2">
                    <div class="nav-collapse sidebar-nav">
                        <ul class="nav nav-tabs nav-stacked main-menu">
                            <li><a href="<?php echo ADMIN; ?>/"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>	
                     
                            <li>
                                <a class="dropmenu" href="#"><i class="icon-edit"></i><span class="hidden-tablet"> Tarefas</span></a>
                                <ul>
                                    <li>
                                        <a href="<?php echo ADMIN; ?>/painel.php?exe=tarefas/create">&nbsp; &nbsp; &raquo; Cadastrar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN; ?>/painel.php?exe=tarefas/index">&nbsp; &nbsp; &raquo; Listar/Buscar</a>
                                    </li>
                                </ul>	
                            </li>
                            <li>
                                <a class="dropmenu" href="#"><i class="icon-calendar"></i><span class="hidden-tablet"> Eventos</span></a>
                                <ul>
                                    <li>
                                        <a href="<?php echo ADMIN; ?>/painel.php?exe=eventos/create">&nbsp; &nbsp; &raquo; Cadastrar</a>
                                    </li>
                                    <li>  
                                        <a href="<?php echo ADMIN; ?>/painel.php?exe=eventos/index">&nbsp; &nbsp; &raquo; Listar/Buscar</a>
                                    </li>
                                </ul>	
                            </li>
                            <li>
                                <a class="dropmenu" href="#"><i class="icon-user"></i><span class="hidden-tablet"> Usuários</span></a>
                                <ul>
                                    <li>
                                        <a href="<?php echo ADMIN; ?>/painel.php?exe=users/create">&nbsp; &nbsp; &raquo; Cadastrar</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ADMIN; ?>/painel.php?exe=users/index">&nbsp; &nbsp; &raquo; Listar/Buscar</a>
                                    </li>
                                </ul>	
                            </li>
                          
                           
                             </ul>
                    </div>
                </div>
                <!-- end: Main Menu -->

                <noscript>
                <div class="alert alert-block span10">
                    <h4 class="alert-heading">Warning!</h4>
                    <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
                </div>
                </noscript>