<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity @Table(name="compra")
 **/
class Compra
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @Column(type="string", length=100)
     * @var string
    */
    protected $proveedor;
    /**
    * @Column(type="string", length=15)
    * @var string
    */
   
    protected $proveedor_cuit;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha;

    public function getId()
    {
        return $this->id;
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }
   
    public function getProveedor_Cuit()
    {
        return $this->proveedor_cuit;
    }

    public function setProveedor_Cuit($proveedor_cuit)
    {
        $this->proveedor_cuit = $proveedor_cuit;
    }
}
?>
