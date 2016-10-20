<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\Usuario;
use Model\Entity\Producto;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * Class Resource
 * @package Model
 */
class UsuarioResource extends AbstractResource {

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
            $usuarios = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findAll();
            $data = $usuarios;}
         else {
            $data = $this->getEntityManager()->find('Model\Entity\Usuario', $id);
        }
        return $data;
    }

   public function edit($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$habilitado, $id)
    {
        $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
        $ubicacion = UbicacionResource::getInstance()->get($ubicacion_id);
        $usuario->setUsuario($user);
        $usuario->setClave(md5($pass));
        $usuario->setNombre($nombre);
        $usuario->setRol_Id($rol_id);
        $usuario->setEmail($email);
        $usuario->setTelefono($telefono);
        $usuario->setDocumento($documento);
        $usuario->setApellido($apellido);
        $usuario->setUbicacion_Id($ubicacion);
        $usuario->setHabilitado($habilitado);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }

   public function cambiarPass($id,$pass)
    {
        $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
        $usuario->setClave($pass);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function delete($id)
    {
        $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
        $this->getEntityManager()->remove($usuario);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function Nuevo ($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$habilitado){
        $usuario = new Usuario();
        $ubicacion = UbicacionResource::getInstance()->get($ubicacion_id);
        $usuario->setUsuario($user);
        $usuario->setClave(md5($pass));
        $usuario->setNombre($nombre);
        $usuario->setRol_Id($rol_id);
        $usuario->setEmail($email);
        $usuario->setTelefono($telefono);
        $usuario->setDocumento($documento);
        $usuario->setApellido($apellido);
        $usuario->setUbicacion_Id($ubicacion);
        $usuario->setHabilitado($habilitado);
        return $usuario;
    }

    public function insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$habilitado){
        $this->getEntityManager()->persist($this->Nuevo($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id,$habilitado));
        $this->getEntityManager()->flush();
        return $this->get();
    }

    public function login($username, $pass)
    {
        $data = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findOneBy(array('usuario' => $username));
        if ($data != null) {
          if (($data->getClave() == md5($pass))) return $data;
          else return false;
        }
        else return false;
    }


    public function ubicacion($id) {
      $usuario = $this->getEntityManager()->getReference('Model\Entity\Usuario', $id);
      $query_string = "
          SELECT u.nombre, u.descripcion FROM Model\Entity\Ubicacion u
          WHERE u.id = :idUser";
      $query = $this->getEntityManager()->createQuery($query_string);
      $idUb = $usuario->getUbicacion_Id();
      $query->setParameter('idUser',$idUb);
      return $query->getResult();
  }

  public function getPaginateUsuario($pageSize,$currentPage){
      $em = $this->getEntityManager();
      $dql = "SELECT u FROM Model\Entity\Usuario u";
      $query = $em->createQuery($dql)->setFirstResult($pageSize * (intval($currentPage) - 1))->setMaxResults($pageSize);
      $paginator = new Paginator($query, $fetchJoinCollection = true);
      return $paginator;
  }

  public function estaHabilitado($username, $pass)
      {
          $data = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findOneBy(array('usuario' => $username));
          if ($data != null) {
            if ($data->getHabilitado() == 0) return $data;
            else return false;
          }
          else return false;
      }

      public function existeUsuario ($username){
       $data = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findOneBy(array('usuario' => $username));
       if ($data != null){
          return false;
       }
      else{
          return true;
       }
      }


      public function existeUsuarioEdit ($username, $id){
       $data = $this->getEntityManager()->getRepository('Model\Entity\Usuario')->findOneBy(array('usuario' => $id));

      if ($data != null){
         if ( $username == $data->getUsuario()){
          return true;
          }
          else{
           $this->existeUsuario($username);
          }
      }

      }




}

?>
