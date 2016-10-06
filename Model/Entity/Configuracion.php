<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity @Table(name="configuracion")
 **/
class Configuracion
{
    /**
      * @Id @Column(name="clave", type="string",length=50)
     * @var integer
    */
    protected $clave;
    /**
     * @Column(type="string", length=2000)
     * @var string
    */
    protected $valor;



    /**
     * Gets the value of clave.
     *
     * @return integer
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Sets the value of clave.
     *
     * @param integer $clave the clave
     *
     * @return self
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Gets the value of valor.
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Sets the value of valor.
     *
     * @param string $valor the valor
     *
     * @return self
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }
}
?>
