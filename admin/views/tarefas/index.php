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
    <li><a href="<?php echo ADMIN; ?>/painel.php?exe=tarefas/index">Tarefas</a></li>
</ul>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon list-alt"></i><span class="break"></span>Tarefas</h2>
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
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    $Check = new Check;
                    $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
                    if ($empty):
                        WLMsg("Oppsss: Você tentou editar um post que não existe no sistema!", WS_INFOR);
                    endif;


                    $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
                    if ($action):

                        $postAction = filter_input(INPUT_GET, 'post', FILTER_VALIDATE_INT);
                        $postUpdate = new AdminPost;

                        switch ($action):
                            case 'active':
                                $postUpdate->ExeStatus($postAction, '1');
                                WLMsg("O status da tarefa foi atualizado para <b>ativo</b>. Tarefa publicada!", WS_ACCEPT);
                                break;

                            case 'inative':
                                $postUpdate->ExeStatus($postAction, '0');
                                WLMsg("O status da tarefa foi atualizado para <b>inativo</b>. Tarefa agora é um rascunho!", WS_ALERT);
                                break;

                            case 'delete':
                                $postUpdate->ExeDelete($postAction);
                                WLMsg($postUpdate->getError()[0], $postUpdate->getError()[1]);
                                break;

                            default :
                                WLMsg("Ação náo foi identificado pelo sistema, favor utilize os botões!", WS_ALERT);
                        endswitch;
                    endif;


                    $posti = 0;
                    $type = 'tarefa';
                    $readPosts = new Read;
                    $readPosts->ExeRead("ws_posts", "WHERE post_type = :type ORDER BY post_status ASC, post_date DESC", "type={$type}");
                    if ($readPosts->getResult()):
                        foreach ($readPosts->getResult() as $post):
                            $posti++;
                            $status = (!$post->post_status ? 'warning' : 'success');
                            $status_text = (!$post->post_status ? 'Inativo' : 'Ativo');
                            ?>
                            <tr<?php if ($posti % 2 == 0) echo ''; ?>>
                                <td><?= $post->post_title; ?></td>
                                <td class="center"><?= date('d/m/Y', strtotime($post->post_date)); ?></td>
                                <td class="center">
                                    <span class="label label-<?= $status; ?>"><?= $status_text; ?></span>
                                </td>
                                <td class="center">
                                    <?php if (!$post->post_status): ?>
                                        <a class="btn btn-danger" href="painel.php?exe=tarefas/index&post=<?= $post->post_id; ?>&action=active" title="Status <?= $status_text; ?> (Clique para ativar)">
                                            <i class="halflings-icon white minus"></i>                                            
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn-success" href="painel.php?exe=tarefas/index&post=<?= $post->post_id; ?>&action=inative" title="Status <?= $status_text; ?> (Clique para desativar)">
                                            <i class="halflings-icon white check"></i>                                            
                                        </a>
                                    <?php endif; ?>

                                   
                                    <a class="btn btn-info" href="painel.php?exe=tarefas/update&postid=<?= $post->post_id; ?>" title="Editar este Post">
                                        <i class="halflings-icon white edit"></i>   
                                    </a>
                                    <a class="btn btn-danger" href="painel.php?exe=tarefas/index&post=<?= $post->post_id; ?>&action=delete" title="Excluir este Post">
                                        <i class="halflings-icon white trash"></i> 
                                    </a>
                                </td>
                            </tr>
                            <?php
                        endforeach;

                    else:
                        WLMsg("Desculpe, ainda não existem tarefas cadastradas!", WS_INFOR);
                    endif;
                    ?>
                </tbody>
            </table>            
        </div>
    </div><!--/span-->

</div><!--/row-->
