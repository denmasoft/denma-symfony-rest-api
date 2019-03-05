<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Permisos
 *
 * @ORM\Table(name="permisos")
 * @ORM\Entity(repositoryClass="App\Repository\PermisosRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Permisos
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PERMISO", type="integer", nullable=false, options={"unsigned"=true,"comment"="Clave unica del Permiso"})
     * @ORM\Id()
     */
    private $idPermiso;

    /**
     * @var string
     *
     * @ORM\Column(name="DESC_PERMISO", type="string", length=100, nullable=false, options={"comment"="Descripción del Permiso"})
     */
    private $descPermiso = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE_PERMISO", type="string", length=3, nullable=true, options={"comment"="Clave del permiso conforme al Apendice 9 (Anexo 22)"})
     */
    private $cvePermiso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE_PEDIMENTO", type="text", length=65535, nullable=true, options={"comment"="Lista de Claves de pedimento"})
     */
    private $cvePedimento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoOperacion")
     * @ORM\JoinColumn(name="TIPO_OPERACION", referencedColumnName="id")
     */
    protected $tipoOperacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE_RFC", type="string", length=13, nullable=true)
     */
    private $cveRfc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TnCatSecretarias", inversedBy="permisos")
     * @ORM\JoinColumn(name="CVE_SECRETARIA", referencedColumnName="CVE_SECRETARIA")
     * @Serializer\Exclude()
     */
    protected $cveSecretaria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ARTICULO_NO", type="string", length=30, nullable=true)
     */
    private $articuloNo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PARCIALIDAD_IDENTIFICADOR", type="string", length=20, nullable=true, options={"comment"="En caso de aplicar una parcialidad conforme a un identificador"})
     */
    private $parcialidadIdentificador;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESC_PARCIALIDAD_IDENT", type="text", length=65535, nullable=true, options={"comment"="En caso de aplicar una parcialidad conforme a un identificador"})
     */
    private $descParcialidadIdent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="INI_VIG", type="date", nullable=false)
     * @ORM\Id()
     */
    private $iniVig;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FIN_VIG", type="date", nullable=false)
     * @ORM\Id()
     */
    private $finVig;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DOF", type="date", nullable=false)
     */
    private $dof;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PermisosFracciones", mappedBy="idPermiso")
     * @Serializer\Exclude()
     */
    protected $permisos;



    public function __construct()
    {
        $this->permisos = new ArrayCollection();
    }
    public function getId(){
        return $this->id;
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

    public function getIdPermiso(): ?int
    {
        return $this->idPermiso;
    }

    public function getDescPermiso(): ?string
    {
        return $this->descPermiso;
    }

    public function setDescPermiso(string $descPermiso): self
    {
        $this->descPermiso = $descPermiso;

        return $this;
    }

    public function getCvePermiso(): ?string
    {
        return $this->cvePermiso;
    }

    public function setCvePermiso(?string $cvePermiso): self
    {
        $this->cvePermiso = $cvePermiso;

        return $this;
    }

    public function getCvePedimento(): ?string
    {
        return $this->cvePedimento;
    }

    public function setCvePedimento(?string $cvePedimento): self
    {
        $this->cvePedimento = $cvePedimento;

        return $this;
    }

    public function getTipoOperacion(): ?int
    {
        return $this->tipoOperacion;
    }

    public function setTipoOperacion(int $tipoOperacion): self
    {
        $this->tipoOperacion = $tipoOperacion;

        return $this;
    }

    public function getCveRfc(): ?string
    {
        return $this->cveRfc;
    }

    public function setCveRfc(?string $cveRfc): self
    {
        $this->cveRfc = $cveRfc;

        return $this;
    }

    public function getCveSecretaria(): ?int
    {
        return $this->cveSecretaria;
    }

    public function setCveSecretaria(?int $cveSecretaria): self
    {
        $this->cveSecretaria = $cveSecretaria;

        return $this;
    }

    public function getArticuloNo(): ?string
    {
        return $this->articuloNo;
    }

    public function setArticuloNo(?string $articuloNo): self
    {
        $this->articuloNo = $articuloNo;

        return $this;
    }

    public function getParcialidadIdentificador(): ?string
    {
        return $this->parcialidadIdentificador;
    }

    public function setParcialidadIdentificador(?string $parcialidadIdentificador): self
    {
        $this->parcialidadIdentificador = $parcialidadIdentificador;

        return $this;
    }

    public function getDescParcialidadIdent(): ?string
    {
        return $this->descParcialidadIdent;
    }

    public function setDescParcialidadIdent(?string $descParcialidadIdent): self
    {
        $this->descParcialidadIdent = $descParcialidadIdent;

        return $this;
    }

    public function getIniVig(): ?\DateTimeInterface
    {
        return $this->iniVig;
    }

    public function setIniVig(\DateTimeInterface $iniVig): self
    {
        $this->iniVig = $iniVig;

        return $this;
    }

    public function getFinVig(): ?\DateTimeInterface
    {
        return $this->finVig;
    }

    public function setFinVig(\DateTimeInterface $finVig): self
    {
        $this->finVig = $finVig;

        return $this;
    }

    public function getDof(): ?\DateTimeInterface
    {
        return $this->dof;
    }

    public function setDof(\DateTimeInterface $dof): self
    {
        $this->dof = $dof;

        return $this;
    }


}
