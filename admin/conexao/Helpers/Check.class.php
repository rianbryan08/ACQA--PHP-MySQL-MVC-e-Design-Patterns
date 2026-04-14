<?php

/**
 * Check.class [ HELPER ]
 * Classe responsável por manipular e validade dados do sistema!
 * 
* @copyright (c) 2015, Alisson Maciel AGÊNCIA DIGITAL WEB LAB
 */
class Check {

    private $Data;
    private $Format;

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
     * @param STRING $Email = Uma conta de e-mail
     * @return BOOL = True para um email válido, ou false
     */
    public function Email($Email) {
        $this->Data = (string) $Email;
        $this->Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match($this->Format, $this->Data)):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * <b>Tranforma URL:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
     * @param STRING $Name = Uma string qualquer
     * @return STRING = $Data = Uma URL amigável válida
     */
    public function Name($Name) {
        $this->Format = array();
        $this->Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $this->Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        $this->Data = strtr(utf8_decode($Name), utf8_decode($this->Format['a']), $this->Format['b']);
        $this->Data = strip_tags(trim($this->Data));
        $this->Data = str_replace(' ', '-', $this->Data);
        $this->Data = str_replace(array('-----', '----', '---', '--'), '-', $this->Data);

        return strtolower(utf8_encode($this->Data));
    }

    /**
     * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
     * @param STRING $Name = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public function Data($Data) {
        $this->Format = explode(' ', $Data);
        $this->Data = explode('/', $this->Format[0]);

        if (empty($this->Format[1])):
            $this->Format[1] = date('H:i:s');
        endif;

        $this->Data = $this->Data[2] . '-' . $this->Data[1] . '-' . $this->Data[0] . ' ' . $this->Format[1];
        return $this->Data;
    }

    /**
     * <b>Limita os Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @return INT = $Limite = String limitada pelo $Limite
     */
    public function Words($String, $Limite, $Pointer = null) {
        $this->Data = strip_tags(trim($String));
        $this->Format = (int) $Limite;

        $ArrWords = explode(' ', $this->Data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, $this->Format));

        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer );
        $Result = ( $this->Format < $NumWords ? $NewWords . $Pointer : $this->Data );
        return $Result;
    }

    /**
     * <b>Obter categoria:</b> Informe o name (url) de uma categoria para obter o ID da mesma.
     * @param STRING $category_name = URL da categoria
     * @return INT $category_id = id da categoria informada
     */
    public function CatByName($CategoryName) {
        $read = new Read;
        $read->ExeRead('ga_categoria', "WHERE Categoria = :name", "name={$CategoryName}");
        if ($read->getRowCount()):
            return $read->getResult()[0]->idCategoria;
        else:
            echo "A categoria {$CategoryName} não foi encontrada!";
            die;
        endif;
    }

    /**
     * <b>Usuários Online:</b> Ao executar este HELPER, ele automaticamente deleta os usuários expirados. Logo depois
     * executa um READ para obter quantos usuários estão realmente online no momento!
     * @return INT = Qtd de usuários online
     */
    public function UserOnline() {
        $now = date('Y-m-d H:i:s');
        $deleteUserOnline = new Delete;
        $deleteUserOnline->ExeDelete('loja_useronline', "WHERE online_endview < :now", "now={$now}");

        $readUserOnline = new Read;
        $readUserOnline->ExeRead('loja_useronline');
        return $readUserOnline->getRowCount();
    }

    /**
     * <b>Imagem Upload:</b> Ao executar este HELPER, ele automaticamente verifica a existencia da imagem na pasta
     * uploads. Se existir retorna a imagem redimensionada!
     * @return HTML = imagem redimencionada!
     */
    public function Image($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null) {

        $this->Data = $ImageUrl;

        if (file_exists($this->Data) && !is_dir($this->Data)):
            $patch = BASE;
            $imagem = $this->Data;
            return "<img src=\"{$patch}/tim.php?src={$patch}/{$imagem}&h={$ImageH}\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" width=\"{$ImageW}%\" class=\"img-rounded\"/>";//&w={$ImageW}
        else:
            return false;
        endif;
    }

}
