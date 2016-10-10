<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\EgresoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * Class Resource
 * @package Model
 */
class EgresoDetalleResource extends AbstractResource {

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
            $egresos = $this->getEntityManager()->getRepository('Model\Entity\EgresoDetalle')->findAll();
            $data = $egresos;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\EgresoDetalle', $id);
        }
        return $data;
    }

    public function getEgresosDeCompra($idCompra)
    {
      $query_string = "
          SELECT e FROM Model\Entity\EgresoDetalle e
          WHERE e.compra_id = :idCompra";
      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('idCompra',$idCompra);
      return $query->getResult();
    }

     public function compra($id) {
      $egreso = $this->getEntityManager()->getReference('Model\Entity\EgresoDetalle', $id);
      $query_string = "
          SELECT c FROM Model\Entity\Compra c
          WHERE c.id = :idEgreso";
      $query = $this->getEntityManager()->createQuery($query_string);
      $idCompra = $egreso->getCompra_Id();
      $query->setParameter('idEgreso',$idCompra);
      return $query->getResult();
    }

    public function producto($id) {
      $egreso = $this->getEntityManager()->getReference('Model\Entity\EgresoDetalle', $id);
      $query_string = "
          SELECT p FROM Model\Entity\Producto p
          WHERE p.id = :idEgreso";
      $query = $this->getEntityManager()->createQuery($query_string);
      $idProducto = $egreso->getProducto_Id();
      $query->setParameter('idEgreso',$idProducto);
      return $query->getResult();
    }

   }

?>