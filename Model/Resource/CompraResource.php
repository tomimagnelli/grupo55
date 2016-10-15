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

    public function Nuevo ($ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario, $descripcion){
        $compra = new Compra();
        $tipoegresp = TipoIngresoResource::getInstance()->get($ingreso_tipo_id);
        $EgresoDetalle= EgresoDetalle::
        $producto = ProductoResource::getInstance()->get($producto_id);
        $ingreso_detalle->setIngreso_Tipo_Id($tipoingreso);
        $ingreso_detalle->setProducto_Id($producto);
        $ingreso_detalle->setCantidad($cantidad);
        $ingreso_detalle->setPrecio_Unitario($precio_unitario);
        $ingreso_detalle->setDescripcion($descripcion);
        $ingreso_detalle->setFechaAlta();
        return $ingreso_detalle;
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
