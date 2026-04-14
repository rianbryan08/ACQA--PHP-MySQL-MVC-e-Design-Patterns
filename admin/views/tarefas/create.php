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
            <a href="#">Cadastrar</a>
        </li>
    </ul>


    <div class="row-fluid sortable">
        <div class="box span12">
            <?php
            
            $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if (isset($post) && $post['SendPostForm']):
                $post['post_status'] = ($post['SendPostForm'] == 'Cadastrar' ? '0' : '1' );
                $post['post_cover'] = ( $_FILES['post_cover']['tmp_name'] ? $_FILES['post_cover'] : null );
                $post['post_type'] = $paginasRecuperada;
                unset($post['SendPostForm']);

                $cadastra = new AdminPost;
                $cadastra->ExeCreate($post);

                if ($cadastra->getResult()):
                    if (!empty($_FILES['gallery_covers']['tmp_name'])):
                        $sendGallery = new AdminPost;
                        $sendGallery->gbSend($_FILES['gallery_covers'], $cadastra->getResult());
                    endif;

                    header('Location: painel.php?exe=tarefas/update&create=true&postid=' . $cadastra->getResult());
                else:
                    WLMsg($cadastra->getError()[0], $cadastra->getError()[1]);
                endif;
            endif;
            ?>
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>Cadastrar</h2>
                <div class="box-icon">
<!--                    <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>-->
                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
<!--                    <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>-->
                </div>
            </div>
            <div class="box-content">

                <form class="form-horizontal" name="PostForm" action="" method="post" enctype="multipart/form-data">
                    <fieldset>
                         
                        <div class="control-group">
                            <label class="control-label" for="typeahead">Título </label>
                            <div class="controls">
                                <input type="text" class="span6 typeahead" required id="typeahead" name="post_title" value="<?php if (isset($post['post_title'])): echo $post['post_title'];
            endif; ?>">
                            </div>
                        </div>   
                        
                        <div class="control-group">
                            <label class="control-label" for="textarea2">Conteúdo WYSIWYG</label>
                            <div class="controls">
                                <textarea class="cleditor" id="textarea2" rows="3" name="post_content"><?php if (isset($post['post_content'])): echo htmlspecialchars($post['post_content']);
            endif; ?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date01">Data</label>
                            <div class="controls">
                                <input type="text" class="formDate input-xlarge" id="date01" name="post_date" value="<?php
                                if (isset($post['post_date'])): echo $post['post_date'];
                                else: echo date('d/m/Y H:i:s');
                                endif;
                                ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="selectError">Autor</label>
                            <div class="controls">
                                <select id="selectError" data-rel="chosen" name="post_author">
                                    <option value="<?= "{$userlogin->user_id}" ?>"><?= "{$userlogin->user_name} {$userlogin->user_lastname}" ?></option>
                                    <?php
                                    $readAut = new Read;
                                    $readAut->ExeRead("ws_users", "where user_id != :id and user_level >= :level order by user_name asc", "id={$userlogin->user_id}&level=2");
                                    if ($readAut->getRowCount() >= 1):
                                        foreach ($readAut->getResult() as $autor):
                                            echo "<option ";
                                            if ($post['post_author'] == $autor->user_id):
                                                echo "selected=\"selected\" ";
                                            endif;
                                            echo "value=\"{$autor->user_id}\">{$autor->user_name} {$autor->user_lastname}</option>";
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        


                        <div class="form-actions">

                            <input type="submit" class="btn btn-primary blue" value="Cadastrar" name="SendPostForm" />
                            <input type="submit" class="btn btn-primary green" value="Cadastrar & Publicar" name="SendPostForm" />
                            <button type="reset" class="btn">Limpar</button>
                        </div>
                    </fieldset>
                </form>   

            </div>
        </div><!--/span-->

    </div><!--/row-->




