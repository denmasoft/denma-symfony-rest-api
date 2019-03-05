<?php
/**
 * CargaTarifa.php
 *
 * CargaTarifa Entity
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
 * CargaTarifa.
 *
 * @ORM\Table(name="carga_tarifa")
 * @ORM\Entity(repositoryClass="App\Repository\CargaTarifaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CargaTarifa
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="CODIGO", type="string", nullable=true)
     */
    protected $codigo;

     /**
     * @ORM\Column(name="NIVEL", type="string", nullable=true)
     */
    protected $nivel;

    /**
     * @ORM\Column(name="DESCRIPCION1", type="string")
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="UM1", type="string", nullable=true)
     */
    protected $unidad;

    /**
     * @ORM\Column(name="ARAN_IMP1", type="string", nullable=true)
     */
    protected $imp;

    /**
     * @ORM\Column(name="ARAN_EXP1", type="string", nullable=true)
     */
    protected $exp;

    /**
     * @ORM\Column(name="FRACCION_NO", type="string", nullable=true)
     */
    protected $fraccion;

    /**
     * @ORM\Column(name="SUBPARTIDA1", type="string", nullable=true)
     */
    protected $subpartida;

        /**
     * @ORM\Column(name="ID_LARGO1", type="string", nullable=true)
     */
    protected $id_largo;

        /**
     * @ORM\Column(name="INI_VIG1", type="datetime", nullable=true)
     */
    protected $inicioVigencia;

    /**
     * @ORM\Column(name="FIN_VIG1", type="datetime", nullable=true)
     */
    protected $finVigencia;

    /**
     * @ORM\Column(name="DOF1", type="datetime", nullable=true)
     */
    protected $dof;

            /**
     * @ORM\Column(name="AMX", type="string", nullable=true)
     */
    protected $amx;

        /**
     * @ORM\Column(name="created_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $updatedAt;

    /**
     *  constructor.
     */
    public function __construct()
    {
        
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getUnidad()
    {
        return $this->unidad;
    }

    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;
    }
    public function getImp()
    {
        return $this->imp;
    }

    public function setImp($imp)
    {
        $this->imp = $imp;
    }
    public function getExp()
    {
        return $this->exp;
    }

    public function setExp($exp)
    {
        $this->exp = $exp;
    }

    public function getFraccion()
    {
        return $this->fraccion;
    }

    public function setFraccion($fraccion)
    {
        $this->fraccion = $fraccion;
    }

    public function getSubpartida()
    {
        return $this->subpartida;
    }

    public function setSubpartida($subpartida)
    {
        $this->subpartida = $subpartida;
    }

    public function getIdLargo()
    {
        return $this->id_largo;
    }

    public function setIdLargo($id_largo)
    {
        $this->id_largo = $id_largo;
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
    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }
    /**
     * @return mixed
     */
    public function getAmx()
    {
        return $this->amx;
    }

    /**
     * @param mixed $amx
     */
    public function setAmx($amx)
    {
        $this->amx = $amx;
    }
}