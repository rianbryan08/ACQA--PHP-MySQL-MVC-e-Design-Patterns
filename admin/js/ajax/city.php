<?php

require('../../conexao/conexao.php');

$estado = (int) strip_tags(trim($_POST['estado']));
$readCityes = new Read;
$readCityes->ExeRead("app_cidades", "WHERE estado_id = :uf", "uf={$estado}");

sleep(1);

echo "<option value=\"\" disabled selected> Selecione a cidade </option>";
foreach ($readCityes->getResult() as $cidades):
    echo "<option value=\"{$cidades->cidade_id}\"> {$cidades->cidade_nome} </option>";
endforeach;
