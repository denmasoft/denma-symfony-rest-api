<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NomsFracciones
 *
 * @ORM\Table(name="noms_fracciones")
 * @ORM\Entity(repositoryClass="App\Repository\NomsFraccionesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class NomsFracciones
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\TigieFraccion", inversedBy="noms")
     * @ORM\JoinColumn(name="FRACCION", referencedColumnName="FRACCION", nullable=false)
     */
    private $fraccion = '';

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Noms", inversedBy="noms")
     * @ORM\JoinColumn(name="ID_NOM", referencedColumnName="ID_NOM", nullable=false)
     */
    private $idNom = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE_PARCIALIDAD", type="string", nullable=true, options={"fixed"=true})
     */
    private $cveParcialidad;

    /**
     * @var string
     *
     * @ORM\Column(name="CVE_UNI_EXC", type="string", nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $cveUniExc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESC_PARCIALIDAD", type="text", length=65535, nullable=true)
     */
    private $descParcialidad;

    /**
     * @var string
     *
     * @ORM\Column(name="TIPO_PAIS", type="string", nullable=false, options={"fixed"=true})
     */
    private $tipoPais = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="PAISES", type="text", length=65535, nullable=true)
     */
    private $paises;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TIPO_IDEN", type="string", nullable=true)
     */
    private $tipoIden;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVES_IDEN", type="string", length=255, nullable=true)
     */
    private $cvesIden;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMPL_IDENT", type="string", length=255, nullable=true)
     */
    private $complIdent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="INI_VIG", type="date", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $iniVig;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FIN_VIG", type="date", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $finVig;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DOF", type="date", nullable=true)
     */
    private $dof;

    public function getFraccion(): ?string
    {
        return $this->fraccion;
    }

    public function getIdNom(): ?string
    {
        return $this->idNom;
    }

    public function getCveParcialidad(): ?string
    {
        return $this->cveParcialidad;
    }

    public function setCveParcialidad(?string $cveParcialidad): self
    {
        $this->cveParcialidad = $cveParcialidad;

        return $this;
    }

    public function getCveUniExc(): ?string
    {
        return $this->cveUniExc;
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

    public function getTipoPais(): ?string
    {
        return $this->tipoPais;
    }

    public function setTipoPais(string $tipoPais): self
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

    public function getTipoIden(): ?string
    {
        return $this->tipoIden;
    }

    public function setTipoIden(?string $tipoIden): self
    {
        $this->tipoIden = $tipoIden;

        return $this;
    }

    public function getCvesIden(): ?string
    {
        return $this->cvesIden;
    }

    public function setCvesIden(?string $cvesIden): self
    {
        $this->cvesIden = $cvesIden;

        return $this;
    }

    public function getComplIdent(): ?string
    {
        return $this->complIdent;
    }

    public function setComplIdent(?string $complIdent): self
    {
        $this->complIdent = $complIdent;

        return $this;
    }

    public function getIniVig(): ?\DateTimeInterface
    {
        return $this->iniVig;
    }

    public function getFinVig(): ?\DateTimeInterface
    {
        return $this->finVig;
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
