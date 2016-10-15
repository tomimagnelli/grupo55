<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\IngresoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
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


    public function Nuevo ($ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario, $descripcion){
        $ingreso_detalle = new IngresoDetalle();
        $tipoingreso = TipoIngresoResource::getInstance()->get($ingreso_tipo_id);
        $producto = ProductoResource::getInstance()->get($producto_id);
        $ingreso_detalle->setIngreso_Tipo_Id($tipoingreso);
        $ingreso_detalle->setProducto_Id($producto);
        $ingreso_detalle->setCantidad($cantidad);
        $ingreso_detalle->setPrecio_Unitario($precio_unitario);
        $ingreso_detalle->setDescripcion($descripcion);
        $ingreso_detalle->setFechaAlta();
        return $ingreso_detalle;
    }

    public function getPaginateIngreso($pageSize,$currentPage){
        $em = $this->getEntityManager();
        $dql = "SELECT i FROM Model\Entity\IngresoDetalle i";
        $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;

    }


    public function insert($ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario, $descripcion){
        $this->getEntityManager()->persist($this->Nuevo($ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario,$descripcion));
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

   }

?>
