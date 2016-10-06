<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Ubicacion;

/**
 * Class Resource
 * @package Model
 */
class UbicacionResource extends AbstractResource {

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
            $usuarios = $this->getEntityManager()->getRepository('Model\Entity\Ubicacion')->findAll();
            $data = $usuarios;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Ubicacion', $id);
        }
        return $data;
    }
}

?>
