<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Noms
 *
 * @ORM\Table(name="noms")
 * @ORM\Entity(repositoryClass="App\Repository\NomsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Noms
{

    /**
     * @var string
     *
     * @ORM\Column(name="ID_NOM", type="string", length=3, nullable=false, options={"comment"="Identificador unico de NOM"})
     * @ORM\Id()
     */
    private $idNom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NORMA", type="text", length=65535, nullable=true, options={"comment"="Norma Oficial Mexicana tal como se publica en DOF"})
     */
    private $norma;

    /**
     * @var string
     *
     * @ORM\Column(name="CPD_PED", type="string", length=30, nullable=false, options={"comment"="identificadores aplicables (Apendice 9 y 8)"})
     */
    private $cpdPed = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE_PED_APL", type="string", length=255, nullable=true, options={"comment"="Claves de Pedimento aplicables (Apendice 2)"})
     */
    private $cvePedApl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoOperacion")
     * @ORM\JoinColumn(name="TIPO_OPER", referencedColumnName="id")
     */
    protected $tipoOper;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RFCS", type="string", length=255, nullable=true, options={"comment"="n/a"})
     */
    private $rfcs;

    /**
     * @var string
     *
     * @ORM\Column(name="NORMAS_ALIAS", type="string", length=255, nullable=false, options={"comment"="en los casos que hay mas de una norma aplicable, caso de las que se sutituyen"})
     */
    private $normasAlias = '';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TnCatSecretarias", inversedBy="noms")
     * @ORM\JoinColumn(name="CVE_SECRETARIA", referencedColumnName="CVE_SECRETARIA")
     * @Serializer\Exclude()
     */
    protected $cveSecretaria;


    /**
     * @var string|null
     *
     * @ORM\Column(name="ART_NOM", type="string", length=20, nullable=true, options={"comment"="Art. del Acuerdo de NOM´s"})
     */
    private $artNom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NOM_ETIQUETADO", type="string", length=1, nullable=true, options={"fixed"=true,"comment"="Indicador de si es NOM de Etiquetado: N = NO; Y = Si"})
     */
    private $nomEtiquetado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ALIAS", type="string", length=255, nullable=true, options={"comment"="Lista de Normas  (Alias)"})
     */
    private $alias;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TIPO_IDEN", type="string", nullable=true, options={"comment"="Tipo de Identificadores aplicables"})
     */
    private $tipoIden;

    /**
     * @var string
     *
     * @ORM\Column(name="CVES_IDEN_APL", type="string", length=255, nullable=false)
     */
    private $cvesIdenApl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="COMPL_IDENT", type="string", length=255, nullable=false)
     */
    private $complIdent = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="TIPO_PAIS", type="string", length=10, nullable=true)
     */
    private $tipoPais;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PAISES", type="text", length=65535, nullable=true)
     */
    private $paises;

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
     * @var string|null
     *
     * @ORM\Column(name="PARCIALIDAD", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $parcialidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESC_PARCIALIDAD", type="text", length=65535, nullable=true)
     */
    private $descParcialidad;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="NOM_DOF", type="date", nullable=true)
     */
    private $nomDof;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PermisosFracciones", mappedBy="idNom")
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

    public function getIdNom(): ?string
    {
        return $this->idNom;
    }

    public function getNorma(): ?string
    {
        return $this->norma;
    }

    public function setNorma(?string $norma): self
    {
        $this->norma = $norma;

        return $this;
    }

    public function getCpdPed(): ?string
    {
        return $this->cpdPed;
    }

    public function setCpdPed(string $cpdPed): self
    {
        $this->cpdPed = $cpdPed;

        return $this;
    }

    public function getCvePedApl(): ?string
    {
        return $this->cvePedApl;
    }

    public function setCvePedApl(?string $cvePedApl): self
    {
        $this->cvePedApl = $cvePedApl;

        return $this;
    }

    public function getTipoOper(): ?string
    {
        return $this->tipoOper;
    }

    public function setTipoOper(?string $tipoOper): self
    {
        $this->tipoOper = $tipoOper;

        return $this;
    }

    public function getRfcs(): ?string
    {
        return $this->rfcs;
    }

    public function setRfcs(?string $rfcs): self
    {
        $this->rfcs = $rfcs;

        return $this;
    }

    public function getNormasAlias(): ?string
    {
        return $this->normasAlias;
    }

    public function setNormasAlias(string $normasAlias): self
    {
        $this->normasAlias = $normasAlias;

        return $this;
    }

    public function getCveSecretaria(): ?string
    {
        return $this->cveSecretaria;
    }

    public function setCveSecretaria(?string $cveSecretaria): self
    {
        $this->cveSecretaria = $cveSecretaria;

        return $this;
    }

    public function getArtNom(): ?string
    {
        return $this->artNom;
    }

    public function setArtNom(?string $artNom): self
    {
        $this->artNom = $artNom;

        return $this;
    }

    public function getNomEtiquetado(): ?string
    {
        return $this->nomEtiquetado;
    }

    public function setNomEtiquetado(?string $nomEtiquetado): self
    {
        $this->nomEtiquetado = $nomEtiquetado;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getTipoIden(): ?string
    {
        return $this->tipoIden;
    }

    public function setTipoIden(?string $tipoIden): self
    {
        $this->tipoIden = $tipoIden;

        return $this;
    }

    public function getCvesIdenApl(): ?string
    {
        return $this->cvesIdenApl;
    }

    public function setCvesIdenApl(string $cvesIdenApl): self
    {
        $this->cvesIdenApl = $cvesIdenApl;

        return $this;
    }

    public function getComplIdent(): ?string
    {
        return $this->complIdent;
    }

    public function setComplIdent(string $complIdent): self
    {
        $this->complIdent = $complIdent;

        return $this;
    }

    public function getTipoPais(): ?string
    {
        return $this->tipoPais;
    }

    public function setTipoPais(?string $tipoPais): self
    {
        $this->tipoPais = $tipoPais;

        return $this;
    }

    public function getPaises(): ?string
    {
        return $this->paises;
    }

    public function setPaises(?string $paises): self
    {
        $this->paises = $paises;

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

    public function getParcialidad(): ?string
    {
        return $this->parcialidad;
    }

    public function setParcialidad(?string $parcialidad): self
    {
        $this->parcialidad = $parcialidad;

        return $this;
    }

    public function getDescParcialidad(): ?string
    {
        return $this->descParcialidad;
    }

    public function setDescParcialidad(?string $descParcialidad): self
    {
        $this->descParcialidad = $descParcialidad;

        return $this;
    }

    public function getNomDof(): ?\DateTimeInterface
    {
        return $this->nomDof;
    }

    public function setNomDof(?\DateTimeInterface $nomDof): self
    {
        $this->nomDof = $nomDof;

        return $this;
    }


}
