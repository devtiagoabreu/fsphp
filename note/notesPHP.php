    
    /**
    * DEBUGS 
    */
    
    /**
    * Debugs by 
    * OBS: Método home() do controlador Web.php 
    */
    $model = (new Category())->find()->fetch(true); ou $model = (new Category())->findByUri("controle");
    var_dump($model);

    /**
    * Debugs by 10.04 - Agendamento de disparos
    * OBS: Método construtor do controlador Web.php após o parent::
    */
    $email = new Email();
    $email->bootstrap(
      "Teste de fila de e-mail" . time(),
      "Este é apenas um teste de envio de email",
      "devtiagoabreu@gmail.com",
      "Tiago Abreu"
    )->queue(); //dispara email: send(); | agenda email: queue() | dispara emails agendados: sendQueue()
    var_dump($email);

    /**
    * Debugs by 10.06 - Acesso e estatísticas internas
    * OBS: Método construtor do controlador Web.php após o parent::
    */
    $access = (new Access())->report();
    var_dump($access);