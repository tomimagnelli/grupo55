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

    if ($_SESSION['csrf_token']!=$token) {
        $app->flash('error', "No esta seguro ".$token."-".$_SESSION['csrf_token']);
        $app->redirect('/logout');
  }

}
}
