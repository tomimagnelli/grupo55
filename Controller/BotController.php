<?php

namespace Controller;
use Model\Entity\Subscripto;
use Model\Resource\MenuResource;
use Model\Resource\SubscriptoResource;

class BotController {
  private static $instance;

  public static function getInstance() {
      if (!isset(self::$instance)) {
        self::$instance = new self();
      }
      return self::$instance;
  }

  private function __construct() {}

  public function hoy() {
    return MenuResource::getInstance()->hoy();
  }

  public function manana() {
    return MenuResource::getInstance()->manana();
  }

  public function sub($chat_id) {
    return (SubscriptoResource::getInstance()->sub($chat_id));
  }

  public function unsub($chat_id) {
    return (SubscriptoResource::getInstance()->unsub($chat_id));
  }

  public function notificar() {
    $subscriptos = SubscriptoResource::getInstance()->get();
    try {
    if ($this->hoy() == '') {
      return false;
    } else {
      foreach ($subscriptos as $sub) {
        $msg = array();
        $msg['chat_id'] = ($sub->getChat_Id());
        $msg['text'] = 'El menú del día es:' . PHP_EOL;
        $msg['text'] .= ($this->hoy());
        $msg['disable_web_page_preview'] = true;
        $msg['reply_to_message_id'] = null;
        $msg['reply_markup'] = null;
        $url = 'https://api.telegram.org/bot296497556:AAFlvyDLjO921sqBVHhpTaV1W5D5GoUFRUw/sendMessage';
        $options = array(
          'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($msg)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
      }
    }
  } catch (Exception $e) {
    return false;
  }
  return true;
  }
}
