<?php
session_start();
$_SERVER['DOCUMENT_ROOT'] = "C:/xampp/htdocs/php-mvc-task-manager";
@ini_set('magic_quotes_runtime', 0);
@ini_set('magic_quotes_sybase', 0);
@ini_set('output_handler', 'mb_output_handler');
@ini_get('upload_max_filesize');
ini_set("memory_limit", "128M");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
@ini_set('max_execution_time', 0);
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
ini_set('allow_url_fopen', true);
ini_set('allow_url_include', true);
php_ini_loaded_file();

header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, cachehack=" . time());
header("Cache-Control: no-store, must-revalidate");
header("Cache-Control: post-check=-1, pre-check=-1", false);

$_SESSION['visitante'] = $_SERVER['REMOTE_ADDR'];
class AutoLoad {

    private $Files;
 
    public function __construct() {
        spl_autoload_register([$this, 'Pastas']);
    }

    private function Pastas($File) {
        $this->Files = [
            $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Classes/' . $File . '.class.php',
            $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Models/' . $File . '.class.php',
            $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Controller/' . $File . '.class.php',
            $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Helpers/' . $File . '.class.php',
            $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Helpers/class.' . $File . '.php'
        ];
        foreach ($this->Files as $arquivo):
            if (file_exists($arquivo)):
                require_once $arquivo;
            endif;
        endforeach;
    }

}

new AutoLoad();

$funcoes = new Funcoes;
$check = new Check;

define('HOST', "localhost");
define('USER', "root");
define('PASS', "");
define('BANCO', "reve7660_faculdade (1)");
define('PREFIX', "ws_");

define('BASE', 'http://localhost/php-mvc-task-manager');
define('ADMIN', BASE . '/admin');
define('BASEPATH', 'admin');
define('HOME', BASE);
define('THEME', '2016');
$base = BASE;
$admin = ADMIN;

define('INCLUDE_PATH', BASE . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . THEME);
define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEME);

define('WS_ACCEPT', 'success');
define('WS_INFOR', 'info');
define('WS_ALERT', 'warning');
define('WS_ERROR', 'danger');

/** DEFINE SERVIDOR DE E-MAIL ################
//define('MAILHOST', "ssl://smtp.gmail.com");
//define('MAILPORT', "465");
//define('MAILUSER', "sac.jamm@gmail.com");
//define('MAILPASS', "!nameiswhat1504#");
// DEFINE SERVIDOR DE E-MAIL ################*/

$Config = new Read();
$Config->ExeRead(PREFIX . "config");
$etConfig = $Config->getResult()[0];

define('MAILHOST', "{$etConfig->config_hostname}");
define('MAILPORT', "{$etConfig->config_port}");
define('MAILUSER', "{$etConfig->config_user}");
define('MAILPASS', "{$etConfig->config_password}");
define('MAILSECURE', false);

define('SITENAME', "{$etConfig->config_title}");
define('SITEDESC', "{$etConfig->config_description}");
define('KEYWORDS', "{$etConfig->config_keywords}");


include_once $_SERVER['DOCUMENT_ROOT'].'/admin/conexao/Helpers/class.smtp.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/admin/conexao/Helpers/class.phpmailer.php';

function WLMsg($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<div class=\"alert alert-{$CssClass}\">"
    . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
    echo "{$ErrMsg}";
    echo "</div>";

    if ($ErrDie):
        die;
    endif;
}

$Site = new Site;
$margin = 'style="margin:5px 0;"';

function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<div class=\"alert alert-{$CssClass}danger\">"
    . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
    echo "Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "</div>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');

try {
    $conexao = new PDO("mysql:host=" . HOST . ";dbname=" . BANCO, USER, PASS);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<div class=\"alert alert-danger\">"
    . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
    echo "Erro na Linha: #{$e->getLine()} ::</b> {$e->getMessage()}<br>";
    echo "<small>{$e->getFile()}</small>";
    echo "</div>";
}

if (isset($_POST['config_cep'])):
    $cep = $_POST['config_cep'];
/**$url = "http://xtends.com.br/webservices/cep/json/$cep/";*/
    $url = "http://clareslab.com.br/ws/cep/json/$cep/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    echo curl_exec($ch);
    curl_close($ch); 
endif;