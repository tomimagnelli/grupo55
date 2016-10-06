<?php
namespace Model\Entity;
use Model\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="ubicacion")
 */
class Ubicacion
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
     * @var string
     * @Column(type="string", length=45)
     */
    protected $nombre;
     /**
      * @OneToMany(targetEntity="Usuario", mappedBy="ubicacion_id")
     */
      protected $users;
      /**
      * @var string
      * @Column(type="string", length=255)
      */
     protected $descripcion;

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}

?>
