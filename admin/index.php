<?php ob_start(); include_once("conexao/conecta.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <!-- start: Meta -->
        <meta charset="utf-8">
        <title>Login - Painel de Administração</title>
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

        <style type="text/css">
            body { background: url(<?php echo ADMIN; ?>/img/bg-login.jpg) !important; }
        </style>

    </head>

    <body>
        <div class="container-fluid-full">
            <div class="row-fluid">
                <?php
                $login = new Login(3);
                $funcoes = new Funcoes;

                if ($login->CheckLogin()):
                    $funcoes->redirect(ADMIN . '/painel.php');
                endif;

                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($dataLogin['AdminLogin'])):

                    $login->ExeLogin($dataLogin);
                    if (!$login->getResult()):
                        WLMsg($login->getError()[0], $login->getError()[1]);
                    else:
                        WLMsg($login->getError()[0], $login->getError()[1]);
                        $funcoes->refresh(2, ADMIN . '/painel.php');
                    endif;

                endif;

                $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                if (!empty($get)):
                    if ($get == 'restrito'):
                        WLMsg('<b>Oppsss:</b> Acesso negado. Favor efetue login para acessar o painel!', WS_ALERT);
                    elseif ($get == 'logoff'):
                        WLMsg('<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!', WS_ACCEPT);
                    endif;
                endif;
                ?>

                <div class="row-fluid">
                    <div class="login-box">
                        <div class="icons">
                            <a href=""><i class="halflings-icon home"></i></a>
                            <a href="#"><i class="halflings-icon cog"></i></a>
                        </div>
                        <h2>Painel de Administração</h2>
                        <form class="form-horizontal" action="" method="post">
                            <fieldset>

                                <div class="input-prepend" title="E-mail">
                                    <span class="add-on"><i class="halflings-icon user"></i></span>
                                    <input class="input-large span10" name="user" id="username" type="email" placeholder="E-mail" required="required"/>
                                </div>
                                <div class="clearfix"></div>

                                <div class="input-prepend" title="Senha">
                                    <span class="add-on"><i class="halflings-icon lock"></i></span>
                                    <input class="input-large span10" name="pass" id="password" type="password" placeholder="Senha" required="required"/>
                                </div>
                                <div class="clearfix"></div>


                                <div class="button-login">	
                                    <button type="submit" class="btn btn-primary">Login</button>
                                    <input type="hidden" value="Login" name="AdminLogin">
                                </div>
                                <div class="clearfix"></div>
                        </form>
                        <hr>
                        <h3>Esqueceu a senha?</h3>
                        <p>
                            Sem problemas, <a href="#">clique aqui</a> e crie sua nova senha.
                        </p>	
                    </div><!--/span-->
                </div><!--/row-->

            </div><!--/.fluid-container-->

        </div><!--/fluid-row-->

        <!-- start: JavaScript-->

        <script src="<?php echo ADMIN; ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery-migrate-1.0.0.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery-ui-1.10.0.custom.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.ui.touch-punch.js"></script>
        <script src="<?php echo ADMIN; ?>/js/modernizr.js"></script>
        <script src="<?php echo ADMIN; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.cookie.js"></script>
        <script src='<?php echo ADMIN; ?>/js/fullcalendar.min.js'></script>
        <script src='<?php echo ADMIN; ?>/js/jquery.dataTables.min.js'></script>
        <script src="<?php echo ADMIN; ?>/s/excanvas.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.flot.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.flot.pie.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.flot.stack.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.flot.resize.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.chosen.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.uniform.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.cleditor.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.noty.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.elfinder.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.raty.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.iphone.toggle.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.uploadify-3.1.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.gritter.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.imagesloaded.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.masonry.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.knob.modified.js"></script>
        <script src="<?php echo ADMIN; ?>/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo ADMIN; ?>/js/counter.js"></script>
        <script src="<?php echo ADMIN; ?>/js/retina.js"></script>
        <script src="<?php echo ADMIN; ?>/js/custom.js"></script>
        <!-- end: JavaScript-->

    </body>
</html>
<?php
ob_end_flush();