<?php
/**
 * TipoOperacion.php
 *
 * Tipo de Operacion Entity
 *
 * @category   Entity
 * @author     Taowl
 */


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Tipo de operacion.
 *
 * @ORM\Table(name="tipo_operacion")
 * @ORM\Entity(repositoryClass="App\Repository\TipoOperacionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TipoOperacion
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nombre", type="string")
     */
    protected $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TigieFraccion", mappedBy="tipoOperacion")
     * @Serializer\Exclude()
     */
    protected $fracciones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Noms", mappedBy="tipoOper")
     * @Serializer\Exclude()
     */
    protected $noms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Permisos", mappedBy="tipoOperacion")
     * @Serializer\Exclude()
     */
    protected $permisos;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Serializer\Exclude()
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Serializer\Exclude()
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->fracciones = new ArrayCollection();
        $this->noms = new ArrayCollection();
        $this->permisos = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $dateTimeNow = new DateTime('now');
        $this->setUpdatedAt($dateTimeNow);
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }
    /**
     * @return mixed
     */
    public function getFracciones()
    {
        return $this->fracciones;
    }

    /**
     * @param mixed $fracciones
     */
    public function setFracciones($fracciones)
    {
        $this->fracciones = $fracciones;
    }

    /**
     * @return mixed
     */
    public function getNoms()
    {
        return $this->noms;
    }

    /**
     * @param mixed noms
     */
    public function setNoms($noms)
    {
        $this->noms = $noms;
    }

    /**
     * @return mixed
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * @param mixed permisos
     */
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }
}