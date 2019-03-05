<?php
/**
 * TigieSubpartidas.php
 *
 * TigieSubpartida Entity
 *
 * @category   Entity
 * @author     Taowl
 */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * TigieSubpartidas.
 *
 * @ORM\Table(name="tigie_subpartidas")
 * @ORM\Entity(repositoryClass="App\Repository\TigieSubpartidaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TigieSubpartida
{
    /**
     * @ORM\Column(name="ID_SUBPARTIDA", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id_supartida;

    /**
     * @ORM\Column(name="SUBPARTIDA", type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $numero;

    /**
     * @ORM\Column(name="NIVEL1", type="string", nullable=true)
     */
    protected $nivel1;

    /**
     * @ORM\Column(name="NIVEL2", type="string", nullable=true)
     */
    protected $nivel2;

    /**
     * @ORM\Column(name="DESCRIPCION", type="string")
     */
    protected $descripcion;    

    /**
     * @ORM\Column(name="INI_VIG", type="datetime")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $inicioVigencia;

    /**
     * @ORM\Column(name="FIN_VIG", type="datetime")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $finVigencia;

    /**
     * @ORM\Column(name="created_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TigiePartida", inversedBy="subpartidas")
     * @ORM\JoinColumn(name="ID_PARTIDA", referencedColumnName="ID_PARTIDA")
     * @Serializer\Exclude()
     */
    protected $partida;

            /**
     * @ORM\OneToMany(targetEntity="App\Entity\TigieFraccion", mappedBy="subpartida")
     * @Serializer\Exclude()
     */
    protected $fracciones;

    /**
     * @ORM\Column(name="DOF", type="datetime", nullable=true)
     */
    protected $dof;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->fracciones = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
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
    public function setFrcciones($fracciones)
    {
        $this->fracciones = $fracciones;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $nombre
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

        /**
     * @return mixed
     */
    public function getNivel1()
    {
        return $this->nivel1;
    }

    /**
     * @param mixed $nivel1
     */
    public function setNivel1($nivel1)
    {
        $this->nivel1 = $nivel1;
    }

        /**
     * @return mixed
     */
    public function getNivel2()
    {
        return $this->nivel1;
    }

    /**
     * @param mixed $nivel1
     */
    public function setNivel2($nivel1)
    {
        $this->nivel1 = $nivel1;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getPartida()
    {
        return $this->partida;
    }

    /**
     * @param mixed $partida
     */
    public function setPartida($partida)
    {
        $this->partida = $partida;
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
    public function getIdPartida()
    {
        return $this->id_partida;
    }

    /**
     * @param mixed $id_partida
     */
    public function setIdPartida($id_partida)
    {
        $this->id_partida = $id_partida;
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