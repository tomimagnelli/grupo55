<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use vendor\doctrine\common\lib\Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Model\Entity\Usuario;
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

   public function edit($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null, $id)
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
    public function Nuevo ($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null){
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
        return $usuario;
    }

    public function insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null){
        $this->getEntityManager()->persist($this->Nuevo($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id));
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

}

?>
