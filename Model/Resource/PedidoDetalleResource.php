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
            $data = $pedidos_detalle;}
         else {
           $data = $this->getEntityManager()->getRepository('Model\Entity\PedidoDetalle')->findOneBy(array('id'=> $id));
        }
        return $data;
    }


    public function getPaginatePedidosUsuarioProd($pageSize,$idPedido,$currentPage){
        $em = $this->getEntityManager();
        $dql = "
            SELECT p
            FROM Model\Entity\PedidoDetalle p
            WHERE p.pedido_id = :idPedido";
        $query = $em->createQuery($dql);
        $query->setParameter('idPedido',$idPedido);
          $query->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;

    }

    public function NuevoProd ($producto, $cant, $pedido){
        $pedidodetalle = new PedidoDetalle();
        $pe = PedidoResource::getInstance()->get($pedido);
        $prod = ProductoResource::getInstance()->get($producto);
        $pedidodetalle->setProducto($prod);
        $pedidodetalle->setCantidad($cant);
        $pedidodetalle->setPedido($pe);
        return $pedidodetalle;
    }

    public function insertProd($producto, $cant, $pedido){
        $this->getEntityManager()->persist($this->NuevoProd($producto, $cant, $pedido));
        $this->getEntityManager()->flush();
        return $this->get();
    }


   }

?>
