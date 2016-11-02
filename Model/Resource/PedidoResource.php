<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\PedidoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Model\Entity\Pedido;
use Model\Entity\Estado;
/**
 * Class Resource
 * @package Model
 */
class PedidoResource extends AbstractResource {

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
            $pedidos = $this->getEntityManager()->getRepository('Model\Entity\Pedido')->findAll();
            $data = $pedidos;}
         else {
           $data = $this->getEntityManager()->getRepository('Model\Entity\Pedido')->findOneBy(array('id'=> $id));
        }
        return $data;
    }

     public function delete($id)
    {
            $pedido = $this->getEntityManager()->getReference('Model\Entity\Pedido', $id);
            $this->getEntityManager()->remove($pedido);
            $this->getEntityManager()->flush();
            return $this->get();
      }

      public function getPaginatePedidosUsuario($pageSize,$currentPage,$userId){
        $em = $this->getEntityManager();
        $dql = "
            SELECT p
            FROM Model\Entity\Pedido p
            WHERE p.usuario = :userId";
        $query = $em->createQuery($dql);
        $query->setParameter('userId',$userId);
          $query->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;

    }

    public function getPaginatePedidos($pageSize,$currentPage){
      $em = $this->getEntityManager();
      $dql = "
          SELECT p
          FROM Model\Entity\Pedido p
          where p.estado is not null";

      $query = $em->createQuery($dql);
        $query->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
      $paginator = new Paginator($query, $fetchJoinCollection = true);
      return $paginator;

  }
    public function Nuevo ($observacion,$userId){
        $pedido = new Pedido();
        $user = UsuarioResource::getInstance()->get($userId);
        $pedido->setUsuario($user);
        $pedido->setFecha();
        $pedido->setObservacion($observacion);
        return $pedido;
    }

    public function insert($observacion,$userId){
        $this->getEntityManager()->persist($this->Nuevo($observacion,$userId));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function enviar($id){
        $this->getEntityManager()->persist($this->AgregarEstado($id));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function AgregarEstado ($id){
      $pedido = PedidoResource::getInstance() -> get($id);
      $estado = $this->getEntityManager()->getRepository('Model\Entity\Estado')->findOneBy(array('nombre'=> "Pendiente"));
      $pedido->setEstado($estado);
      return $pedido;
  }

  public function aceptar($id)
{
       $pedido = $this->getEntityManager()->getReference('Model\Entity\Pedido', $id);
       $estado = EstadoResource::getInstance()->get(2);
       $pedido->setEstado($estado);
       $this->getEntityManager()->persist($pedido);
       $this->getEntityManager()->flush();
       return $this->get();
}

public function cancelar($id)
{
       $pedido = $this->getEntityManager()->getReference('Model\Entity\Pedido', $id);
       $estado = EstadoResource::getInstance()->get(3);
       $pedido->setEstado($estado);
       $this->getEntityManager()->persist($pedido);
       $this->getEntityManager()->flush();
       return $this->get();
}


   }

?>
