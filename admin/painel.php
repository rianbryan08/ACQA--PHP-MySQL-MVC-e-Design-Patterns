<?php include_once("_inc/header.php"); ?>

<!-- start: Content -->
<div id="content" class="span10">
    <?php
    //QUERY STRING
    if (!empty($getexe)):
        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
    else:
        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'home.php';
    endif;

    if (file_exists($includepatch)):
        require_once($includepatch);
    else:
        echo "<div class=\"content notfound\">";
        WLMsg("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
        echo "</div>";
    endif;
    ?>

</div>
<!-- /#page-wrapper -->

<?php include_once("_inc/footer.php"); ?>