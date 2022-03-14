<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SistemaContableRepository")
 * @UniqueEntity(fields={"codigo"},message="Ya existe este Código del Sistema Contable en nuestra Base de Datos.")
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
     * @var string
     * @ORM\Column(name="codigo", type="string",  nullable=false, length=50, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $codigo;

    /**
     * @var string $permisos
     * @ORM\Column(name="permisos", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"ESCRITURA","LECTURA","CONTROL TOTAL"},  message="Debe seleccionar una Opción")
     */
    private $permisos;

    /**
     * @ORM\ManyToOne(targetEntity = "SistemaModulo", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="sistemamodulo_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Sistema de Mòdulo")
     */
    protected $sistemamodulo;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "sistemacontable")
     * @ORM\JoinColumn(name="personal_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal")
     */
    protected $personal;

    public function __toString() {

        return $this->getSistemamodulo();

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
}
