<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="ingreso_detalle")
 **/
class IngresoDetalle {
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
     /**
     * @ManyToOne(targetEntity="Producto", inversedBy="ingresos")
     * @JoinColumn(name="producto_id", referencedColumnName="id")
     */

    protected $producto_id;

   /**
     * @ManyToOne(targetEntity="TipoIngreso", inversedBy="ingresos")
     * @JoinColumn(name="ingreso_tipo_id", referencedColumnName="id")
     */
    protected $ingreso_tipo_id;

    /**
    * @Column(type="integer")
    * @var integer
    */
    protected $cantidad;
   
    /**
    * @Column(type="float")
    * @var float
    */
    protected $precio_unitario;

     /**
    * @Column(type="string", length=255)
    * @var string
    */
    protected $descripcion;
  
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha;

    public function getId()
    {
        return $this->id;
    }


    public function getProducto_Id()
    {
            return $this->producto_id;
    }

    public function setProducto_Id($producto_id)
    {
            $this->producto_id = $producto_id;
    }
    public function getCantidad()
    {
            return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
            $this->cantidad = $cantidad;
    }
    public function getPrecio_Unitario()
    {
            return $this->precio_unitario;
    }

    public function setPrecio_Unitario($precio_unitario)
    {
            $this->precio_unitario = $precio_unitario;
    }
    
    public function getIngreso_Tipo_Id()
    {
            return $this->ingreso_tipo_id;
    }

    public function setIngreso_Tipo_Id($ingreso_tipo_id)
    {
            $this->ingreso_tipo_id = $ingreso_tipo_id;
    }

    public function getDescripcion()
    {
            return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
            $this->descripcion = $descripcion;
    }

    public function getFecha()
    {
            return $this->fecha;
    }

    public function setFecha($fecha)
    {
            $this->fecha = $fecha;
    }

    public function setFechaAlta()
    {
        $this->fecha = new \DateTime("now");
    }
}

?>