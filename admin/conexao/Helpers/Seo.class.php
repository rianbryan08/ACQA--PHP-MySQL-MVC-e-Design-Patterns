<?php

/**
 * Seo [ MODEL ]
 * Classe de apoio para o modelo LINK. Pode ser utilizada para gerar SSEO para as páginas do sistema!
 * 
 * @copyright (c) 2015, Alisson Maciel AGÊNCIA DIGITAL WEB LAB
 */
class Seo {

    private $File;
    private $Link;
    private $Data;
    private $Tags;

    /* DADOS POVOADOS */
    private $seoTags;
    private $seoData;

    function __construct($File, $Link) {
        $this->File = strip_tags(trim($File));
        $this->Link = strip_tags(trim($Link));
    }

    /**
     * <b>Obter MetaTags:</b> Execute este método informando os valores de navegação para que o mesmo obtenha
     * todas as metas como title, description, og, itemgroup, etc.
     * 
     * <b>Deve ser usada com um ECHO dentro da tag HEAD!</b>
     * @return HTML TAGS =  Retorna todas as tags HEAD
     */
    public function getTags() {
        $this->checkData();
        return $this->seoTags;
    }

    /**
     * <b>Obter Dados:</b> Este será automaticamente povoado com valores de uma tabela single para arquivos
     * como categoria, artigo, etc. Basta usar um extract para obter as variáveis da tabela!
     * 
     * @return ARRAY = Dados da tabela
     */
    public function getData() {
        $this->checkData();
        return $this->seoData;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Verifica o resultset povoando os atributos
    private function checkData() {
        if (!$this->seoData):
            $this->getSeo();
        endif;
    }

    //Identifica o arquivo e monta o SEO de acordo
    private function getSeo() {
        $ReadSeo = new Read;
        $ReadEstado = new Read;

        switch ($this->File):
            //SEO:: POST
            case 'blog':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'post';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Blog - Dicas de Coach - ' . SITENAME, 'Blog - Dicas de Coach do site ' . SITENAME, BASE . "/blog/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/blog/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;

                break;
                
                case 'imprensa':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'imprensa';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Imprensa - ' . SITENAME, 'Imprensa do site ' . SITENAME, BASE . "/imprensa/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/imprensa/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;

                break;

            case 'lista-de-precos':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'preco';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Lista de preços - ' . SITENAME, 'Promoções do site Inflavel Park', BASE . "/lista-de-precos/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_description, BASE . "/lista-de-precos/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;

                break;

            case 'promocoes':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'promocoe';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Promoções - ' . SITENAME, 'Promoções do site Inflavel Park', BASE . "/promocoes/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_description, BASE . "/promocoes/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;

                break;

            case 'espacos':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'espaco';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Espaços - ' . SITENAME, 'Páginas da ' . SITENAME, BASE . "/espacos/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/espacos/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;
                break;

            case 'pages':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'page';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Página - ' . SITENAME, 'Páginas da ' . SITENAME, BASE . "/pages/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/pages/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;
                break;

            case 'galerias':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'galeria';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Galerias - ' . SITENAME, 'Galerias da ' . SITENAME, BASE . "/galerias/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/galerias/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;
                break;
                
                case 'videos':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'video_status = 1 AND');
                $type = 'video';
                $ReadSeo->ExeRead("ws_videos", "WHERE {$Check} video_name = :link ", "link={$this->Link}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Vídeos - ' . SITENAME, 'Vídeos do ' . SITENAME, BASE . "/videos/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->video_title . ' - ' . SITENAME, $extract->video_description, BASE . "/videos/{$extract->video_name}", BASE . "/uploads/{$extract->video_thumb}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['video_views' => $extract->video_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_videos", $ArrUpdate, "WHERE video_id = :postid", "postid={$extract->video_id}");
                endif;
                break;

            case 'equipes':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'equipe';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Página - ' . SITENAME, 'Equipe da ' . SITENAME, BASE . "/equipes/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/equipes/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;
                break;

            case 'servicos':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'servico';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :type", "link={$this->Link}&type={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Serviços - ' . SITENAME, 'Serviços '.SITENAME, BASE . "/servicos/", BASE . "/images/noimage.gif.jpg", KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - ' . SITENAME, $extract->post_content, BASE . "/servicos/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;

                break;

            case 'locacao-de-brinquedos':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'produto';

                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link", "link={$this->Link}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->Data = ['Locação de Brinquedos - ' . SITENAME, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                    $this->seoTags = null;
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - Locação de Brinquedos - ' . SITENAME, $extract->post_content, BASE . "/locacao-de-briquedos/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;
                break;

            //SEO:: CATEGORIA
            case 'categoria':
                $ReadSeo->ExeRead("ws_categories", "WHERE category_name = :link", "link={$this->Link}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->category_title . ' - ' . SITENAME, $extract->category_content, BASE . "/categoria/{$extract->category_name}", INCLUDE_PATH . '/images/logo.png', KEYWORDS];

                    //category:: conta views da categoria
                    $ArrUpdate = ['category_views' => $extract->category_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_categories", $ArrUpdate, "WHERE category_id = :catid", "catid={$extract->category_id}");
                endif;
                break;

            //SEO:: PESQUISA
            case 'pesquisa':
                $ReadSeo->ExeRead("ws_produtos", "WHERE statusProduto = 1 AND (tituloProduto LIKE '%' :link '%' OR descricaoProduto LIKE '%' :link '%')", "link={$this->Link}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $this->seoData['count'] = $ReadSeo->getRowCount();
                    $this->Data = ["Pesquisa por: {$this->Link}" . ' - ' . SITENAME, "Sua pesquisa por {$this->Link} retornou {$this->seoData['count']} resultados!", BASE . "/pesquisa/{$this->Link}", INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                endif;
                break;


            //SEO:: INDEX
            case 'index':
                $this->Data = ['Home - ' . SITENAME, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                break;
            case 'empresa':
                $this->Data = ['Empresa - ' . SITENAME, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                break;
            case 'convite-virtual':
                $this->Data = ['Convite Virtual - ' . SITENAME, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                break;
            case 'depoimentos':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'depoimento_status = 1 AND');

                $ReadSeo->ExeRead("ws_depoimentos", "WHERE {$Check} depoimento_name = :link", "link={$this->Link}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->Data = ['Depoimentos - ' . SITENAME, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                    $this->seoTags = null;
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->depoimento_title . ' - Depoimentos - ' . SITENAME, $extract->depoimento_description, BASE . "/depoimentos/{$extract->depoimento_name}", BASE . "/uploads/{$extract->depoimento_img}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['depoimento_views' => $extract->depoimento_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_depoimentos", $ArrUpdate, "WHERE depoimento_id = :postid", "postid={$extract->depoimento_id}");
                endif;
                break;

            case 'decoracao-cortesia':
                $Admin = (isset($_SESSION['userlogin']->user_level) && $_SESSION['userlogin']->user_level == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND');
                $type = 'decoracao';
                $ReadSeo->ExeRead("ws_posts", "WHERE {$Check} post_name = :link AND post_type = :post", "link={$this->Link}&post={$type}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->Data = ['Decoração Cortesia - ' . SITENAME, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                    $this->seoTags = null;
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = [$extract->post_title . ' - Decoração Cortesia - ' . SITENAME, $extract->post_content, BASE . "/decoracao-cortesia/{$extract->post_name}", BASE . "/uploads/{$extract->post_cover}", KEYWORDS];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $extract->post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate("ws_posts", $ArrUpdate, "WHERE post_id = :postid", "postid={$extract->post_id}");
                endif;
                break;
            case 'contato':
                $id = 1;
                $ReadSeo->ExeRead("ws_config", "WHERE config_id = :id", "id={$id}");
                if (!$ReadSeo->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                    $this->Data = ['Contato - ' . SITENAME . ' - ' . SITEDESC, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                else:
                    $extract = $ReadSeo->getResult()[0];
                    $this->seoData = $ReadSeo->getResult()[0];
                    $this->Data = ['Contato - ' . SITENAME, SITEDESC, BASE . "/contato/", BASE . '/images/logo.png', KEYWORDS];
                endif;
                //$this->Data = ['Contato - ' . SITENAME . ' - ' . SITEDESC, SITEDESC, BASE, INCLUDE_PATH . '/images/logo.png', KEYWORDS];
                break;

            //SEO:: 404
            default :
                $this->Data = [SITENAME . ' - 404 Oppsss, Nada encontrado!', SITEDESC, BASE . '/404', INCLUDE_PATH . '/images/logo.png', KEYWORDS];

        endswitch;

        if ($this->Data):
            $this->setTags();
        endif;
    }

    //Monta e limpa as tags para alimentar as tags
    private function setTags() {
        $Check = new Check;
        $this->Tags['Title'] = $this->Data[0];
        $this->Tags['Content'] = $Check->Words(html_entity_decode($this->Data[1]), 25);
        $this->Tags['Link'] = $this->Data[2];
        $this->Tags['Image'] = $this->Data[3];
        $this->Tags['Keywords'] = $this->Data[4];

        $this->Tags = array_map('strip_tags', $this->Tags);
        $this->Tags = array_map('trim', $this->Tags);

        $this->Data = null;

        //NORMAL PAGE
        $this->seoTags = '<title>' . $this->Tags['Title'] . '</title> ' . "\n";
        $this->seoTags .= '<meta name="description" content="' . $this->Tags['Content'] . '"/>' . "\n";
        $this->seoTags .= '<meta name="keywords" content="' . $this->Tags['Keywords'] . '"/>' . "\n";
        $this->seoTags .= '<meta name="robots" content="index, follow" />' . "\n";
        $this->seoTags .= '<link rel="canonical" href="' . $this->Tags['Link'] . '">' . "\n";
        $this->seoTags .= "\n";

        //FACEBOOK
        $this->seoTags .= '<meta property="og:site_name" content="' . SITENAME . '" />' . "\n";
        $this->seoTags .= '<meta property="og:locale" content="pt_BR" />' . "\n";
        $this->seoTags .= '<meta property="og:title" content="' . $this->Tags['Title'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:description" content="' . $this->Tags['Content'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:image" content="' . $this->Tags['Image'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:url" content="' . $this->Tags['Link'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:type" content="article" />' . "\n";
        $this->seoTags .= '<meta property="og:image:type" content="image/jpeg">' . "\n";
        $this->seoTags .= '<meta property="og:image:width" content="800">' . "\n";
        $this->seoTags .= '<meta property="og:image:height" content="600">' . "\n";


        $this->seoTags .= "\n";

        //ITEM GROUP (TWITTER)
        $this->seoTags .= '<meta itemprop="name" content="' . $this->Tags['Title'] . '">' . "\n";
        $this->seoTags .= '<meta itemprop="description" content="' . $this->Tags['Content'] . '">' . "\n";
        $this->seoTags .= '<meta itemprop="url" content="' . $this->Tags['Link'] . '">' . "\n";

        $this->Tags = null;
    }

}
