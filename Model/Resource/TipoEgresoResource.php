<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\TipoEgreso;

/**
 * Class Resource
 * @package Model
 */
class TipoEgresoResource extends AbstractResource {

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
            $tiposegreso = $this->getEntityManager()->getRepository('Model\Entity\TipoEgreso')->findAll();
            $data = $tiposegreso;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\TipoEgreso', $id);
        }
        return $data;
    }
}

?>
