<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<!-- start: Content -->

<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="./">Home</a> 
        <i class="icon-angle-right"></i>
    </li>
    <li><a href="<?php echo ADMIN; ?>/painel.php?exe=config/index">Configurações</a></li>
</ul>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon list-alt"></i><span class="break"></span>Configurações</h2>
            <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Ações</th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    $Check = new Check;
                    $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
                    if ($empty):
                        WLMsg("Oppsss: Você tentou editar uma configuração que não existe no sistema!", WS_INFOR);
                    endif;

                    $readPosts = new Read;
                    $readPosts->ExeRead("ws_config");
                    if ($readPosts->getResult()):
                        foreach ($readPosts->getResult() as $post):
                            ?>
                            <tr>
                                <td><?= $post->config_title; ?></td>
                                <td class="center">

                                    <a class="btn btn-info" href="painel.php?exe=config/update&postid=<?= $post->config_id; ?>" title="Editar este Post">
                                        <i class="halflings-icon white edit"></i>   
                                    </a>

                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>            
        </div>
    </div><!--/span-->

</div><!--/row-->
