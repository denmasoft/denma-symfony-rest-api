<?php
/**
 * TigiePartida.php
 *
 * TigiePartida Entity
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
 * TigiePartida.
 *
 * @ORM\Table(name="tigie_partidas")
 * @ORM\Entity(repositoryClass="App\Repository\TigiePartidaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TigiePartida
{
    /**
     * @ORM\Column(name="ID_PARTIDA", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id_partida;

    /**
     * @ORM\Column(name="PARTIDA", type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $numero;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\TigieCapitulo", inversedBy="cpartidas")
     * @ORM\JoinColumn(name="ID_CAP", referencedColumnName="ID_CAP")
     * @Serializer\Exclude()
     */
    protected $capitulo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TigieSubpartida", mappedBy="partida")
     * @Serializer\Exclude()
     */
    protected $subpartidas;

    /**
     * @ORM\Column(name="DOF", type="datetime", nullable=true)
     */
    protected $dof;

    /**
     *  constructor.
     */
    public function __construct()
    {
        $this->subpartidas = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdPartida()
    {
        return $this->id_partida;
    }
    public function setIdPartida($id_partida)
    {
        $this->id_partida = $id_partida;
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
    public function getSubpartidas()
    {
        return $this->subpartidas;
    }

    /**
     * @param mixed $subpartidas
     */
    public function setSubpartidas($subpartidas)
    {
        $this->subpartidas = $subpartidas;
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
        return $this->finvigencia;
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