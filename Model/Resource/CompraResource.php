<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\Compra;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class Resource
 * @package Model
 */
class CompraResource extends AbstractResource {

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
            $compras = $this->getEntityManager()->getRepository('Model\Entity\Compra')->findAll();
            $data = $compras;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Compra', $id);
        }
        return $data;
    }

    public function nuevo ($app,$proveedor,$proveedor_cuit){
        $compra = new Compra();
        $compra->setProveedor($proveedor);
        $compra->setProveedorCuit($proveedor_cuit);
        $compra->setFecha();
        if (isset($_FILES["myFileInfo"])) {
          $target_path = "uploads/";
          $target_path = $target_path . basename( $_FILES["myFileInfo"]['name']); move_uploaded_file($_FILES["myFileInfo"]['tmp_name'], $target_path);
          $compra->setFactura($target_path);
        }
        return $compra;
    }

    public function edit($app,$editproveedor,$editproveedor_cuit,$compraid)
     {
         $compra = $this->getEntityManager()->getReference('Model\Entity\Compra', $compraid);
         $compra->setProveedor($editproveedor);
         $compra->setProveedorCuit($editproveedor_cuit);
         $compra->setFecha();
         if (isset($_FILES["myFileInfo"])) {
           $target_path = "uploads/";
           $target_path = $target_path . basename( $_FILES["myFileInfo"]['name']); move_uploaded_file($_FILES["myFileInfo"]['tmp_name'], $target_path);
           $compra->setFactura($target_path);
         }
         $this->getEntityManager()->persist($compra);
         $this->getEntityManager()->flush();
         return $this->get();
     }

     public function delete($id)
     {
         $compra = $this->getEntityManager()->getReference('Model\Entity\Compra', $id);
         $this->getEntityManager()->remove($compra);
         $this->getEntityManager()->flush();
         return $this->get();
     }

    public function insert($app,$proovedor,$proovedor_cuit){
        $this->getEntityManager()->persist($this->nuevo($app,$proovedor,$proovedor_cuit));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function getPaginateCompra($pageSize,$currentPage){
        $em = $this->getEntityManager();
        $dql = "SELECT c FROM Model\Entity\Compra c";
        $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;

    }

  }


?>
