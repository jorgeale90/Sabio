<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedioTecnologicoRepository")
 * @UniqueEntity(fields={"mac"},message="Ya existe este Medio Tecnologico en nuestra Base de Datos.")
 * @UniqueEntity(fields={"serie"},message="Ya existe este Medio Tecnologico en nuestra Base de Datos.")
 */
class MedioTecnologico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="mac", type="string",  nullable=false, length=50, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $mac;

    /**
     * @var string
     * @ORM\Column(name="serie", type="string",  nullable=false, length=50, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $serie;

    /**
     * @var \Date $fecha
     * @ORM\Column(name="fecha", type="date",  nullable=false)
     */
    private $fecha;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=500, minMessage="Debe contener al menos {{ limit }} letra", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity = "TipoMedio", inversedBy = "mediotecnologico")
     * @ORM\JoinColumn(name="tipomedio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Medio")
     */
    protected $tipomedio;

    /**
     * @ORM\ManyToOne(targetEntity = "Marca", inversedBy = "mediotecnologico")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Marca")
     */
    protected $marca;

    /**
     * @ORM\ManyToOne(targetEntity = "Modelo", inversedBy = "mediotecnologico")
     * @ORM\JoinColumn(name="modelo_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Modelo")
     */
    protected $modelo;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "mediotecnologico1")
     * @ORM\JoinColumn(name="personal1_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal")
     */
    protected $personal1;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "mediotecnologico2")
     * @ORM\JoinColumn(name="personal2_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal")
     */
    protected $personal2;

    public function getNombreCompleto() {

        return $this->getTipomedio() . " de marca " . $this->getMarca(). " del propietario " . $this->getPersonal2();

    }

    public function __toString() {

        return $this->getNombreCompleto();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMac(): ?string
    {
        return $this->mac;
    }

    public function setMac(string $mac): self
    {
        $this->mac = $mac;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTipomedio(): ?TipoMedio
    {
        return $this->tipomedio;
    }

    public function setTipomedio(?TipoMedio $tipomedio): self
    {
        $this->tipomedio = $tipomedio;

        return $this;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getModelo(): ?Modelo
    {
        return $this->modelo;
    }

    public function setModelo(?Modelo $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getPersonal1(): ?PersonalMedico
    {
        return $this->personal1;
    }

    public function setPersonal1(?PersonalMedico $personal1): self
    {
        $this->personal1 = $personal1;

        return $this;
    }

    public function getPersonal2(): ?PersonalMedico
    {
        return $this->personal2;
    }

    public function setPersonal2(?PersonalMedico $personal2): self
    {
        $this->personal2 = $personal2;

        return $this;
    }
}