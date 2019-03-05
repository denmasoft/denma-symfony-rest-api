<?php
/**
 * TigieSeccion.php
 *
 * TigieSeccion Entity
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
 * TigieSeccion.
 *
 * @ORM\Table(name="tigie_secciones")
 * @ORM\Entity(repositoryClass="App\Repository\TigieSeccionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TigieSeccion
{
    /**
     * @ORM\Column(name="ID_SEC", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="SECCION", type="string")
     */
    protected $numero;

    /**
     * @ORM\Column(name="DESC_SEC", type="string")
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
     * @ORM\OneToMany(targetEntity="App\Entity\TigieCapitulo", mappedBy="seccion")
     * @Serializer\Exclude()
     */
    protected $capitulos;

    /**
     *  constructor.
     */
    public function __construct()
    {
        $this->capitulos = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCapitulos()
    {
        return $this->capitulos;
    }

    /**
     * @param mixed $capitulo
     */
    public function setCapitulos($capitulos)
    {
        $this->capitulos = $capitulos;
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @return mixed
     */

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
    public function getDof()
    {
        return $this->dof;
    }

    /**
     * @param mixed $dof
     */
    public function setDof($dof)
    {
        $this->dof = $dof;
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
}