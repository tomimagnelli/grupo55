<?php

namespace Controller;

class CSRF {
  private static $instance;
    public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }
public function control($app,$token)
  {
    $encontrado=false;
    foreach ($_SESSION['csrf_token'] as $t) {
      if($t == $token){
        $encontrado=true;
      }
    }
    if ($encontrado == false) {
        $app->redirect('/logout');
  }

}
}
