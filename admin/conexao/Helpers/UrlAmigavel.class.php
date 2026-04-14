<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UrlAmigavel
 *
 * @author WEBLAB
 */
class UrlAmigavel {
    
    private $Parametros;
    private $Url;
    private $Paginas;
    
    function __construct($Parametros, $Url, $Paginas) {
        $this->Parametros = $Parametros;
        $this->Url = $Url;
        $this->Paginas = $Paginas;
    }
    
    function setParametros($Parametros) {
        $this->Parametros = $Parametros;
    }

    function setUrl($Url) {
        $this->Url = $Url;
    }

    function setPaginas($Paginas) {
        $this->Paginas = $Paginas;
    }

    public function UrlAmigavel($Home, $Categoria, $Subcategoria, $Erro) {
        
        $this->Home = $Home;
        $this->Categoria = $Categoria;
        $this->Subcategoria = $Subcategoria;
        $this->Erro = $Erro;
        
        $funcoes = new Funcoes;
        if ($funcoes->get("s") && $funcoes->get("s") != ""):
            include_once "pages/{$this->Busca}.php";
        else:
            if ($this->Url == ""):
                include_once "pages/{$this->Home}.php";
            elseif (in_array($this->Parametros[0], $this->Paginas)):
                include_once "pages/{$this->Parametros[0]}.php";
            elseif ($this->Parametros[0] == "galeria"):
                if (isset($this->Parametros[1]) && !isset($this->Parametros[2])):
                    include_once "pages/{$this->Categoria}.php";
                elseif (isset($this->Parametros[2])):
                    include_once "pages/{$this->Subcategoria}.php";
                endif;
            else:
                include_once "pages/{$this->Erro}.php";
            endif;

        endif;
        
    }

}
