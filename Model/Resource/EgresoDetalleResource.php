<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\EgresoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Compra;
use Model\Resource\CompraResource;
use Model\Entity\TipoEgreso;
use Model\Resource\TipoEgresoResource;
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
           $data = $this->getEntityManager()->getRepository('Model\Entity\EgresoDetalle')->findOneBy(array('id'=> $id));
        }
        return $data;
    }

    public function Nuevo ($compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id){
        $egreso_detalle = new EgresoDetalle();
        $tipoegreso = TipoEgresoResource::getInstance()->get($egreso_tipo_id);
        $comp = CompraResource::getInstance()->get($compra);
        $prod = ProductoResource::getInstance()->get($producto);
        $egreso_detalle->setEgresoTipoId($tipoegreso);
        $egreso_detalle->setProducto($prod);
        $egreso_detalle->setCompra($comp);
        $egreso_detalle->setCantidad($cantidad);
        $egreso_detalle->setPrecioUnitario($precio_unitario);
        $egreso_detalle->setFecha();
        return $egreso_detalle;
    }

     public function insert($compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id){
        $this->getEntityManager()->persist($this->Nuevo($compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id));
        $this->getEntityManager()->flush();
        return $this->get();
    }




    public function getEgresosDeCompra($idCompra)
        {
          $query_string = "
              SELECT e
              FROM Model\Entity\EgresoDetalle e
              WHERE e.compra = :idCompra";
          $query = $this->getEntityManager()->createQuery($query_string);
          $query->setParameter('idCompra',$idCompra);
          return $query->getResult();
        }

        public function getPaginateEgreso($pageSize,$idCompra,$currentPage){
            $em = $this->getEntityManager();
            $dql = "
                SELECT e
                FROM Model\Entity\EgresoDetalle e
                WHERE e.compra = :idCompra";
            $query = $em->createQuery($dql);
            $query->setParameter('idCompra',$idCompra);
              $query->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
            $paginator = new Paginator($query, $fetchJoinCollection = true);
            return $paginator;

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

    public function delete($id)
        {
            $egreso = $this->getEntityManager()->getReference('Model\Entity\EgresoDetalle', $id);
            $this->getEntityManager()->remove($egreso);
            $this->getEntityManager()->flush();
            return $this->get();
        }


    public function editEgreso($producto,$cantidad,$precio_unitario,$egreso_tipo_id, $id)
   {
       $egreso = $this->getEntityManager()->getReference('Model\Entity\EgresoDetalle', $id);
       $prod = ProductoResource::getInstance()->get($producto);
       $tipo = TipoEgresoResource::getInstance()->get($egreso_tipo_id);
       $egreso->setProducto($prod);
       $egreso->setCantidad($cantidad);
       $egreso->setPrecioUnitario($precio_unitario);
       $egreso->setEgresoTipoId($tipo);
       $egreso->setFecha();

       $this->getEntityManager()->persist($egreso);
       $this->getEntityManager()->flush();
       return $this->get();
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
    public function buscar ($desde, $hasta){


          $query_string = " SELECT c FROM Model\Entity\Compra c
                            WHERE (c.fecha >= :fechadesde) and (c.fecha <= :fechahasta)";

          $query = $this->getEntityManager()->createQuery($query_string);

          $query->setParameter('fechadesde',$desde);
          $query->setParameter('fechahasta',$hasta);

          return $query->getResult();

      }


    public function buscarDetalles($compra){

      $idcompra = $compra->getId();

      $query_string = " SELECT ed FROM Model\Entity\EgresoDetalle ed
                        WHERE ed.compra = :idCompra";

      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('idCompra',$idcompra);

      return $query->getResult();


    }
    


    public function sumaEgresos($egresos){

      $total = 0;
      foreach ($egresos as $e) {


              $sumactual = 0;
              $detalles = $this->buscarDetalles($e);
              foreach ($detalles as $d) {
                $prod = ProductoResource::getInstance()->get($d->getProducto()->getId());
                $sumactual = $sumactual + ($d->getCantidad() * $d->getPrecioUnitario());
              }

              $total = $total + $sumactual;
        
        
      }

      return $total;
 
    }

        public function getSumEgresontre($desde,$hasta)
  {
      $query_string = "
          SELECT sum(e.precio_unitario * e.cantidad) as y, e.fecha as name
          FROM Model\Entity\EgresoDetalle e
          WHERE e.fecha between :desde AND :hasta
          GROUP BY e.fecha
          ORDER by e.fecha asc ";

      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('desde', new \DateTime($desde));
      $query->setParameter('hasta', new \DateTime($hasta));
      return $query->getResult();
  }

   }

?>
