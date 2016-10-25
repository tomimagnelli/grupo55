<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="menu_del_dia")
 **/
 class MenuDelDia
 {
     /**
       * @Id @Column(type="integer") @GeneratedValue
      * @var int
     */
     protected $id;
     /**
      * @ManyToOne(targetEntity="Producto", inversedBy="menu_del_dia")
      * @JoinColumn(name="producto_id", referencedColumnName="id")
      */
     protected $producto;
     /**
      * @Column(type="string")
      * @var string
      */
     protected $fecha;
     /**
      * @var integer
      * @Column(type="integer")
      */
     protected $habilitado;



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
      * Gets the value of producto.
      *
      * @return mixed
      */
     public function getProducto()
     {
         return $this->producto;
     }

     /**
      * Sets the value of producto.
      *
      * @param mixed $producto the producto
      *
      * @return self
      */
     public function setProducto($producto)
     {
         $this->producto = $producto;

         return $this;
     }


     public function getFecha()
     {
         return $this->fecha;
     }

     public function setFecha($fecha)
     {
         $this->fecha = $fecha;
     }

    public function getHabilitado() {
       return $this->habilitado;
   }

   public function setHabilitado($habilitado) {
       $this->habilitado = $habilitado;
   }

}

?>
