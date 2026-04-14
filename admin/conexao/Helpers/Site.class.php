<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Site
 *
 * @author WEBLAB
 */
class Site {

    public function getData() {
        $data = getdate();
        $diaHoje = date("d");

        $arrayMeses = [1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"];
        $horaAgora = date("H:i");
        $mesGetDate = $data["mon"];
        $anoAtual = date("Y");
        return "Hoje, {$diaHoje} de {$arrayMeses[$mesGetDate]} de {$anoAtual} - {$horaAgora}";
    }

    public function atualizarViewCat($slug) {
        $this->Slug = (string) $slug;
        $ReadSeo = new Read;
        $ReadSeo->ExeRead("ga_categoria", "WHERE idCategoria = :link", "link={$this->Slug}");
        if (!$ReadSeo->getResult()):
        else:
            $extrair = $ReadSeo->getResult()[0];
            $update = new Update;
            $ArrUpdate = ['VisitasCategoria' => $extrair->VisitasCategoria + 1];
            $update->ExeUpdate("ga_categoria", $ArrUpdate, "where idCategoria = :slug", "slug={$this->Slug}");
        endif;
    }

//atualiza views da categoria

    public function atualizarViewSub($slug) {
        $this->Slug = (string) $slug;
        $ReadSeo = new Read;
        $ReadSeo->ExeRead("loja_subcategorias", "WHERE slugSubcategoria = :link", "link={$this->Slug}");
        if (!$ReadSeo->getResult()):
        else:
            $extrair = $ReadSeo->getResult()[0];
            $update = new Update;
            $ArrUpdate = ['viewsSubcategoria' => $extrair->viewsSubcategoria + 1];
            $update->ExeUpdate("loja_subcategorias", $ArrUpdate, "where slugSubcategoria = :slug", "slug={$this->Slug}");
        endif;
    }

//atualiza views da subcategoria
    
    public function logomarca(){
        $logo = new Read;
        $logo->ExeRead("ws_config");
        $logomarca = $logo->getResult()[0];
        return $logomarca;
    }
}
