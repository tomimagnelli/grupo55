<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="ingreso_detalle")
 **/
 class IngresoDetalle
 {
     /**
       * @Id @Column(type="integer") @GeneratedValue
      * @var int
     */
     protected $id;
     /**
      * @ManyToOne(targetEntity="Producto", inversedBy="ingreso_detalle")
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
      * @ManyToOne(targetEntity="TipoIngreso", inversedBy="ingreso_detalle")
      * @JoinColumn(name="ingreso_tipo_id", referencedColumnName="id")
      */
     protected $ingreso_tipo_id;
     /**
      * @Column(type="datetime")
      * @var datetime
      */
     protected $fecha;
     /**
      * @var String
      * @Column(type="string")
      */
     protected $descripcion;


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
      * Gets the value of precio_unitario.
      *
      * @return Decimal
      */
     public function getPrecioUnitario()
     {
         return $this->precio_unitario;
     }

     /**
      * Sets the value of precio_unitario.
      *
      * @param Decimal $precio_unitario the precio unitario
      *
      * @return self
      */
     public function setPrecioUnitario($precio_unitario)
     {
         $this->precio_unitario = $precio_unitario;

         return $this;
     }

     /**
      * Gets the value of ingreso_tipo_id.
      *
      * @return mixed
      */
     public function getIngresoTipoId()
     {
         return $this->ingreso_tipo_id;
     }

     /**
      * Sets the value of ingreso_tipo_id.
      *
      * @param mixed $ingreso_tipo_id the ingreso tipo id
      *
      * @return self
      */
     public function setIngresoTipoId($ingreso_tipo_id)
     {
         $this->ingreso_tipo_id = $ingreso_tipo_id;

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


     /**
      * Gets the value of precio_unitario.
      *
      * @return Decimal
      */
     public function getDescripcion()
     {
         return $this->descripcion;
     }

     /**
      * Sets the value of precio_unitario.
      *
      * @param Decimal $precio_unitario the precio unitario
      *
      * @return self
      */
     public function setDescripcion($descripcion)
     {
         $this->descripcion = $descripcion;

         return $this;
     }
}

?>
