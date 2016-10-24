<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\PedidoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Entity\Pedido;
/**
 * Class Resource
 * @package Model
 */
class PedidoDetalleResource extends AbstractResource {

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
            $pedidos_detalle = $this->getEntityManager()->getRepository('Model\Entity\PedidoDetalle')->findAll();
            $data = $ingresos;}
         else {
           $data = $this->getEntityManager()->getRepository('Model\Entity\PedidoDetalle')->findOneBy(array('id'=> $id));
        }
        return $data;
    }

    

   }

?>
