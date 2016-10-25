<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Estado;

/**
 * Class Resource
 * @package Model
 */
class EstadoResource extends AbstractResource {

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
            $estados = $this->getEntityManager()->getRepository('Model\Entity\Estado')->findAll();
            $data = $estados;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Estado', $id);
        }
        return $data;
    }
}

?>