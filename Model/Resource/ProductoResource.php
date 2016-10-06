<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\Producto;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * Class Resource
 * @package Model
 */
class ProductoResource extends AbstractResource {

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
            $productos = $this->getEntityManager()->getRepository('Model\Entity\Producto')->findAll();
            $data = $productos;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Producto', $id);
        }
        return $data;
    }

   public function edit($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion,$id)
    {
        $producto = $this->getEntityManager()->getReference('Model\Entity\Producto', $id);
        $categoria = CategoriaResource::getInstance()->get($categoria_id);
        $producto->setNombre($nombre);
        $producto->setMarca($marca);
        $producto->setStock($stock);
        $producto->setStock_Minimo($stock_minimo);
        $producto->setProovedor($proovedor);
        $producto->setPrecio_Venta_Unitario($precio_venta_unitario);
        $producto->setCategoria_Id($categoria);
        $producto->setDescripcion($descripcion);
        $this->getEntityManager()->persist($producto);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function delete($id)
    {
        $producto = $this->getEntityManager()->getReference('Model\Entity\Producto', $id);
        $this->getEntityManager()->remove($producto);
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function Nuevo ($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion){
        $producto = new Producto();
        $categoria = CategoriaResource::getInstance()->get($categoria_id);
        $producto->setNombre($nombre);
        $producto->setMarca($marca);
        $producto->setStock($stock);
        $producto->setStock_Minimo($stock_minimo);
        $producto->setProovedor($proovedor);
        $producto->setPrecio_Venta_Unitario($precio_venta_unitario);
        $producto->setFecha();
        $producto->setCategoria_Id($categoria);
        $producto->setDescripcion($descripcion);
        return $producto;
    }

    public function insert($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion){
        $this->getEntityManager()->persist($this->Nuevo($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id,$descripcion));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function categoria($id) {
      $producto = $this->getEntityManager()->getReference('Model\Entity\Producto', $id);
      $query_string = "
          SELECT c.nombre FROM Model\Entity\Categoria c
          WHERE c.id = :idProd";
      $query = $this->getEntityManager()->createQuery($query_string);
      $idCat = $producto->getCategoria_Id();
      $query->setParameter('idProd',$idCat);
      return $query->getResult();
  }

  public function getPaginateStockMin($pageSize,$currentPage){
      $em = $this->getEntityManager();
      $dql = "SELECT p FROM Model\Entity\Producto p WHERE p.stock <= p.stock_minimo";
      $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
      $paginator = new Paginator($query, $fetchJoinCollection = true);
      return $paginator;
  }

  public function getPaginateFaltantes($pageSize,$currentPage){
      $em = $this->getEntityManager();
      $dql = "SELECT p FROM Model\Entity\Producto p WHERE p.stock = 0";
      $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
      $paginator = new Paginator($query, $fetchJoinCollection = true);
      return $paginator;
  }

}

?>
