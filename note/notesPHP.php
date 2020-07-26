    
    /**
    * DEBUGS 
    */
    
    /**
    *Agendamento de disparos de email
    * inserir código no método construtor do controlador Web.php
    * após o parent::
    */
    $email = new Email();
    $email->bootstrap(
      "Teste de fila de e-mail" . time(),
      "Este é apenas um teste de envio de email",
      "devtiagoabreu@gmail.com",
      "Tiago Abreu"
    )->queue(); //dispara email: send(); | agenda email: queue() | dispara emails agendados: sendQueue()
    var_dump($email);