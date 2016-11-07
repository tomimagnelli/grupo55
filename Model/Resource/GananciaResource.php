<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\MenuDelDia;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Entity\IngresoDetalle;
use Model\Entity\EgresoDetalle;
use Model\Entity\Compra;
/**
 * Class Resource
 * @package Model
 */
class GananciaResource extends AbstractResource {

     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

    private function __construct() {}

   

     public function getVentasEntre($desde,$hasta)
    {
        $query_string = "
            SELECT sum(i.cantidad) as y, CONCAT(p.nombre,'-',p.marca) as name
            FROM Model\Entity\IngresoDetalle i JOIN Model\Entity\Producto p
            WHERE i.producto=p.id AND i.fecha between :desde AND :hasta 
            GROUP By i.producto
            ";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', $desde);
        $query->setParameter('hasta', $hasta);

        return $query->getResult();
    }
  

}
?>
