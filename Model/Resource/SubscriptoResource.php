<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Subscripto;

date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * Class Resource
 * @package Model
 */
class SubscriptoResource extends AbstractResource {

     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

    private function __construct() {}

      /**
       * @param $id
       *
       * @return string
       */
    public function get($id = null)
    {
        if ($id === null) {
            $subs = $this->getEntityManager()->getRepository('Model\Entity\Subscripto')->findAll();
            $data = $subs;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Subscripto', $id);
        }
        return $data;
    }

    public function Nuevo ($chat_id){
        $sub = new Subscripto();
        $sub->setChat_Id($chat_id);
        return $sub;
    }

  public function sub($chat_id) {
    try {
      $this->getEntityManager()->persist($this->Nuevo($chat_id));
      $this->getEntityManager()->flush();
    } catch (\Doctrine\DBAL\DBALException $e) {
     return false;
    }
    return $this->get();
  }

  public function unsub($chat_id) {
    $sub = $this->getEntityManager()->getReference('Model\Entity\Subscripto', $chat_id);
    try {
      $this->getEntityManager()->remove($sub);
      $this->getEntityManager()->flush();
    } catch (\Doctrine\DBAL\DBALException $e) {
       return false;
    }
    return $this->get();
  }

}

?>
