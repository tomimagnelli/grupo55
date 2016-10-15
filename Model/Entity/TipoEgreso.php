<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;
/**
 * @Entity @Table(name="egreso_tipo")
 **/
class TipoEgreso
{
    /**
      * @Id @Column(type="integer") @GeneratedValue
     * @var int
    */
    protected $id;
    /**
    * @Column(type="string", length=45)
    * @var string
    */
    protected $nombre;


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
     * Gets the value of nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Sets the value of nombre.
     *
     * @param string $nombre the nombre
     *
     * @return self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}
