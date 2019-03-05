<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PermisosFracciones
 *
 * @ORM\Table(name="permisos_fracciones")
 * @ORM\Entity(repositoryClass="App\Repository\PermisosFraccionesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PermisosFracciones
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\TigieFraccion", inversedBy="permisos")
     * @ORM\JoinColumn(name="FRACCION", referencedColumnName="FRACCION", nullable=false)
     */
    private $fraccion;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Permisos", inversedBy="permisos")
     * @ORM\JoinColumn(name="ID_PERMISO", referencedColumnName="ID_PERMISO", nullable=false)
     */
    private $idPermiso;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PARCIALIDAD", type="integer", nullable=true, options={"unsigned"=true,"comment"="Parcialidad de la fracción Arancelaria, donde:

0 = Totalmente regulada
1 = Unicamente: 
2 = Excepto: "})
     */
    private $parcialidad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="DESC_PARC_U", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $descParcU;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPCION_GRAL_PARC", type="text", length=65535, nullable=true)
     */
    private $descripcionGralParc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PARTIAL_CODE_COO", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $partialCodeCoo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COO", type="string", nullable=true)
     */
    private $coo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IDENTIFICADOR", type="string", nullable=true)
     */
    private $identificador;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TIPO_IDENTIFICADOR", type="string", nullable=true)
     */
    private $tipoIdentificador;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMPLEMENTO_IDENTIFICADOR", type="string", nullable=true)
     */
    private $complementoIdentificador;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="INI_VIG", type="date", nullable=true)
     */
    private $iniVig;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="FIN_VIG", type="date", nullable=true)
     */
    private $finVig;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DOF", type="date", nullable=true)
     */
    private $dof;

    public function getFraccion(): ?int
    {
        return $this->fraccion;
    }

    public function getIdPermiso(): ?int
    {
        return $this->idPermiso;
    }

    public function getParcialidad(): ?int
    {
        return $this->parcialidad;
    }

    public function setParcialidad(?int $parcialidad): self
    {
        $this->parcialidad = $parcialidad;

        return $this;
    }

    public function getDescParcU(): ?int
    {
        return $this->descParcU;
    }

    public function setDescParcU(?int $descParcU): self
    {
        $this->descParcU = $descParcU;

        return $this;
    }

    public function getDescripcionGralParc(): ?string
    {
        return $this->descripcionGralParc;
    }

    public function setDescripcionGralParc(?string $descripcionGralParc): self
    {
        $this->descripcionGralParc = $descripcionGralParc;

        return $this;
    }

    public function getPartialCodeCoo(): ?int
    {
        return $this->partialCodeCoo;
    }

    public function setPartialCodeCoo(?int $partialCodeCoo): self
    {
        $this->partialCodeCoo = $partialCodeCoo;

        return $this;
    }

    public function getCoo(): ?string
    {
        return $this->coo;
    }

    public function setCoo(?string $coo): self
    {
        $this->coo = $coo;

        return $this;
    }

    public function getIdentificador(): ?string
    {
        return $this->identificador;
    }

    public function setIdentificador(?string $identificador): self
    {
        $this->identificador = $identificador;

        return $this;
    }

    public function getTipoIdentificador(): ?string
    {
        return $this->tipoIdentificador;
    }

    public function setTipoIdentificador(?string $tipoIdentificador): self
    {
        $this->tipoIdentificador = $tipoIdentificador;

        return $this;
    }

    public function getComplementoIdentificador(): ?string
    {
        return $this->complementoIdentificador;
    }

    public function setComplementoIdentificador(?string $complementoIdentificador): self
    {
        $this->complementoIdentificador = $complementoIdentificador;

        return $this;
    }

    public function getIniVig(): ?\DateTimeInterface
    {
        return $this->iniVig;
    }

    public function setIniVig(?\DateTimeInterface $iniVig): self
    {
        $this->iniVig = $iniVig;

        return $this;
    }

    public function getFinVig(): ?\DateTimeInterface
    {
        return $this->finVig;
    }

    public function setFinVig(?\DateTimeInterface $finVig): self
    {
        $this->finVig = $finVig;

        return $this;
    }

    public function getDof(): ?\DateTimeInterface
    {
        return $this->dof;
    }

    public function setDof(?\DateTimeInterface $dof): self
    {
        $this->dof = $dof;

        return $this;
    }


}
