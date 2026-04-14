<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Funcoes
 *
 * @author WEBLAB
 */
class Funcoes {

    /** CONSTROLE */
    private $Error;
    private $Result;
    private $LimpaCache;

    function curl_info($url) {
        $timeout = set_time_limit(100);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $content = curl_exec($ch);
        $info = curl_getinfo($ch);

        return $info;
    }

    function formatBytes($p_sFormatted) {
        $aUnits = ['B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8];
        $sUnits = strtoupper(trim(substr($p_sFormatted, -2)));
        if (intval($sUnits) != 0):
            $sUnits = 'B';
        endif;
        if (!in_array($sUnits, array_keys($aUnits))):
            return false;
        endif;
        $iUnits = trim(substr($p_sFormatted, 0));
        if (!intval($iUnits) == $iUnits):
            return false;
        endif;
        return $iUnits * pow(1024, $aUnits[$sUnits]);
    }

    function server($string) {
        return filter_input(INPUT_SERVER, "{$string}", FILTER_DEFAULT);
    }

    function logout() {
        session_destroy();
        session_unset(['email']);
        session_unset(['senha']);
        $this->redirect(ADMIN . "/index.php?mensagem=deslogou");
    }

    function refresh($tempo, $pagina) {
        return header("Refresh: {$tempo}, {$pagina}");
    }

    function redirect($pagina) {
        return header("Location: {$pagina}");
    }

    function tirarUltimoCaracter($string) {
        return substr($string, 0, -1);
    }

    function tiraCaracter($valor) {
        $pontos = array(",", ".");
        $result = str_replace($pontos, "", $valor);
        return $result;
    }

    //funcao q saber a porcentagem do valor total do produto/serviço
    function porcentagem($percentual, $total) {
        return ( $percentual / 100 ) * $total;
    }

    function acrescimo($porcentagem, $total) {
        $percentual = $porcentagem / 100.0;
        return $valor_final = $total + ($percentual * $total);
    }

    function desconto($porcentagem, $total) {
        $percentual = $porcentagem / 100.0;
        return $valor_final = $total - ($percentual * $total);
    }

    function mediaAcertos($qtdPerguntas, $notaTotal) {
        return ceil((($notaTotal / $qtdPerguntas) * 100)) . "%" . "<br>";
    }

    function mediaErros($qtdPerguntas, $notaTotal) {
        return ceil(((($qtdPerguntas - $notaTotal) / $qtdPerguntas) * 100)) . "%";
    }

    function geraTimestamp($data) {
        $partes = explode('-', $data);
        return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    }

    function converteData($string) {
        $string = str_replace('-', '/', $string);
    }

    function dataFormat($data) {
        $timestamp = strtotime($data); // Gera o timestamp de $data_mysql
        return date('d/m/Y H:i:s', $timestamp); // Resultado: 12/03/2009
    }

    function dataConverteMes($data) {
        $timestamp = strtotime($data); // Gera o timestamp de $data_mysql
        return date('d/m/Y', $timestamp); // Resultado: 12/03/2009
    }

    function dataConverteMesMaisDias($data) {
        echo date('d/m/Y', strtotime("+10 days", strtotime($data)));
    }

    public function valorLucroProduto($valorAtual, $valorCompra) {
        return $valor = ($valorAtual - $valorCompra);
    }

    public function diferencaDatas($data, $final) {
        $dataini = $this->dataConverteMes($data);
        $datafim = $this->dataConverteMes($final);

        $data_inicial = \DateTime::createFromFormat('d/m/Y', $dataini);
        $data_final = \DateTime::createFromFormat('d/m/Y', $datafim);

        $diferenca = $data_final->diff($data_inicial);
        return $diferenca->days;
    }

    public function maisDias($data, $dias) {
        return date($data, strtotime("+" . $dias . " days"));
    }

    public function valorLucroMes($valorAgora, $valorInvestimento, $dias) {
        return $valor = ($this->valorLucroProduto($valorAgora, $valorInvestimento) - $valorInvestimento) * $dias;
    }

    function mediaLucros($valorAnterior, $valorNovo) {
        $p_lucro = NULL; // porcentagem de lucro
        while ($valorAnterior + (($p_lucro / 100) * $valorAnterior) < $valorNovo) {
            $p_lucro = $p_lucro + 0.1;
        }
        return ceil($p_lucro) . "%";
    }

    function comissao($valorItem, $porcentagem) {
        $valor = $valorItem;
        $porcent = $porcentagem / 100;
        return $comissao = $porcent * $valor;
    }

    function colocaPonto($valor) {
        return substr_replace($valor, '.', -2, -2);
    }

    function formatoReal($valor) {
        $valor = $this->colocaPonto($valor);
        return number_format($valor, 2, '.', ',');
    }

    public function numberFormat($valor) {
        return number_format($valor, 2, ',', '.');
    }

    function navegador() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    function enderecoIP() {
        return $_SERVER['REMOTE_ADDR'];
    }

    function anti_injection($sql) {
        $sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $sql);
        $sql = trim($sql);
        $sql = strip_tags($sql);
        $sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
        return $sql;
    }

