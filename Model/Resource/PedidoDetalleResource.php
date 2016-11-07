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

    public function aceptarStock($idPedido){
      $query_string = "
          SELECT p
          FROM Model\Entity\PedidoDetalle p
          WHERE p.pedido_id = :idPedido";
      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('idPedido',$idPedido);
      $pedidos = $query->getResult();
      foreach ($pedidos as $value) {
        if (ProductoResource::getInstance()->controlarStock($value->getProducto()->getId(),$value->getCantidad())){
        }else{
          return false;
        }
    }

      return true;
   }

   public function descontarStock($idPedido){
     $query_string = "
         SELECT p
         FROM Model\Entity\PedidoDetalle p
         WHERE p.pedido_id = :idPedido";
     $query = $this->getEntityManager()->createQuery($query_string);
     $query->setParameter('idPedido',$idPedido);
     $pedidos = $query->getResult();
     foreach ($pedidos as $value) {
       ProductoResource::getInstance()->descontarStock($value->getProducto()->getId(),$value->getCantidad());
     }
 }

 public function getSumPedidos($desde,$hasta)
 {
     $query_string = "
         SELECT sum(p.precio_unitario * pd.cantidad) as y, pe.fecha_alta as name
         FROM Model\Entity\PedidoDetalle pd JOIN Model\Entity\Pedido pe 
         WHERE pe.estado= :estado AND pe.id = pd.pedido_id AND pe.fecha_alta between :desde AND :hasta
         GROUP BY pe.fecha_alta
         ORDER by pe.fecha_alta";

     $query = $this->getEntityManager()->createQuery($query_string);
     $estado = $this->getEntityManager()->getRepository('Model\Entity\Estado')->findOneBy(array('nombre'=> "Entregado"));
     $query->setParameter('desde', new \DateTime($desde));
     $query->setParameter('hasta', new \DateTime($hasta));
     $query->setParameter('estado', $estado);

     return $query->getResult();
 }

 public function getVentasEntre($desde,$hasta)
  {
      $query_string = "
          SELECT sum(i.cantidad) as y, CONCAT(p.nombre,'-',p.marca) as name
          FROM Model\Entity\IngresoDetalle i JOIN Model\Entity\Producto p
          WHERE i.producto=p.id AND i.fecha between :desde AND :hasta
          GROUP By i.producto
          ";

      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('desde', new \DateTime($desde));
      $query->setParameter('hasta', new \DateTime($hasta));

      return $query->getResult();
  }

}
?>
