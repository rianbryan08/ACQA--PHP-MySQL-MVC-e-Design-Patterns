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
    <li><a href="<?php echo ADMIN; ?>/painel.php?exe=users/index">Usuários</a></li>
</ul>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon list-alt"></i><span class="break"></span>Usuários</h2>
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
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Nível</th>
                        <th>Ações</th>
                    </tr>
                </thead>   
                <tbody>

                    <?php
                    $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
                    if ($delete):
                        $delUser = new AdminUser;
                        $delUser->ExeDelete($delete);
                        WLMsg($delUser->getError()[0], $delUser->getError()[1]);
                    endif;
                    ?>

                    <?php
                    $Check = new Check;
                    $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
                    if ($empty):
                        WLMsg("Oppsss: Você tentou editar um usuário que não existe no sistema!", WS_INFOR);
                    endif;


                    $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
                    if ($action):

                        $userAction = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                        $userUpdate = new AdminUser;

                        switch ($action):
                            case 'active':
                                $userUpdate->ExeStatus($userAction, '1');
                                WLMsg("O status do usuário foi atualizado para <b>ativo</b>. Post publicado!", WS_ACCEPT);
                                break;

                            case 'inative':
                                $userUpdate->ExeStatus($userAction, '0');
                                WLMsg("O status do usuário foi atualizado para <b>inativo</b>.!", WS_ALERT);
                                break;

                            case 'delete':
                                $userUpdate->ExeDelete($userAction);
                                WLMsg($userUpdate->getError()[0], $userUpdate->getError()[1]);
                                break;

                            default :
                                WLMsg("Ação náo foi identificado pelo sistema, favor utilize os botões!", WS_ALERT);
                        endswitch;
                    endif;

                    $read = new Read;
                    $read->ExeRead("ws_users", "ORDER BY user_level DESC, user_name ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):

                            $user->user_lastupdate = ($user->user_lastupdate ? date('d/m/Y H:i', strtotime($user->user_lastupdate)) . '' : '-');
                            $nivel = ['', 'User', 'Editor', 'Admin'];
                            $status = (!$user->user_status ? 'Inativo' : 'Ativo');
                            ?>   

                            <tr>
                                <td class="center"><?= $user->user_name . ' ' . $user->user_lastname; ?></td>
                                <td class="center"><?= $user->user_email; ?></td>
                                <td class="center"><?= $nivel[$user->user_level]; ?></td>
                                <td class="center">
                                    <?php
                                    if ($userlogin->user_level < 3):
                                        WLMsg("Sem permissões", WS_ALERT);
                                    else:
                                        
                                        ?> 

            <?php if (!$user->user_status): ?>
                                            <a class="btn btn-danger" href="painel.php?exe=users/index&user=<?= $user->user_id; ?>&action=active" title="Status <?= $status; ?> (Clique para ativar)">
                                                <i class="halflings-icon white minus"></i>                                            
                                            </a>
            <?php else: ?>
                                            <a class="btn btn-success" href="painel.php?exe=users/index&user=<?= $user->user_id; ?>&action=inative" title="Status <?= $status; ?> (Clique para desativar)">
                                                <i class="halflings-icon white check"></i>                                            
                                            </a>
            <?php endif; ?>

                                        <a class="btn btn-info" href="painel.php?exe=users/update&userid=<?= $user->user_id; ?>" title="Editar este Usuário">
                                            <i class="halflings-icon white edit"></i>   
                                        </a>
                                        <a class="btn btn-danger" href="painel.php?exe=users/index&delete=<?= $user->user_id; ?>&action=delete" title="Excluir este Usuário">
                                            <i class="halflings-icon white trash"></i> 
                                        </a>

                                    <?php endif;
                                    ?>
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
