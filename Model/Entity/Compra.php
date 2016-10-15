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
       * @Id @Column(type="integer") @GeneratedValue
      * @var int
     */
     protected $id;
     /**
      * @Column(type="string")
      * @var string
     */
     protected $proveedor;
     /**
     * @Column(type="string")
     * @var string
     */
     protected $proveedor_cuit;
     /**
      * @Column(type="datetime")
      * @var DateTime
      */
     protected $fecha;

     /**
      * Gets the value of id.
      *
      * @return int
      */
     public function getId()
     {
         return $this->id;
     }

     /**
      * Sets the value of id.
      *
      * @param int $id the id
      *
      * @return self
      */
     public function setId($id)
     {
         $this->id = $id;

         return $this;
     }

     /**
      * Gets the value of proovedor.
      *
      * @return string
      */
     public function getProveedor()
     {
         return $this->proveedor;
     }

     /**
      * Sets the value of proovedor.
      *
      * @param string $proovedor the proovedor
      *
      * @return self
      */
     public function setProveedor($proveedor)
     {
         $this->proveedor = $proveedor;

         return $this;
     }

     /**
      * Gets the value of proovedor_cuit.
      *
      * @return string
      */
     public function getProveedor_Cuit()
     {
         return $this->proveedor_cuit;
     }

     /**
      * Sets the value of proovedor_cuit.
      *
      * @param string $proovedor_cuit the proovedor cuit
      *
      * @return self
      */
     public function setProveedorCuit($proveedor_cuit)
     {
         $this->proveedor_cuit = $proveedor_cuit;

         return $this;
     }


     /**
      * Gets the value of fecha_alta.
      *
      * @return DateTime
      */
     public function getFecha()
     {
         return $this->fecha;
     }

     /**
      * Sets the value of fecha_alta.
      *
      * @param DateTime $fecha_alta the fecha alta
      *
      * @return self
      */
     public function setFecha($fecha)
     {
         $this->fecha = $fecha;

         return $this;
     }
    
}
?>
