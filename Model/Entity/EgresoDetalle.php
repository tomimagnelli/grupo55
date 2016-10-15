<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="egreso_detalle")
 **/
 class EgresoDetalle
 {
     /**
       * @Id @Column(type="integer") @GeneratedValue
      * @var int
     */
     protected $id;
     /**
      * @ManyToOne(targetEntity="Compra", inversedBy="egreso_detalle")
      * @JoinColumn(name="compra_id", referencedColumnName="id")
      */
     protected $compra;
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
      * @var Decimal
      * @Column(type="decimal")
      */
     protected $precio_unitario;
     /**
      * @ManyToOne(targetEntity="TipoEgreso", inversedBy="egreso_tipo")
      * @JoinColumn(name="egreso_tipo_id", referencedColumnName="id")
      */
     protected $egreso_tipo_id;
     /**
      * @Column(type="datetime")
      * @var datetime
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
      * Gets the value of compra_id.
      *
      * @return mixed
      */
     public function getCompra()
     {
         return $this->compra;
     }

     /**
      * Sets the value of compra_id.
      *
      * @param mixed $compra_id the compra id
      *
      * @return self
      */
     public function setCompra($compra_id)
     {
         $this->compra = $compra_id;

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

     /**
      * Gets the value of precioUnitario.
      *
      * @return decimal
      */
     public function getPrecioUnitario()
     {
         return $this->precio_unitario;
     }

     /**
      * Sets the value of precioUnitario.
      *
      * @param decimal $precioUnitario the precio unitario
      *
      * @return self
      */
     public function setPrecioUnitario($precioUnitario)
     {
         $this->precio_unitario = $precioUnitario;

         return $this;
     }

     /**
      * Gets the value of egreso_tipo_id.
      *
      * @return mixed
      */
     public function getEgresoTipoId()
     {
         return $this->egreso_tipo_id;
     }

     /**
      * Sets the value of egreso_tipo_id.
      *
      * @param mixed $egreso_tipo_id the egreso tipo id
      *
      * @return self
      */
     public function setEgresoTipoId($egreso_tipo_id)
     {
         $this->egreso_tipo_id = $egreso_tipo_id;

         return $this;
     }

     /**
      * Gets the value of fecha.
      *
      * @return datetime
      */
     public function getFecha()
     {
         return $this->fecha;
     }

     /**
      * Sets the value of fecha.
      *
      * @param datetime $fecha the fecha
      *
      * @return self
      */
     public function setFecha()
    {
        $this->fecha = new \DateTime("now");
    }
  }

?>
