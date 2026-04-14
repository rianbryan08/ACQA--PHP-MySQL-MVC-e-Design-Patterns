<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cripto
 *
 * @author WEBLAB
 */
class Cripto {
    public function setCripto($parametro){
        return hash('whirlpool',hash('sha512',hash('sha384',hash('sha256',sha1(md5($parametro)))))); //128 cracteres
    }//Function SetCripto
}
