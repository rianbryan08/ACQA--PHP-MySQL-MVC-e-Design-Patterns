<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os posts no Admin do sistema!
 * 
 * @copyright (c) 2014, Alisson MAciel
 */
class AdminConfig {

    private $Data;
    private $Post;
    private $Error;
    private $Result;
    private $Type;

    //Nome da tabela no banco de dados
    const Entity = 'ws_config';
    
    public function PostType($Type){
        $this->Type = (string)$Type;
    }

    /**
     * <b>Cadastrar o Post:</b> Envelope os dados do post em um array atribuitivo e execute esse método
     * para cadastrar o post. Envia a capa automaticamente!
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

            $this->setData();
            $this->setName();

            if ($this->Data['config_logo']):
                $uplaod = new Upload;
                $uplaod->Image($this->Data['config_logo']);
            endif;

            if (isset($uplaod) && $uplaod->getResult()):
                $this->Data['config_logo'] = $uplaod->getResult();
                $this->Create();
            else:
                $this->Data['config_logo'] = null;
                $this->Create();
            endif;
    }

    /**
     * <b>Atualizar Post:</b> Envelope os dados em uma array atribuitivo e informe o id de um 
     * post para atualiza-lo na tabela!
     * @param INT $PostId = Id do post
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($PostId, array $Data) {
        $this->Post = (int) $PostId;
        $this->Data = $Data;

            $this->setData();
            $this->setName();

            if (is_array($this->Data['config_logo'])):
                $readCapa = new Read;
                $readCapa->ExeRead(self::Entity, "WHERE config_id = :post", "post={$this->Post}");
                $capa = '../uploads/' . $readCapa->getResult()[0]->config_logo;
                if (file_exists($capa) && !is_dir($capa)):
                    unlink($capa);
                endif;

                $uploadCapa = new Upload;
                $uploadCapa->Image($this->Data['config_logo']);
            endif;

            if (isset($uploadCapa) && $uploadCapa->getResult()):
                $this->Data['config_logo'] = $uploadCapa->getResult();
                $this->Update();
            else:
                unset($this->Data['config_logo']);
                $this->Update();
            endif;
    }

    

    /**
     * <b>Verificar Cadastro:</b> Retorna ID do registro se o cadastro for efetuado ou FALSE se não.
     * Para verificar erros execute um getError();
     * @return BOOL $Var = InsertID or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com uma mensagem e o tipo de erro.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $Cover = $this->Data['config_logo'];
        unset($this->Data['config_logo']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        $this->Data['config_logo'] = $Cover;
    }

    //Verifica o NAME post. Se existir adiciona um pós-fix -Count
    private function setName() {
        $Where = (isset($this->Post) ? "config_id != {$this->Post} AND" : '');
        $readName = new Read;
        $readName->ExeRead(self::Entity, "WHERE {$Where} config_title = :t", "t={$this->Data['config_title']}");
        if ($readName->getResult()):
            $this->Data['post_name'] = $this->Data['post_name'] . '-' . $readName->getRowCount();
        endif;
    }


    //Atualiza o post no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE config_id = :id", "id={$this->Post}");
        if ($Update->getResult()):
            $this->Error = ["Configurações alteradas com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
