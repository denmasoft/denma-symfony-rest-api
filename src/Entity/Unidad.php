<?php
/**
 * Unidad.php
 *
 * Unidad Entity
 *
 * @category   Entity
 * @author     Taowl
 */


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Unidad de medida.
 *
 * @ORM\Table(name="unidades")
 * @ORM\Entity(repositoryClass="App\Repository\UnidadRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Unidad
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
     * @ORM\OneToMany(targetEntity="App\Entity\TigieFraccion", mappedBy="unidad")
     * @Serializer\Exclude()
     */
    protected $fracciones;

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
}