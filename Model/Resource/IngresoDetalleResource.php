<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\IngresoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Entity\TipoIngreso;
/**
 * Class Resource
 * @package Model
 */
class IngresoDetalleResource extends AbstractResource {

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
            $ingresos = $this->getEntityManager()->getRepository('Model\Entity\IngresoDetalle')->findAll();
            $data = $ingresos;}
         else {
           $data = $this->getEntityManager()->getRepository('Model\Entity\IngresoDetalle')->findOneBy(array('id'=> $id));
        }
        return $data;
    }

     public function delete($id)
    {
        $ingreso = $this->getEntityManager()->getReference('Model\Entity\IngresoDetalle', $id);
        $this->getEntityManager()->remove($ingreso);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function editVenta($producto,$cantidad,$precio_unitario,$ingreso_tipo_id,$descripcion, $id)
      {
          $ingreso = $this->getEntityManager()->getReference('Model\Entity\IngresoDetalle', $id);
          $prod = ProductoResource::getInstance()->get($producto);
          $tipo = TipoIngresoResource::getInstance()->get($ingreso_tipo_id);
          $ingreso->setProducto($prod);
          $ingreso->setCantidad($cantidad);
          $ingreso->setPrecioUnitario($precio_unitario);
          $ingreso->setIngresoTipoId($tipo);
          $ingreso->setFecha();
          $ingreso->setDescripcion($descripcion);

          $this->getEntityManager()->persist($ingreso);
          $this->getEntityManager()->flush();
          return $this->get();
      }



    public function producto($id) {
      $igreso = $this->getEntityManager()->getReference('Model\Entity\IngresoDetalle', $id);
      $query_string = "
          SELECT p FROM Model\Entity\Producto p
          WHERE p.id = :idIngreso";
      $query = $this->getEntityManager()->createQuery($query_string);
      $idProducto = $igreso->getProducto_Id();
      $query->setParameter('idIngreso',$idProducto);
      return $query->getResult();
    }


    public function Nuevo ($ingreso_tipo_id,$producto,$cantidad,$precio_unitario, $descripcion){
        $ingreso_detalle = new IngresoDetalle();
        $tipoingreso = TipoIngresoResource::getInstance()->get($ingreso_tipo_id);
        $prod = ProductoResource::getInstance()->get($producto);
        $ingreso_detalle->setIngresoTipoId($tipoingreso);
        $ingreso_detalle->setProducto($prod);
        $ingreso_detalle->setCantidad($cantidad);
        $ingreso_detalle->setPrecioUnitario($prod->getPrecio_Venta_Unitario());
        $ingreso_detalle->setDescripcion($descripcion);
        $ingreso_detalle->setFecha();
        return $ingreso_detalle;
    }

    public function getPaginateIngreso($pageSize,$currentPage){
        $em = $this->getEntityManager();
        $dql = "SELECT i FROM Model\Entity\IngresoDetalle i";
        $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;

    }


    public function insert($ingreso_tipo_id,$producto,$cantidad,$precio_unitario, $descripcion){
        $this->getEntityManager()->persist($this->Nuevo($ingreso_tipo_id,$producto,$cantidad,$precio_unitario,$descripcion));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function hayStock($producto_id, $cantidad){

      $query_string = " SELECT p FROM Model\Entity\Producto p
                        WHERE (p.id = $producto_id) and (p.stock >= $cantidad)";

      $query = $this->getEntityManager()->createQuery($query_string);

      if (is_null($query)){
      $app->flash('error', 'No hay stock para el producto seleccionado');
      }
      else {
        return true;
      }

    }

    public function buscar ($desde, $hasta){


      $query_string = " SELECT i FROM Model\Entity\IngresoDetalle i
                        WHERE (i.fecha >= :fechadesde) and (i.fecha <= :fechahasta)";

      $query = $this->getEntityManager()->createQuery($query_string);

      $query->setParameter('fechadesde',$desde);
      $query->setParameter('fechahasta',$hasta);

      return $query->getResult();

    }
    public function buscarpedidos($desde, $hasta){


      $query_string = " SELECT p FROM Model\Entity\Pedido p
                        WHERE (p.fecha_alta >= :fechadesde) AND (p.fecha_alta <= :fechahasta) AND (p.estado IS NOT NULL)";

      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('fechadesde',$desde);
      $query->setParameter('fechahasta',$hasta);

      return $query->getResult();


    }

    public function buscarDetalles($pedido){

      $idpedido = $pedido->getId();

      $query_string = " SELECT pd FROM Model\Entity\PedidoDetalle pd
                        WHERE pd.pedido_id = :idPedido";

      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('idPedido',$idpedido);

      return $query->getResult();


    }

    public function sumaingresos($ingresos){

     $total= 0;
     foreach ($ingresos as $i){
        $prod = ProductoResource::getInstance()->get($i->getProducto()->getId());
        $total = $total + ( $i->getCantidad() * $prod->getPrecio_Venta_Unitario() );
     }

     return $total;


    }

    public function sumaPedidos($pedidos){

      $total = 0;
      foreach ($pedidos as $p) {

         if ($p->getEstado() != null){
              if ($p->getEstado()->getNombre() == 'Entregado') {

                  $sumactual = 0;
                  $detalles = $this->buscarDetalles($p);
                  foreach ($detalles as $d) {
                    $prod = ProductoResource::getInstance()->get($d->getProducto()->getId());
                    $sumactual = $sumactual + ($d->getCantidad() * $prod->getPrecio_Venta_Unitario());
                  }

                  $total = $total + $sumactual;
            }
          }
          
        
      }

      return $total;
 
    }

    public function getSumIngresos($desde,$hasta)
    {
        $query_string = "
            SELECT sum(i.precio_unitario * i.cantidad) as y, i.fecha as name
            FROM Model\Entity\IngresoDetalle i
            WHERE i.fecha between :desde AND :hasta
            GROUP by i.fecha
            ORDER by i.fecha";

        $query = $this->getEntityManager()->createQuery($query_string);
        $query->setParameter('desde', new \DateTime($desde));
        $query->setParameter('hasta', new \DateTime($hasta));

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
