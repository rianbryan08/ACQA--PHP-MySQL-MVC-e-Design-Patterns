<?php

/**
 * Session.class [ HELPER ]
 * Respons?vel pelas estat?sticas, sess?es e atualiza??es de tr?fego do sistema!
 * 
 * @copyright (c) 2015, Alisson Maciel WEBLAB Sistemas
 */
class Session {

    private $Date;
    private $Cache;
    private $Traffic;
    private $Browser;

    function __construct($Cache = null) {
        //ob_start();
        //session_start();
        $this->CheckSession($Cache);
    }

    //Verifica e executa todos os m?todos da classe!
    private function CheckSession($Cache = null) {
        $this->Date = date('Y-m-d');
        $this->Cache = ( (int) $Cache ? $Cache : 20 );

        if (empty($_SESSION['useronline'])):
            $this->setTraffic();
            $this->setSession();
            $this->CheckBrowser();
            $this->setUsuario();
            $this->BrowserUpdate();
        else:
            $this->setTraffic();
            $this->TrafficUpdate();
            $this->sessionUpdate();
            $this->CheckBrowser();
            $this->UsuarioUpdate();
        endif;
//
        $this->Date = null;
    }

    /*
     * ***************************************
     * ********   SESS?O DO USU?RIO   ********
     * ***************************************
     */

    //Inicia a sess?o do usu?rio
    private function setSession() {
        $_SESSION['useronline'] = [
            "online_session" => session_id(),
            "online_startview" => date('Y-m-d H:i:s'),
            "online_endview" => date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes")),
            "online_ip" => $_SERVER['REMOTE_ADDR'], //filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP),
            "online_url" => $_SERVER['REQUEST_URI'], //filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT),
            "online_agent" => $_SERVER['HTTP_USER_AGENT']//filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT)
        ];
    }

//    
//
//    //Atualiza sess?o do usu?rio!
    private function sessionUpdate() {
        $_SESSION['useronline']['online_ip'] = $_SERVER['REMOTE_ADDR']; //filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT);
        $_SESSION['useronline']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes"));
        $_SESSION['useronline']['online_url'] = $_SERVER['REQUEST_URI']; //filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
        $_SESSION['useronline']['online_agent'] = $_SERVER['HTTP_USER_AGENT']; //filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT);
    }

//
//    /*
//     * ***************************************
//     * *** USU?RIOS, VISITAS, ATUALIZA??ES ***
//     * ***************************************
//     */
//
//    //Verifica e insere o tr?fego na tabela
    private function setTraffic() {
        $this->getTraffic();
        $sessionip = $_SERVER['REMOTE_ADDR']; //filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT);
        if (!$this->Traffic || $this->Traffic == null):
            $ArrSiteViews = [ 'siteviews_date' => $this->Date, 'siteviews_users' => 1, 'siteviews_views' => 1, 'siteviews_pages' => 1, 'online_ip' => $sessionip];
            $createSiteViews = new Create;
            $createSiteViews->ExeCreate("ws_siteviews", $ArrSiteViews);
        else:
            if (!$this->getCookie()):
                $ArrSiteViews = [ 'siteviews_users' => $this->Traffic->siteviews_users + 1, 'siteviews_views' => $this->Traffic->siteviews_views + 1, 'siteviews_pages' => $this->Traffic->siteviews_pages + 1, 'online_ip' => $sessionip];
            else:
                $ArrSiteViews = [ 'siteviews_views' => $this->Traffic->siteviews_views + 1, 'siteviews_pages' => $this->Traffic->siteviews_pages + 1, 'online_ip' => $sessionip];
            endif;

            $updateSiteViews = new Update;
            $updateSiteViews->ExeUpdate("ws_siteviews", $ArrSiteViews, "WHERE siteviews_date = :date", "date={$this->Date}");

        endif;
    }

//
//    //Verifica e atualiza os pageviews
    private function TrafficUpdate() {
        $this->getTraffic();
        $ArrSiteViews = [ 'siteviews_pages' => $this->Traffic->siteviews_pages + 1];
        $updatePageViews = new Update;
        $updatePageViews->ExeUpdate("ws_siteviews", $ArrSiteViews, "WHERE siteviews_date = :date", "date={$this->Date}");

        $this->Traffic = null;
    }

//
//    //Obt?m dados da tabele [ HELPER TRAFFIC ]
//    //ws_siteviews
    private function getTraffic() {
        $sessionip = $_SERVER['REMOTE_ADDR']; //filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_DEFAULT);
        $readSiteViews = new Read;
        $readSiteViews->ExeRead("ws_siteviews", "WHERE siteviews_date = :date OR online_ip = :ip", "date={$this->Date}&ip={$sessionip}");
        if ($readSiteViews->getRowCount() >= 1):
            $this->Traffic = $readSiteViews->getResult()[0];
        else:
            $this->Traffic = null;
        endif;
    }

//
//    //Verifica, cria e atualiza o cookie do usu?rio [ HELPER TRAFFIC ]
    private function getCookie() {
        setcookie("useronline", base64_encode("weblab"), time() + 86400);
        //$Cookie = $_COOKIE['useronline']; //filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        if (array_key_exists('useronline', $_COOKIE)) {
            $Cookie = $_COOKIE['useronline'];
        } else {
            $Cookie = 'O Cookie não existe';
        }
        
