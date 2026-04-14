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
        <a href="<?php echo ADMIN; ?>">Home</a>
        <i class="icon-angle-right"></i> 
    </li>
    <li>
        <i class="icon-edit"></i>
        <a href="#">Aualizar</a>
    </li>
</ul>


<div class="row-fluid sortable">
    <div class="box span12">
        

        <?php
        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $userId = $userlogin->user_id;

        if ($ClienteData && $ClienteData['SendPostForm']):
            unset($ClienteData['SendPostForm']);

            $cadastra = new AdminUser;
            $cadastra->ExeUpdate($userId, $ClienteData);

            if ($cadastra->getResult()):
                WLMsg("Seus dados foram atualizados com sucesso! <i>O sistema será atualizado no próximo login!!!</i>", WS_ACCEPT);
            else:
                WLMsg($cadastra->getError()[0], $cadastra->getError()[1]);
            endif;
        else:
            $userlogin;
        endif;
        ?>


<div class="box-header" data-original-title>
           
            <h2><i class="halflings-icon user"></i><span class="break"></span>Olá <?= "{$userlogin->user_name} {$userlogin->user_lastname}"; ?>, atualize seu perfíl!</h2>
            <div class="box-icon">
                   <a href="painel.php?exe=users/update&userid=<?=$userId;?>" class="" title="Atualizar/Refresh na página"><i class="halflings-icon refresh"></i></a>
<!--                <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>-->
                <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
<!--                <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>-->
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" name="UserCreateForm" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="nome">Nome </label>
                        <div class="controls">
                            <input class="span6 typeahead" required id="nome" type = "text"
                                   name = "user_name"
                                   value="<?= $userlogin->user_name; ?>"
                                   title = "Informe seu primeiro nome"
                                   required>
               <!--                                <input type="text" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" data-source='["Array"]'>-->
               <!--                                <p class="help-block">Start typing to activate auto complete!</p>-->
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="sobrenome">Sobrenome </label>
                        <div class="controls">
                            <input class="span6 typeahead" required id="sobrenome" type = "text"
                                   name = "user_lastname"
                                   value="<?= $userlogin->user_lastname; ?>"
                                   title = "Informe seu sobrenome"
                                   required>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="email">E-mail </label>
                        <div class="controls">
                            <input class="span6 typeahead" required id="email" type = "email"
                                   name = "user_email"
                                   value="<?= $userlogin->user_email; ?>"
                                   title = "Informe seu e-mail"
                                   required>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="senha">Senha </label>
                        <div class="controls">
                            <input class="span6 typeahead" id="senha" type = "password"
                                   name = "user_password"
                                   value=""
                                   title = "Informe sua senha [ de 6 a 12 caracteres! ]"
                                   pattern = ".{6,12}">
                        </div>
                    </div>


                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary blue" value="Atualizar Perfil" name="SendPostForm" />
                        <button type="reset" class="btn">Limpar</button>
                    </div>
            </form>

        </div>
    </div><!--/span-->

</div><!--/row-->