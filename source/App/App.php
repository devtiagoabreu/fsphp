<?php
namespace Source\App;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Support\Message;
use Source\Models\Report\Access;
use Source\Models\Report\Online;

class App extends Controller
{
  /** @var User */
  private $user;

  /**
   * App constructor
   */
  public function __construct()
  {
    parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");

    if (!$this->user = Auth::user()){
      $this->message->warning("Efetue login para acessar o APP.")->flash();
      redirect("/entrar");
    }

    (new Access())->report();
    (new Online())->report();
    
  }

  /**
   * 
   */
  public function home()
  {
    echo $this->view->render("home", []);
  }

  /**
   * 
   */
  public function logout()
  {
    (new Message())->info("Você saiu com sucesso " . Auth::user()->first_name . ". volte logo :)")->flash();

    Auth::logout();
    redirect("/entrar");
  }


}
