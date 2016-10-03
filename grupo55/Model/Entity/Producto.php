<?php
/**
 * @Entity @Table(name="producto")
 **/
class Producto
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
    protected $nombre;
    /**
    * @Column(type="string")
    * @var string
    */
    protected $marca;
    /**
    * @Column(type="integer")
    * @var int
    */
    protected $stock;
    /**
    * @Column(type="integer")
    * @var int
    */
    protected $stock_minimo;
    /**
    * @Column(type="integer")
    * @var int
    *//
    protected $proovedor;
    /**
    * @Column(type="float")
    * @var float
    */
    protected $precio_venta_unitario;
    /**
    * @Column(type="integer")
    * @var int
    */
    protected $categoria_id;
    /**
    * @Column(type="string")
    * @var string
    */
    protected $descripcion;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha_alta;

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getMarca()
    {
            return $this->marca;
    }

    public function setMarca($marca)
    {
            $this->marca = $marca;
    }
    public function getStock()
    {
            return $this->stock;
    }

    public function setStock($stock)
    {
            $this->stock = $stock;
    }
    public function getStock_Minimo()
    {
            return $this->stock_minimo;
    }

    public function setStock_Minimo($stock_minimo)
    {
            $this->stock_minimo = $stock_minimo;
    }
    public function getProovedor()
    {
            return $this->proovedor;
    }

    public function setProovedor($proovedor)
    {
            $this->proovedor = $proovedor;
    }
    public function getPrecio_Venta_Unitario()
    {
            return $this->precio_venta_unitario;
    }

    public function setPrecio_Venta_Unitario($precio_venta_unitario)
    {
            $this->precio_venta_unitario = $precio_venta_unitario;
    }
    public function getCategoria_Id()
    {
            return $this->categoria_id;
    }

    public function setCategoria_Id($categoria_id)
    {
            $this->categoria_id = $categoria_id;
    }
    public function getDescripcion()
    {
            return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
            $this->descripcion = $descripcion;
    }
    public function getFecha_Alta()
    {
            return $this->fecha_alta;
    }

    public function setFecha_Alta($fecha_alta)
    {
            $this->fecha_alta = $fecha_alta;
    }
}

?>
