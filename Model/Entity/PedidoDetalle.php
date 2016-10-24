<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="pedido_detalle")
 **/
 class PedidoDetalle
 {
     /**
       * @Id @Column(type="integer") @GeneratedValue
      * @var int
     */
     protected $id;
     /**
      * @ManyToOne(targetEntity="Pedido", inversedBy="pedido_detalle")
      * @JoinColumn(name="pedido_id", referencedColumnName="id")
      */
     protected $pedido_id;
     /**
      * @ManyToOne(targetEntity="Producto", inversedBy="egreso_detalle")
      * @JoinColumn(name="producto_id", referencedColumnName="id")
      */
     protected $producto;
     /**
     * @Column(type="integer")
     * @var integer
     */
     protected $cantidad;
   


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
      * Gets the value of pedido_id.
      *
      * @return mixed
      */
     public function getPedido()
     {
         return $this->pedido_id;
     }

     /**
      * Sets the value of pedido_id.
      *
      * @param mixed $pedido_id the pedido id
      *
      * @return self
      */
     public function setPedido($pedido_id)
     {
         $this->pedido = $pedido_id;

         return $this;
     }

     /**
      * Gets the value of producto_id.
      *
      * @return mixed
      */
     public function getProducto()
     {
         return $this->producto;
     }

     /**
      * Sets the value of producto_id.
      *
      * @param mixed $producto_id the producto id
      *
      * @return self
      */
     public function setProducto($producto_id)
     {
         $this->producto = $producto_id;

         return $this;
     }

     /**
      * Gets the value of cantidad.
      *
      * @return integer
      */
     public function getCantidad()
     {
         return $this->cantidad;
     }

     /**
      * Sets the value of cantidad.
      *
      * @param integer $cantidad the cantidad
      *
      * @return self
      */
     public function setCantidad($cantidad)
     {
         $this->cantidad = $cantidad;

         return $this;
     }

     
  }

?>
