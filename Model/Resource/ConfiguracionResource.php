<?php

namespace Model\Resource;
use Model\Resource\AbstractResource;
use Model\Entity\Configuracion;
/**
 * Class Resource
 * @package Model
 */
class ConfiguracionResource extends AbstractResource {
    /**
     * @param $id
     *
     * @return string
     */
     private static $instance;

     public static function getInstance() {
         if (!isset(self::$instance)) {
           self::$instance = new self();
         }
         return self::$instance;
     }

    private function __construct() {}

    public function get($clave = null)
    {
        if ($clave === null) {
            $configuracion = $this->getEntityManager()->getRepository('Model\Entity\Configuracion')->findAll();
            $data = $configuracion;}
         else {
            $data = $this->getEntityManager()->getRepository('Model\Entity\Configuracion')->findOneBy(array('clave'=> $clave));
        }
        return $data;
    }

   public function edit($clave,$valor)
    {
        $configuracion = $this->getEntityManager()->getReference('Model\Entity\Configuracion', $clave);
        $configuracion->setValor($valor);
        $this->getEntityManager()->persist($configuracion);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function delete($id)
    {
        $configuracion = $this->getEntityManager()->getReference('Model\Entity\Usuario', $clave);
        $this->getEntityManager()->remove($configuracion);
        $this->getEntityManager()->flush();
        return $this->get();
    }
    public function Nuevo ($clave,$valor){
        $configuracion = new Configuracion();
        $configuracion->setClave($clave);
        $configuracion->setValor($valor);
        return $configuracion;
    }
    public function insert ($clave,$valor){
        $this->getEntityManager()->persist($this->Nuevo($clave,$valor));
        $this->getEntityManager()->flush();
        return $this->get();
    }
}

?>
