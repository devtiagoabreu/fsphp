<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Faq\Channel;
use Source\Models\Faq\Question;
use Source\Models\User;
use Source\Models\Category;
use Source\Support\Pager;

class Web extends Controller
{
  public function __construct()
  {
    parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
  }

  public function home(): void
  {
    /**
     * Debug
     * $model = (new Category())->find()->fetch(true); ou $model = (new Category())->findByUri("controle");
     * var_dump($model);
     */
    
    $head = $this->seo->render(
      
      CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
      CONF_SITE_DESC,
      url(),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("home", [
      "head"=>$head,
      "video"=>"o33OxhNWd5o"  
    ]);
  }

  public function about(): void
  {
    /**
     * DEBUG COM VAR_DUMP
     * $model = (new Question())->find()->fetch(true);
     * var_dump($model);
     **/ 
    
    $head = $this->seo->render(
      
      "Descubra o " . CONF_SITE_NAME . " - " . CONF_SITE_DESC,
      CONF_SITE_DESC,
      url("/sobre"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("about", [
      "head"=>$head,
      "video"=>"o33OxhNWd5o",
      "faq" => (new Question())
            ->find("channel_id = :id", "id=1", "question, response")
            ->order("order_by")
            ->fetch(true)
    ]);
  }

  public function blog(?array $data): void
  {
    $head = $this->seo->render(
      
      "Blog - " . CONF_SITE_NAME,
      "Confira em nosso blog dicas e sacadas de como controlar e melhorar suas contas. Vamos tomar um café?",
      url("/blog"),
      theme("/assets/images/share.jpg")
    );

    $pager = new Pager(url("/blog/page/"));
    $pager->pager(100, 10, ($data['page'] ?? 1));
    
    echo $this->view->render("blog", [
      "head"=>$head,
      "paginator"=>$pager->render()
        
    ]);
  }

  public function blogPost(array $data): void
  {
    $postName = $data['postName'];
    $head = $this->seo->render(
    "POST NAME - " . CONF_SITE_NAME,
    "POST HEADLINE",
    url("/blog/{postName}"),
    theme("BLOG IMAGE")
    );

    echo $this->view->render("blog-post", [
      "head"=>$head,
      "data"=>$this->seo->data() 
    ]);
  }

  public function login(): void
  {
    $head = $this->seo->render(
      
      "Entrar - " . CONF_SITE_NAME,
      CONF_SITE_DESC,
      url("/entrar"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("auth-login", [
      "head"=>$head 
    ]);
  }

  public function forget(): void
  {
    $head = $this->seo->render(
      
      "Recuperar Senha - " . CONF_SITE_NAME,
      CONF_SITE_DESC,
      url("/recuperar"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("auth-forget", [
      "head"=>$head 
    ]);
  }

  public function register(): void
  {
    $head = $this->seo->render(
      
      "Criar Conta - " . CONF_SITE_NAME,
      CONF_SITE_DESC,
      url("/cadastrar"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("auth-register", [
      "head"=>$head 
    ]);
  }

  public function confirm(): void
  {
    $head = $this->seo->render(
      
      "Confirme seu cadastro - " . CONF_SITE_NAME,
      CONF_SITE_DESC,
      url("/confirma"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("optin-confirm", [
      "head"=>$head 
    ]);
  }

  public function success(): void
  {
    $head = $this->seo->render(
      
      "Bem-vindo(a) ao " . CONF_SITE_NAME,
      CONF_SITE_DESC,
      url("/obrigado"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("optin-success", [
      "head"=>$head 
    ]);
  }


  public function terms(): void
  {
    $head = $this->seo->render(
      
      CONF_SITE_NAME . " - Termos de uso",
      CONF_SITE_DESC,
      url("/termos"),
      theme("/assets/images/share.jpg")
    );

    echo $this->view->render("terms", [
      "head"=>$head,
      "video" => "o33OxhNWd5o"  
    ]);
  }

  public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message = "Parece que nosso serviço não está diponível no momento. Já estamos vendo isso mas caso precise, envie um e-mail :)";
                $error->linkTitle = "ENVIAR E-MAIL";
                $error->link = "mailto:". CONF_MAIL_SUPPORT;
                break;

            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe. Estamos em manutenção!";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas :P";
                $error->linkTitle = null;
                $error->link = null;
                break;

            default:
                $error->code = $data['errcode'];
                $error->title = "Ooops. Conteúdo indispinível :/";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            "{$error->code} | {$error->title}",
            $error->message,
            url("/ops/{$error->code}"),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}