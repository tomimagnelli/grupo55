<?php
namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
date_default_timezone_set('America/Argentina/Buenos_Aires');

/**
 * @Entity @Table(name="pedido")
 **/
 class Pedido
 {
     /**
       * @Id @Column(type="integer") @GeneratedValue
      * @var int
     */
     protected $id;

     /**
      * @ManyToOne(targetEntity="Estado", inversedBy="estado")
      * @JoinColumn(name="estado_id", referencedColumnName="id")
      */
     protected $estado;

     /**
      * @ManyToOne(targetEntity="Usuario", inversedBy="usuario")
      * @JoinColumn(name="usuario_id", referencedColumnName="id")
      */
     protected $usuario;
     /**
    * @Column(type="string", length=255)
    * @var string
    */
     protected $observacion;

     /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $fecha_alta;
    /**
    * @Column(type="integer")
    * @var int
    */




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
      * Gets the value of estado_id.
      *
      * @return integer
      */
     public function getEstado()
     {
         return $this->estado;
     }

     /**
      * Sets the value of cantidad.
      *
      * @param integer $estado_id the estado_id
      *
      * @return self
      */
     public function setEstado($estado)
     {
         $this->estado = $estado;

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
     public function setProducto($producto)
     {
         $this->producto = $producto;

         return $this;
     }

     public function getFecha()
    {
            return $this->fecha_alta;
    }


    public function setFecha()
    {
        $this->fecha_alta = new \DateTime("now");
    }


    /**
      * Gets the value of usuario_id.
      *
      * @return mixed
      */
     public function getUsuario()
     {
         return $this->usuario;
     }

     /**
      * Sets the value of usuario_id.
      *
      * @param mixed $usuario_id the usuario id
      *
      * @return self
      */
     public function setUsuario($usuario)
     {
         $this->usuario = $usuario;

         return $this;
     }

     /**
     * Gets the value of observacion.
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Sets the value of observacion.
     *
     * @param string $observacion the observacion
     *
     * @return self
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }


  }

?>
