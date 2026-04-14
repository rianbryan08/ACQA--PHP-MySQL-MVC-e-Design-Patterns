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
            $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

            if (isset($post) && $post['SendPostForm']):
                $post['config_logo'] = ( $_FILES['config_logo']['tmp_name'] ? $_FILES['config_logo'] : 'null' );
                unset($post['SendPostForm']);

                $cadastra = new AdminConfig;
                $cadastra->ExeUpdate($postid, $post);

                WLMsg($cadastra->getError()[0], $cadastra->getError()[1]);
                header('Location: painel.php?exe=config/update&postid=' . $postid);
            else:
                $read = new Read;
                $read->ExeRead("ws_config", "WHERE config_id = :id", "id={$postid}");
                if (!$read->getResult()):
                    header('Location: painel.php?exe=config/index&empty=true');
                else:
                    $post = $read->getResult()[0];
                endif;
            //header('Location: painel.php?exe=posts/update&postid='.$postid);
            endif;
            //WLMsg("As configurações do sistema forma atualizados com sucesso!", WS_ACCEPT);
            ?>
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>Atualizar</h2>
                <div class="box-icon">
                    <a href="painel.php?exe=config/update&postid=<?= $postid; ?>" class="" title="Atualizar/Refresh na página"><i class="halflings-icon refresh"></i></a>
    <!--                <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>-->
                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
    <!--                <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>-->
                </div>
            </div>
            <div class="box-content">

                <div class="box span12">
                    <div class="box-header">
                        <h2><i class="halflings-icon th"></i><span class="break"></span>Configurações</h2>
                    </div>
                    <div class="box-content">
                        <ul class="nav tab-menu nav-tabs" id="myTab">
                            <li class="active"><a href="#info">Site</a></li>
                            <li><a href="#custom">Endereço/ Contato</a></li>
                            <li><a href="#messages">E-mail</a></li>
                        </ul>
                        <form class="form-horizontal" name="PostForm" action="" method="post" enctype="multipart/form-data">	 
                            <fieldset>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane active" id="info">
                                        <div class="control-group">
                                            <label class="control-label" for="fileInput">Enviar Logomarca</label>
                                            <div class="controls">
                                                <input class="input-file uniform_on" id="fileInput" type="file" name="config_logo">
                                            </div>
                                        </div> 

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadt">Título </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" required="required" id="typeaheadt" name="config_title" value="<?php
                                                if (isset($post->config_title)): echo $post->config_title;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadd">Descrição </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadd" name="config_description" value="<?php
                                                if (isset($post->config_description)): echo $post->config_description;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadp">Palavras chaves </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadp" name="config_keywords" value="<?php
                                                if (isset($post->config_keywords)): echo $post->config_keywords;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 

                                    </div>
                                    <div class="tab-pane" id="custom">

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadte">Telefone </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead"id="typeaheadte" name="config_telefone" value="<?php
                                                if (isset($post->config_telefone)): echo $post->config_telefone;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadte2">Telefone 2</label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead"id="typeaheadte2" name="config_telefone2" value="<?php
                                                if (isset($post->config_telefone2)): echo $post->config_telefone2;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheade2">E-mail</label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead"id="typeaheade2" name="config_email" value="<?php
                                                if (isset($post->config_email)): echo $post->config_email;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadfa">Facebook</label>
                                            <div class="controls">
                                                <input type="url" placeholder="https://facebook.com" class="span6 typeahead"id="typeaheadfa" name="config_facebook" value="<?php
                                                if (isset($post->config_facebook)): echo $post->config_facebook;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadin">Instagram</label>
                                            <div class="controls">
                                                <input type="url" placeholder="https://instagram.com" class="span6 typeahead"id="typeaheadinn" name="config_instagram" value="<?php
                                                if (isset($post->config_instagram)): echo $post->config_instagram;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadin">Youtube</label>
                                            <div class="controls">
                                                <input type="url" placeholder="https://youtube.com" class="span6 typeahead"id="typeaheadinn" name="config_youtube" value="<?php
                                                if (isset($post->config_youtube)): echo $post->config_youtube;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <hr>
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadce">CEP </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadce" name="config_cep" value="<?php
                                                if (isset($post->config_cep)): echo $post->config_cep;
                                                endif;
                                                ?>">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheaden">Endereço/ Rua</label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead"id="typeaheaden" name="config_endereco" value="<?php
                                                if (isset($post->config_endereco)): echo $post->config_endereco;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadnu">Número  </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadnu" name="config_numero" value="<?php
                                                if (isset($post->config_numero)): echo $post->config_numero;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadco">Complemento </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadco" name="config_complemento" value="<?php
                                                if (isset($post->config_complemento)): echo $post->config_complemento;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadba">Bairro </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadba" name="config_bairro" value="<?php
                                                if (isset($post->config_bairro)): echo $post->config_bairro;
                                                endif;
                                                ?>">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="selectError">Estado </label>
                                            <div class="controls">
                                                <select id="selectError" data-rel="chosen" name="config_estado">
                                                    <option value="" selected> Selecione o estado </option>
                                                    <?php
                                                    $readState = new Read;
                                                    $readState->ExeRead("app_estados", "ORDER BY estado_nome ASC");
                                                    foreach ($readState->getResult() as $estado):
                                                        echo "<option value=\"{$estado->estado_uf}\" ";
                                                        if (isset($post->config_estado) && $post->config_estado == $estado->estado_uf): echo 'selected';
                                                        endif;
                                                        echo "> {$estado->estado_uf} / {$estado->estado_nome} </option>";
                                                    endforeach;
                                                    ?>                
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="selectErrorc">Cidade</label>
                                            <div class="controls">
                                                <select id="selectErrorc" data-rel="chosen" name="config_cidade">
                                                    <option value="" selected> Digite sua Cidade </option>
                                                    <?php
                                                    $readState = new Read;
                                                    $readState->ExeRead("app_cidades", "ORDER BY cidade_nome ASC");
                                                    foreach ($readState->getResult() as $cidade):
                                                        echo "<option value=\"{$cidade->cidade_nome}\" ";
                                                        if (isset($post->config_cidade) && $post->config_cidade == $cidade->cidade_nome): echo 'selected';
                                                        endif;
                                                        echo ">{$cidade->cidade_nome} </option>";
                                                    endforeach;
                                                    ?>                
                                                </select>
                                            </div>
                                        </div>
                                         <div class="control-group">
                                            <label class="control-label" for="typeaheadba">Link do Mapa</label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadba" name="config_mapa" value="<?php
                                                if (isset($post->config_mapa)): echo $post->config_mapa;
                                                endif;
                                                ?>">
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="tab-pane" id="messages">
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadho">Hostname </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead"id="typeaheadho" name="config_hostname" value="<?php
                                                if (isset($post->config_hostname)): echo $post->config_hostname;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheades">Usuário/ E-mail </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheades" name="config_user" value="<?php
                                                if (isset($post->config_user)): echo $post->config_user;
                                                endif;
                                                ?>">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadsen">Senha </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead"id="typeaheadsen" name="config_password" value="<?php
                                                if (isset($post->config_password)): echo $post->config_password;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                        <div class="control-group">
                                            <label class="control-label" for="typeaheadpo">Porta </label>
                                            <div class="controls">
                                                <input type="text" class="span6 typeahead" id="typeaheadpo" name="config_port" value="<?php
                                                if (isset($post->config_port)): echo $post->config_port;
                                                endif;
                                                ?>">
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="form-actions">

                                    <input type="submit" class="btn btn-primary blue" value="Atualizar" name="SendPostForm" />
                                    <button type="reset" class="btn">Limpar</button>
                                </div>
                            </fieldset>
                        </form>   
                    </div>
                </div><!--/span-->


            </div>
        </div><!--/span-->

    </div><!--/row-->
<?php endif;
