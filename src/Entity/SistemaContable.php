<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SistemaContableRepository")
 * @UniqueEntity(fields={"codigo"},message="Ya existe este Código del Sistema Contable o Personal añadido en nuestra Base de Datos.")
 * @UniqueEntity(fields={"personal"},message="Ya existe este Personal añadido en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class SistemaContable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Institucion", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Institución")
     */
    protected $institucion;

    /**
     * @var string
     * @ORM\Column(name="codigo", type="string",  nullable=false, length=50, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $codigo;

    /**
     * @var string $permisos
     * @ORM\Column(name="permisos", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Escritura","Lectura","Control Total"},  message="Debe seleccionar una Opción")
     */
    private $permisos;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\SistemaModulo", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="sistemamodulo_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sistema de Mòdulo")
     */
    protected $sistemamodulo;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\PersonalMedico", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="personal_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal")
     */
    protected $personal;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\User", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete = "CASCADE")
     */
    protected $user;

    public function __toString()
    {
        return $this->getCodigo();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPermisos(): ?string
    {
        return $this->permisos;
    }

    public function setPermisos(string $permisos): self
    {
        $this->permisos = $permisos;

        return $this;
    }

    public function getSistemamodulo(): ?SistemaModulo
    {
        return $this->sistemamodulo;
    }

    public function setSistemamodulo(?SistemaModulo $sistemamodulo): self
    {
        $this->sistemamodulo = $sistemamodulo;

        return $this;
    }

    public function getPersonal(): ?PersonalMedico
    {
        return $this->personal;
    }

    public function setPersonal(?PersonalMedico $personal): self
    {
        $this->personal = $personal;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getMunicipio(): ?Municipio
    {
        return $this->municipio;
    }

    public function setMunicipio(?Municipio $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    public function getInstitucion(): ?Institucion
    {
        return $this->institucion;
    }

    public function setInstitucion(?Institucion $institucion): self
    {
        $this->institucion = $institucion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
