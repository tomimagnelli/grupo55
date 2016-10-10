<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="egreso_detalle")
 **/
class EgresoDetalle {
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
     /**
     * @ManyToOne(targetEntity="Compra", inversedBy="egresos")
     * @JoinColumn(name="compra_id", referencedColumnName="id")
     */
    protected $compra_id;

     /**
     * @ManyToOne(targetEntity="Producto", inversedBy="egresos")
     * @JoinColumn(name="producto_id", referencedColumnName="id")
     */
    protected $producto_id;

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
    * @Column(type="integer")
    * @var integer
    */
    protected $egreso_tipo_id;
   
  
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha;

    public function getId()
    {
        return $this->id;
    }

    public function getCompra_Id()
    {
        return $this->compra_id;
    }

    public function setCompra_Id($compra_id)
    {
        $this->compra_id = $compra_id;
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
    
    public function getEgreso_Tipo_Id()
    {
            return $this->egreso_tipo_id;
    }

    public function setEgreso_Tipo_Id($egreso_tipo_id)
    {
            $this->egreso_tipo_id = $egreso_tipo_id;
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
