<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\MenuDelDia;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Entity\TipoIngreso;
/**
 * Class Resource
 * @package Model
 */
class MenuDelDiaResource extends AbstractResource {

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
            $menu = $this->getEntityManager()->getRepository('Model\Entity\MenuDelDia')->findAll();
            $data = $menu;}
         else {
           $data = $this->getEntityManager()->getRepository('Model\Entity\MenuDelDia')->findOneBy(array('id'=> $id));
        }
        return $data;
    }

    public function getPaginateMenu($pageSize,$currentPage){
        $em = $this->getEntityManager();
        $dql = "SELECT m FROM Model\Entity\MenuDelDia m";
        $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }

    public function Nuevo ($fecha, $producto, $habilitado){
        $menu = new MenuDelDia();
        $prod = ProductoResource::getInstance()->get($producto);
        $menu->setProducto($prod);
        $menu->setFecha($fecha);
        $menu->setHabilitado($habilitado);
        return $menu;
    }

    public function insert($fecha, $producto, $habilitado){
        $this->getEntityManager()->persist($this->Nuevo($fecha, $producto, $habilitado));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function hoy(){
      $menu = new MenuDelDia();
      $fecha = (new \DateTime())->format('Y-m-d');
      $query_string = "
          SELECT m
          FROM Model\Entity\MenuDelDia m
          WHERE m.fecha = :fecha";
      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('fecha',$fecha);
      $menus = $query->getResult();
      $productos="";
      foreach ($menus as $value) {
      $productos .= ($value->getProducto()->getNombre()); }
      return  $productos;
    }

    public function menusHoy(){
      $menu = new MenuDelDia();
      $fecha = (new \DateTime())->format('Y-m-d');
      $query_string = "
          SELECT m
          FROM Model\Entity\MenuDelDia m
          WHERE m.fecha = :fecha";
      $query = $this->getEntityManager()->createQuery($query_string);
      $query->setParameter('fecha',$fecha);
      return $query->getResult();


    }





}
?>
