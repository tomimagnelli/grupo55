<?php
namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\PedidoDetalle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Model\Entity\Producto;
use Model\Entity\Usuario;
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


    

   }

?>