        if (!$Cookie):
            return false;
        else:
            return true;
        endif;
    }

//
//    /*
//     * ***************************************
//     * *******  NAVEGADORES DE ACESSO   ******
//     * ***************************************
//     */
//
//    //Identifica navegador do usu?rio!
    private function CheckBrowser() {
        $this->Browser = $_SESSION['useronline']['online_agent'];
        if (strpos($this->Browser, 'Chrome')):
            $this->Browser = 'Chrome';
        elseif (strpos($this->Browser, 'Firefox')):
            $this->Browser = 'Firefox';
        elseif (strpos($this->Browser, 'MSIE') || strpos($this->Browser, 'Trident/')):
            $this->Browser = 'IE';
        else:
            $this->Browser = 'Outros';
        endif;
    }

//
//    //Atualiza tabela com dados de navegadores!
    private function BrowserUpdate() {
        $readAgent = new Read;
        $readAgent->ExeRead("ws_siteviews_agent", "WHERE agent_name = :agent", "agent={$this->Browser}");
        if (!$readAgent->getResult()):
            $ArrAgent = ['agent_name' => $this->Browser, 'agent_views' => 1];
            $createAgent = new Create;
            $createAgent->ExeCreate("ws_siteviews_agent", $ArrAgent);
        else:
            $ArrAgent = ['agent_views' => $readAgent->getResult()[0]->agent_views + 1];
            $updateAgent = new Update;
            $updateAgent->ExeUpdate("ws_siteviews_agent", $ArrAgent, "WHERE agent_name = :name", "name={$this->Browser}");
        endif;
    }

//
//    /*
//     * ***************************************
//     * *********   USU?RIOS ONLINE   *********
//     * ***************************************
//     */
//
//    //Cadastra usu?rio online na tabela!
    private function setUsuario() {
        $sesOnline = $_SESSION['useronline'];
        $sesOnline['agent_name'] = $this->Browser;

        $userCreate = new Create;
        $userCreate->ExeCreate("ws_siteviews_online", $sesOnline);
    }

//    //Atualiza navega??o do usu?rio online!
    private function UsuarioUpdate() {
        $ArrOnlone = [
            'online_ip' => $_SESSION['useronline']['online_ip'],
            'online_endview' => $_SESSION['useronline']['online_endview'],
            'online_url' => $_SESSION['useronline']['online_url'],
            'online_agent' => $_SESSION['useronline']['online_agent']
        ];
        $userUpdate = new Update;
        $userUpdate->ExeUpdate("ws_siteviews_online", $ArrOnlone, "WHERE online_session = :ses", "ses={$_SESSION['useronline']['online_session']}");

        if (!$userUpdate->getRowCount()):
            $readSes = new Read;
            $readSes->ExeRead("ws_siteviews_online", 'WHERE online_session = :onses', "onses={$_SESSION['useronline']['online_session']}");
            if (!$readSes->getRowCount()):
                $this->setUsuario();
            endif;
        endif;
    }

}
