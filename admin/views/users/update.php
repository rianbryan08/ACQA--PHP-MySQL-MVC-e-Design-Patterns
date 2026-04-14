<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
if ($userlogin->user_level < 3):
     WLMsg("Você não tem permissão para acessar esta página! <a href=\"javascript:history.back()\" class=\"btn btn-danger\">Voltar</a>", WS_ALERT);
else:
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
        $userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

        if ($ClienteData && $ClienteData['SendPostForm']):
            unset($ClienteData['SendPostForm']);

            $cadastra = new AdminUser;
            $cadastra->ExeUpdate($userId, $ClienteData);

            WLMsg($cadastra->getError()[0], $cadastra->getError()[1]);
        else:
            $ReadUser = new Read;
            $ReadUser->ExeRead("ws_users", "WHERE user_id = :userid", "userid={$userId}");
            if (!$ReadUser->getResult()):

            else:
                $ClienteData = $ReadUser->getResult()[0];
                unset($ClienteData->user_password);
            endif;
        endif;

        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if ($checkCreate && empty($cadastra)):
            WLMsg("O usuário <b>{$ClienteData->user_name}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT);
        endif;
        ?>
<div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Cadastrar</h2>
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
                                   value="<?php if (!empty($ClienteData->user_name)) echo $ClienteData->user_name; ?>"
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
                                   value="<?php if (!empty($ClienteData->user_lastname)) echo $ClienteData->user_lastname; ?>"
                                   title = "Informe seu sobrenome"
                                   required>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="email">E-mail </label>
                        <div class="controls">
                            <input class="span6 typeahead" required id="email" type = "email"
                                   name = "user_email"
                                   value="<?php if (!empty($ClienteData->user_email)) echo $ClienteData->user_email; ?>"
                                   title = "Informe seu e-mail"
                                   required>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="senha">Senha </label>
                        <div class="controls">
                            <input class="span6 typeahead" id="senha" type = "password"
                                   name = "user_password"
                                   value="<?php if (!empty($ClienteData->user_password)) echo $ClienteData->user_password; ?>"
                                   title = "Informe sua senha [ de 6 a 12 caracteres! ]"
                                   pattern = ".{6,12}">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="selectError">Nível</label>
                        <div class="controls">
                            <select id="selectError" data-rel="chosen" name="user_level">
                                <option value = "">Selecione o Nível</option>
                                <option value = "1" <?php if (isset($ClienteData->user_level) && $ClienteData->user_level == 1) echo 'selected="selected"'; ?>>User</option>
                                <option value="2" <?php if (isset($ClienteData->user_level) && $ClienteData->user_level == 2) echo 'selected="selected"'; ?>>Editor</option>
                                <option value="3" <?php if (isset($ClienteData->user_level) && $ClienteData->user_level == 3) echo 'selected="selected"'; ?>>Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary blue" value="Atualizar Usuário" name="SendPostForm" />
                        <button type="reset" class="btn">Limpar</button>
                    </div>
            </form>

        </div>
    </div><!--/span-->

</div><!--/row-->
<?php endif;