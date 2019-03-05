<?php
/**
 * TigieCapitulo.php
 *
 * TigieCapitulo Entity
 *
 * @category   Entity
 * @author     Taowl
 */


namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * TigieCapitulo.
 *
 * @ORM\Table(name="tigie_capitulos")
 * @ORM\Entity(repositoryClass="App\Repository\TigieCapituloRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TigieCapitulo
{
    /**
     * @ORM\Column(name="ID_CAP", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="CAPITULO", type="string")
     */
    protected $capitulo;

        /**
     * @ORM\Column(name="DESC_CAP", type="string")
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="INI_VIG", type="datetime", nullable=true)
     */
    protected $inicioVigencia;

    /**
     * @ORM\Column(name="FIN_VIG", type="datetime", nullable=true)
     */
    protected $finVigencia;

    /**
     * @ORM\Column(name="DOF", type="datetime", nullable=true)
     */
    protected $dof;

    /**
     * @ORM\Column(name="created_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $updatedAt;

        /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TigieSeccion", inversedBy="secciones")
     * @ORM\JoinColumn(name="ID_SEC", referencedColumnName="ID_SEC")
     * @Serializer\Exclude()
     */
    protected $seccion;

        /**
     * @ORM\OneToMany(targetEntity="App\Entity\TigiePartida", mappedBy="capitulo")
     * @Serializer\Exclude()
     */
    protected $cpartidas;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->cpartidas = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getCPartidas()
    {
        return $this->cpartidas;
    }

    /**
     * @param mixed $partidas
     */
    public function setCPartidas($cpartidas)
    {
        $this->cpartidas = $cpartidas;
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
    public function getCapitulo()
    {
        return $this->capitulo;
    }
    /**
     * @param mixed $capitulo
     */
    public function setCapitulo($capitulo)
    {
        $this->capitulo = $capitulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * @param mixed $seccion
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;
    }

    /**
     * @return mixed
     */
    public function getInicioVigencia()
    {
        return $this->inicioVigencia;
    }

    /**
     * @param mixed $inicioVigencia
     */
    public function setInicioVigencia($inicioVigencia)
    {
        $this->inicioVigencia = $inicioVigencia;
    }

    /**
     * @return mixed
     */
    public function getFinVigencia()
    {
        return $this->finVigencia;
    }

    /**
     * @param mixed $finVigencia
     */
    public function setFinVigencia($finVigencia)
    {
        $this->finVigencia = $finVigencia;
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
    public function getDof()
    {
        return $this->dof;
    }
    public function setDof($dof)
    {
        $this->dof = $dof;
    }
}