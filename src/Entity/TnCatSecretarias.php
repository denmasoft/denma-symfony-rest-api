<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * TnCatSecretarias
 *
 * @ORM\Table(name="tn_cat_secretarias")
 * @ORM\Entity(repositoryClass="App\Repository\TnCatSecretariasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TnCatSecretarias
{
    /**
     * @var int
     *
     * @ORM\Column(name="CVE_SECRETARIA", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cveSecretaria = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="NOMBRE_SECRETARIA", type="string", length=120, nullable=false)
     */
    private $nombreSecretaria = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESC_PERMISO", type="text", length=65535, nullable=true)
     */
    private $descPermiso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE_PERMISO", type="string", length=2, nullable=true)
     */
    private $cvePermiso;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Noms", mappedBy="cveSecretaria")
     * @Serializer\Exclude()
     */
    protected $noms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Permisos", mappedBy="cveSecretaria")
     * @Serializer\Exclude()
     */
    protected $permisos;

    public function __construct()
    {
        $this->noms = new ArrayCollection();
        $this->permisos = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * @param mixed permisos
     */
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }

    public function getCveSecretaria(): ?int
    {
        return $this->cveSecretaria;
    }

    public function getNombreSecretaria(): ?string
    {
        return $this->nombreSecretaria;
    }

    public function setNombreSecretaria(string $nombreSecretaria): self
    {
        $this->nombreSecretaria = $nombreSecretaria;

        return $this;
    }

    public function getDescPermiso(): ?string
    {
        return $this->descPermiso;
    }

    public function setDescPermiso(?string $descPermiso): self
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


}