    function trataFormulario($str) {
        $str = trim($sql);
        $str = strip_tags($str);
        return $str;
    }

    public function protegeArquivo() {
        if (isset($_SESSION['email'], $_SESSION['senha'])):
            return true;
        else:
            return false;
        endif;
    }

    public function Autor() {
        return "Agência Digital Web Lab";
    }

    public function Site() {
        return "http://www.efraiminformatica.com.br";
    }

    public function deslogar() {
        if ($this->protegeArquivo()):
            unset($_SESSION['logado']['email']);
            unset($_SESSION['logado']['senha']);
            session_destroy();
            return true;
        else:
            return false;

        endif;
    }

    public function buttonSalvar() {
        return '<button type="submit" class="btn btn-primary">Salvar</button>';
    }

    public function buttonFechar() {
        return '<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>';
    }

    public function addClientes() {
        return '<span style="float:right"><a href="painel.php?pagina=cadastro_clientes" type="button" class="btn btn-success"><i class="fa fa-plus"></i> [ADD] </a></span>';
    }

    public function dataAtual() {
        return date('Y-m-d H:i:s');
    }

    function dataValida($dat) {
        try {
            $data = explode("/", $dat); // explode a string $dat em pedaços, usando / como referência
            $m = $data[0];
            $d = $data[1];
            $y = $data[2];

            // verifica se a data é válida!
            // 1 = true (válida)
            // 0 = false (inválida)
            $res = checkdate($m, $d, $y);
            if ($res == 1) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    //funçoes gerais

    public function get($string) {
        /* @var $_GET type */
        $get = $this->anti_injection(filter_input(INPUT_GET, $string, FILTER_DEFAULT));
        return $get;
    }

    public function post($string) {
        /* @var $_GET type */
        $get = \filter_input(INPUT_POST, $string, FILTER_DEFAULT);
        return $get;
    }

    public function permissaoTrue($ver, $add, $alt, $del) {
        return $ver || $add || $alt || $del == 1;
    }

    public function permissaoFalse($ver, $add, $alt, $del) {
        return $ver || $add || $alt || $del == 0;
    }

    //funções das paginas

    public function comandosPaginas($stringObj, $url, $titulo, $msg, $adicional = null) {
        if ($stringObj == 1):
            echo '<a href="' . $url . '" class="btn btn-primary btn-lg" type="button" data-toggle="tooltip" data-placement="top" title="' . $titulo . '">' . $titulo . '</a> ' . $adicional;
        elseif ($stringObj == 0):
            echo WLMsg("{$msg}", WL_ALERT);
        endif;
    }

    public function verItem($stringObj, $url) {
        if ($stringObj == 1):
            echo '<a href="' . $url . '" type="button" data-toggle="tooltip" data-placement="top" title="Visualizar" class="btn btn-success btn-circle"><i class="fa fa-eye"></i> </a>';
        elseif ($stringObj == 0):
            echo '<a href="#" type="button" data-toggle="tooltip" data-placement="top" title="Sem permissões suficientes para executar esta ação" class="btn btn-danger btn-circle"><i class="fa fa-eye"></i> </a>';
        endif;
    }

    public function altItem($stringObj, $url) {
        if ($stringObj == 1):
            echo '<a href="' . $url . '" type="button" data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </a>';
        elseif ($stringObj == 0):
            echo '<a href="#" type="button" data-toggle="tooltip" data-placement="top" title="Sem permissões suficientes para executar esta ação" class="btn btn-danger btn-circle"><i class="fa fa-edit"></i> </a>';
        endif;
    }

    public function delItem($stringObj, $url) {
        if ($stringObj == 1):
            $true = '<a href="' . $url . '" type="button" data-toggle="tooltip" data-placement="top" title="Deletar" class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </a>';
            echo $true;
        elseif ($stringObj == 0):
            $false = '<a href="#" type="button" data-toggle="tooltip" data-placement="top" title="Sem permissões suficientes para executar esta ação" class="btn btn-danger btn-circle"><i class="fa fa-ban"></i> </a>';
            echo $false;
        endif;
    }

    public function separaCaracterPermissaoNome($delimitador, $string) {
        $resultado = explode($delimitador, $string);
        return $resultado[1];
    }

    public function separaCaracterPermissaoNum($delimitador, $string) {
        $resultado = explode($delimitador, $string);
        return $resultado[0];
    }

    function getThisYear() {

        $dias = date("z");
        $primeiro = date("Y-m-d", strtotime("-" . ($dias) . " day"));
        $ultimo = date("Y-m-d", strtotime("+" . ( 364 - $dias) . " day"));
        return array($primeiro, $ultimo);
    }

    function getThisWeek() {

        return array(date("Y/m/d", strtotime("last sunday", strtotime("now"))), date("Y/m/d", strtotime("next saturday", strtotime("now"))));
    }

    function getLastSevenDays() {

        return array(date("Y-m-d", strtotime("-7 day", strtotime("now"))), date("Y-m-d", strtotime("now")));
    }

    function getThisMonth() {

        $mes = date('m');
        $ano = date('Y');
        $qtdDiasMes = date('t');
        $inicia = $ano . "-" . $mes . "-01";

        $ate = $ano . "-" . $mes . "-" . $qtdDiasMes;
        return array($inicia, $ate);
    }

    public function UrlAmigavel() {
        $url = $this->get('url');
        echo $url;
    }

    public function EnviarEmail($subject, $msg, $from, $namefrom, $destino, $namedestino) {
        $send = new PHPMailer;

        $send->isSMTP();
        $send->SMTPAuth = true;
        $send->Host = MAILHOST;
        $send->Port = MAILPORT;
        $send->Username = MAILUSER;
        $send->Password = MAILPASS;
        $send->From = $from;
        $send->FromName = $namedestino;
        $send->isHTML(true);
        $send->Subject = utf8_decode($subject);
        $send->Body = utf8_decode($msg);
        $send->addAddress($from, utf8_decode($namefrom));


        if ($send->send()):
            $this->Error = ['Sua mensagem foi enviada!', WS_ACCEPT];
            $this->Result = false;
        else:
            $this->Error = ['Não foi possível enviar a mensagem!', WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com o erro e o tipo de erro.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    static public function download($path, $fileName = '') {

        if ($fileName == '') {
            $fileName = basename($path);
        }

        header("Content-Type: application/force-download");
        header("Content-type: application/octet-stream;");
        header("Content-Length: " . filesize($path));
        header("Content-disposition: attachment; filename=" . $fileName);
        header("Pragma: no-cache");
        header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        header("Expires: 0");
        return readfile($path);
        flush();
    }

    static public function Menu() {
        $readMenu = new Read;
        $typePage = "page";
        $readMenu->ExeRead("ws_posts", "WHERE post_type = :p AND post_status = 1 LIMIT 3", "p={$typePage}");
        if ($readMenu->getResult()):
            return $menu = $readMenu->getResult();
        endif;
    }

    static public function Posts($limite = null) {
        $limite = (!$limite) ? 4 : $limite;
        $readMenu = new Read;
        $typePage = "post";
        $readMenu->ExeRead("ws_posts", "WHERE post_type = :p AND post_status = 1 LIMIT {$limite}", "p={$typePage}");
        if ($readMenu->getResult()):
            return $menu = $readMenu->getResult();
        endif;
    }

    static public function Servicos() {
        $readMenu = new Read;
        $typePage = "servico";
        $readMenu->ExeRead("ws_posts", "WHERE post_type = :p AND post_status = 1 LIMIT 6", "p={$typePage}");
        if ($readMenu->getResult()):
            return $menu = $readMenu->getResult();
        endif;
    }

    static public function Depoimentos($limite = null) {
        $limite = (!$limite) ? 4 : $limite;
        $readDep = new Read;
        $readDep->ExeRead("ws_depoimentos", "WHERE depoimento_status = 1 ORDER BY depoimento_date DESC LIMIT {$limite}");
        if ($readDep->getResult()):
            return $dep = $readDep->getResult();
        endif;
    }

    static public function Banners() {
        $readDep = new Read;
        $readDep->ExeRead("ws_banners", "WHERE banner_status = 1 AND banner_active = 1 LIMIT 1");
        if ($readDep->getResult()):
            return $dep = $readDep->getResult();
        endif;
    }

    static public function Perfil($table, $condition, $values) {
        $readMenu = new Read;
        $readMenu->ExeRead($table, $condition, $values);
        if ($readMenu->getResult()):
            return $menu = $readMenu->getResult()[0];
        endif;
    }

    public static function Author($id) {
        $readUser = new Read;
        $readUser->ExeRead("ws_users", "WHERE user_id = :autor", "autor={$id}");
        if ($readUser->getResult()):
            return $readUser->getResult()[0];
        endif;
    }

    static public function LimparCache() {
        return header("Pragma: no-cache");
        return header("Cache: no-cahce");
        return header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        return header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        return header("Cache-Control: no-cache, cachehack=" . time());
        return header("Cache-Control: no-store, must-revalidate");
        return header("Cache-Control: post-check=-1, pre-check=-1", false);
        return clearstatcache();
    }

}
