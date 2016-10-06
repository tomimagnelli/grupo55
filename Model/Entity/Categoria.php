<?php

namespace Model\Entity;

use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity @Table(name="categoria")
 **/
class Categoria
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @Column(type="string", length=45)
     * @var string
    */
    protected $nombre;
    /**
     * @OneToOne(targetEntity="Categoria")
     * @JoinColumn(name="categoria_padre", referencedColumnName="id")
     **/
    protected $categoria_padre;
    /**
     * @OneToMany(targetEntity="Producto", mappedBy="categoria_id")
    */
     protected $productos;

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
    public function getCategoria_Padre_Id()
    {
        return $this->categoria_padre_id;
    }

    public function setCategoria_Padre_Id($categoria_padre_id)
    {
        $this->categoria_padre_id = $categoria_padre_id;
    }
}
?>
