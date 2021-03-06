<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\TipoIngreso;

/**
 * Class Resource
 * @package Model
 */
class TipoIngresoResource extends AbstractResource {

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
            $tiposingreso = $this->getEntityManager()->getRepository('Model\Entity\TipoIngreso')->findAll();
            $data = $tiposingreso;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\TipoIngreso', $id);
        }
        return $data;
    }
}

?>
