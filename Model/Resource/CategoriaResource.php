<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\Categoria;
/**
 * Class Resource
 * @package Model
 */
class CategoriaResource extends AbstractResource {

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
            $categorias = $this->getEntityManager()->getRepository('Model\Entity\Categoria')->findAll();
            $data = $categorias;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Categoria', $id);
        }
        return $data;
    }

}

?>
