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
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

        if (isset($post) && $post['SendPostForm']):
            $post['post_status'] = ($post['SendPostForm'] == 'Atualizar' ? '0' : '1' );
            $post['post_cover'] = ( $_FILES['post_cover']['tmp_name'] ? $_FILES['post_cover'] : 'null' );
            $post['post_type'] = $paginasRecuperada;
            unset($post['SendPostForm']);

            $cadastra = new AdminPost;
            $cadastra->ExeUpdate($postid, $post);
           
                WLMsg($cadastra->getError()[0], $cadastra->getError()[1]);
           
            if (!empty($_FILES['gallery_covers']['tmp_name'])):
                $sendGallery = new AdminPost;
                $sendGallery->gbSend($_FILES['gallery_covers'], $postid);
            endif;

        else:
            $read = new Read;
            $read->ExeRead("ws_posts", "WHERE post_id = :id", "id={$postid}");
            if (!$read->getResult()):
                header('Location: painel.php?exe=eventos/index&empty=true');
            else:
                $post = $read->getResult()[0];
                $post->post_date = date('d/m/Y H:i:s', strtotime($post->post_date));
                
            endif;
            //header('Location: painel.php?exe=posts/update&postid='.$postid);
        endif;

        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if ($checkCreate && empty($cadastra)):
            WLMsg("O evento <b>{$post->post_title}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT);
        endif;
        ?>
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Atualizar</h2>
            <div class="box-icon">
                <a href="painel.php?exe=eventos/update&postid=<?=$postid;?>" class="" title="Atualizar/Refresh na página"><i class="halflings-icon refresh"></i></a>
<!--                <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>-->
                <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
<!--                <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>-->
            </div>
        </div>
        <div class="box-content">

            <form class="form-horizontal" name="PostForm" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                     
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nome do Evento </label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" required id="typeahead" name="post_title" value="<?php
                            if (isset($post->post_title)): echo $post->post_title;
                            endif;
                            ?>">
                        </div>
                    </div>  
                    
                    <div class="control-group">
                        <label class="control-label" for="textarea2">Conteúdo WYSIWYG</label>
                        <div class="controls">
                            <textarea class="cleditor" id="textarea2" rows="3" name="post_content"><?php
                                if (isset($post->post_content)): echo htmlspecialchars($post->post_content);
                                endif;
                                ?></textarea> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="date01">Data do Evento</label>
                        <div class="controls">
                            <input type="text" class="formDate input-xlarge" id="date01" name="post_date" value="<?php
                            if (isset($post->post_date)): echo $post->post_date;
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
                                        if ($post->post_author == $autor->user_id):
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

                        <input type="submit" class="btn btn-primary blue" value="Atualizar" name="SendPostForm" />
                        <input type="submit" class="btn btn-primary green" value="Atualizar & Publicar" name="SendPostForm" />
                        <button type="reset" class="btn">Limpar</button>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->




