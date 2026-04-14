<?php
if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

//OBJETO READ
$read = new Read;

//VISITAS DO SITE
$read->FullRead("SELECT SUM(siteviews_views) AS views FROM ws_siteviews");
$Views = $read->getResult()[0]->views;

//USUÃ�RIOS
$read->FullRead("SELECT SUM(siteviews_users) AS users FROM ws_siteviews");
$Users = $read->getResult()[0]->users;

//USUÃ�RIOS
$read->FullRead("SELECT * FROM ws_users");
$Usuarios = $read->getRowCount();

//MENSAGENS
$read->FullRead("SELECT * FROM ws_mensagens WHERE msg_status <= 1");
$Mensagens = $read->getRowCount();

//MÃ‰DIA DE PAGEVIEWS
$read->FullRead("SELECT SUM(siteviews_pages) AS pages FROM ws_siteviews");
$ResPages = $read->getResult()[0]->pages;
$PageViews = substr($ResPages / $Users, 0, 5);

//POSTS
$post_type = 'galeria';
$read->ExeRead("ws_posts", "where post_type = :posts", "posts={$post_type}");
$Posts = $read->getRowCount();

//PÁGINA
$page_type = 'page';
$read->ExeRead("ws_posts", "where post_type = :pages", "pages={$page_type}");
$Pages = $read->getRowCount();

$page_type = 'post';
$read->ExeRead("ws_posts", "where post_type = :pages", "pages={$page_type}");
$Blog = $read->getRowCount();

//SERVIÇOS
$page_type = 'servico';
$read->ExeRead("ws_posts", "where post_type = :pages", "pages={$page_type}");
$Servicos = $read->getRowCount();

//EMPRESAS
$read->ExeRead("app_empresas");
$Empresas = $read->getRowCount();
?>
<!-- start: Content -->
<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="./">Home</a> 
        <i class="icon-angle-right"></i>
    </li>
    <li><a href="#">Dashboard</a></li>
</ul>

<div class="row-fluid">

    <div class="span3 statbox green" onTablet="span6" onDesktop="span3">
        <div class="boxchart">1,2,6,4,0,8,2,4,5,3,1,7,5</div>
        <div class="number"><?=$Usuarios?><i class="icon-arrow-up"></i></div>
        <div class="title">usuários</div>
        <div class="footer">
            <a href="#"> </a>
        </div>
    </div>
    	

</div>		


<hr>
<div class="clearfix"></div>


</div><!--/.fluid-container-->