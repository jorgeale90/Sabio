<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratoCorreoRepository")
 * @UniqueEntity(fields={"codigo"},message="Ya existe este Código de este Contrato en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class ContratoCorreo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @ORM\Column(name="codigo", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    protected $codigo;

    /**
     * @var \Date $fecha
     * @ORM\Column(name="fecha", type="date",  nullable=false)
     */
    protected $fecha;

    /**
     * @ORM\ManyToOne(targetEntity = "Institucion", inversedBy = "contratocorreo")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Institución")
     */
    protected $institucion;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "contratocorreo1")
     * @ORM\JoinColumn(name="personal1_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Solicitante")
     */
    protected $personal1;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "contratocorreo2")
     * @ORM\JoinColumn(name="personal2_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Director del Policlínico Docente")
     */
    protected $personal2;

    /**
     * @var string
     * @ORM\Column(name="login", type="string",  nullable=false, length=100)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=4, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    protected $login;

    /**
     * @var string $accesotelefonico
     * @ORM\Column(name="accesotelefonico", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Si","No"},  message="Debe seleccionar una Opción")
     */
    protected $accesotelefonico;

    /**
     * @var string $salidainternacional
     * @ORM\Column(name="salidainternacional", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Si","No"},  message="Debe seleccionar una Opción")
     */
    protected $salidainternacional;

    /**
     * @var string $internet
     * @ORM\Column(name="internet", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Si","No"},  message="Debe seleccionar una Opción")
     */
    protected $internet;

    /**
     * @var string $personal
     * @ORM\Column(name="personal", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Si","No"},  message="Debe seleccionar una Opción")
     */
    protected $personal;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "contratocorreo")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "contratocorreo")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    public function getNombreCompleto() {

        return $this->getCodigo() . " para el solicitante " . $this->getPersonal2();

    }

    public function __toString() {

        return $this->getNombreCompleto();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getAccesotelefonico(): ?string
    {
        return $this->accesotelefonico;
    }

    public function setAccesotelefonico(string $accesotelefonico): self
    {
        $this->accesotelefonico = $accesotelefonico;

        return $this;
    }

    public function getSalidainternacional(): ?string
    {
        return $this->salidainternacional;
    }

    public function setSalidainternacional(string $salidainternacional): self
    {
        $this->salidainternacional = $salidainternacional;

        return $this;
    }

    public function getInternet(): ?string
    {
        return $this->internet;
    }

    public function setInternet(string $internet): self
    {
        $this->internet = $internet;

        return $this;
    }

    public function getPersonal(): ?string
    {
        return $this->personal;
    }

    public function setPersonal(string $personal): self
    {
        $this->personal = $personal;

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
}
