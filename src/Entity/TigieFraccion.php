<?php
/**
 * TigieFraccion.php
 *
 * TigieFraccion Entity
 *
 * @category   Entity
 * @author     Taowl
 */


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Fracción arancelaria.
 *
 * @ORM\Table(name="tigie_fracciones")
 * @ORM\Entity(repositoryClass="App\Repository\TigieFraccionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TigieFraccion
{

    /**
     * @ORM\Column(name="FRACCION", type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $numero;

    /**
     * @ORM\Column(name="DESCRIPCION", type="string")
     */
    protected $descripcion;

    /**
     * @ORM\Column(name="UM", type="string", nullable=true)
     */
    protected $um;

    /**
     * @ORM\Column(name="ADV_IMP", type="string", length=90, nullable=true)
     */
    protected $adv_imp;

    /**
     * @ORM\Column(name="SPC_IMP", type="string", nullable=true)
     */
    protected $spc_imp;

    /**
     * @ORM\Column(name="ADV_EXP", type="string", nullable=true)
     */
    protected $adv_exp;

    /**
     * @ORM\Column(name="SPC_EXP", type="string", nullable=true)
     */
    protected $spc_exp;

    /**
     * @ORM\Column(name="INI_VIG", type="date")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE") 
     */
    protected $inicioVigencia;

    /**
     * @ORM\Column(name="FIN_VIG", type="date")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $finVigencia;


    /**
     * @ORM\Column(name="DOF", type="datetime",nullable=true)
     */
    protected $dof;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TigieSubpartida")
     * @ORM\JoinColumn(name="ID_SUBPARTIDA", referencedColumnName="ID_SUBPARTIDA")
     * @Serializer\Exclude()
     */
    protected $subpartida;

    /**
     * @ORM\Column(name="ESTATUS", type="string", length=3, nullable=true)
     */
    protected $estado;

    /**
     * @ORM\Column(name="TIPO_ARAN", type="string", length=3, nullable=true)
     */
    protected $tipo_aran;

    /**
     * @ORM\Column(name="created_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     * @Serializer\Exclude()
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     * @Serializer\Exclude()
     */
    protected $updatedAt;

        /**
     * @ORM\Column(name="prohibida", type="boolean", nullable=true)
     */
    protected $prohibida;

    /**
     * @ORM\Column(name="exenta", type="boolean", nullable=true)
     */
    protected $exenta;

        /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="fracciones")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true)
     * @Serializer\Exclude()
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unidad")
     * @ORM\JoinColumn(name="unidad_id", referencedColumnName="id")
     */
    protected $unidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoOperacion")
     * @ORM\JoinColumn(name="tipo_operacion_id", referencedColumnName="id")
     */
    protected $tipoOperacion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PermisosFracciones", mappedBy="fraccion")
     * @Serializer\Exclude()
     */
    protected $permisos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NomsFracciones", mappedBy="fraccion")
     * @Serializer\Exclude()
     */
    protected $noms;


    /**
     * Fraccion constructor.
     */
    public function __construct()
    {
        $this->activo = true;
        $this->permisos = new ArrayCollection();
        $this->noms = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * @param mixed $permisos
     */
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }

    /**
     * @return mixed
     */
    public function getNoms()
    {
        return $this->noms;
    }

    /**
     * @param mixed $noms
     */
    public function setNoms($noms)
    {
        $this->noms = $noms;
    }

    public function getId(){
        return $this->id;
    }
    public function getNumero(){
        return $this->numero;
    }

    public function setNumero($numero){
        $this->numero = $numero;
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
    public function getUm()
    {
        return $this->um;
    }

    /**
     * @param mixed $um
     */
    public function setUm($um)
    {
        $this->um = $um;
    }

    /**
     * @return mixed
     */
    public function getImpuestoAdValorem()
    {
        return $this->adv_imp;
    }
    /**
     * @param mixed $adv_imp
     */
    public function setImpuestoAdValorem($adv_imp)
    {
        $this->adv_imp = $adv_imp;
    }
    /**
     * @return mixed
     */
    public function getImpuestoEspecifico()
    {
        return $this->spc_imp;
    }
    /**
     * @param mixed $spc_imp
     */
    public function setImpuestoEspecifico($spc_imp)
    {
        $this->spc_imp = $spc_imp;
    }
    /**
     * @return mixed
     */
    public function getAdvExp()
    {
        return $this->adv_exp;
    }
    /**
     * @param mixed $adv_exp
     */
    public function setAdvExp($adv_exp)
    {
        $this->adv_exp = $adv_exp;
    }
    /**
     * @return mixed
     */
    public function getSpcExp()
    {
        return $this->spc_exp;
    }
    /**
     * @param mixed $spc_exp
     */
    public function setSpcExp($spc_exp)
    {
        $this->spc_exp = $spc_exp;
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
     * @return mixed
     */
    public function getSubpartida()
    {
        return $this->subpartida;
    }

    /**
     * @param mixed $subpartida
     */
    public function setSubpartida($subpartida)
    {
        $this->subpartida = $subpartida;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function getTipoAran()
    {
        return $this->tipo_aran;
    }
    public function setTipoAran($tipo_aran)
    {
        $this->tipo_aran = $tipo_aran;
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
    public function getProhibida()
    {
        return $this->prohibida;
    }

    /**
     * @param mixed $prohibida
     */
    public function setProhibida($prohibida)
    {
        $this->prohibida = $prohibida;
    }

    /**
     * @return mixed
     */
    public function getExenta()
    {
        return $this->exenta;
    }

    /**
     * @param mixed $exenta
     */
    public function setExenta($exenta)
    {
        $this->exenta = $exenta;
    }
    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return mixed
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * @param mixed $unidad
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;
    }

    /**
     * @return mixed
     */
    public function getTipoOperacion()
    {
        return $this->tipoOperacion;
    }

    /**
     * @param mixed $tipoOperacion
     */
    public function setTipoOperacion($tipoOperacion)
    {
        $this->tipoOperacion = $tipoOperacion;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}