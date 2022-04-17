<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratoAnclajeRepository")
 * @UniqueEntity(fields={"codigo"},message="Ya existe este Código para este Contrato en nuestra Base de Datos.")
 * @UniqueEntity(fields={"login"},message="Ya existe este Login para este Contrato en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class ContratoAnclaje
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
    private $codigo;

    /**
     * @var \Date $fecha
     * @ORM\Column(name="fecha", type="date",  nullable=false)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity = "Institucion", inversedBy = "contratoanclaje")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Institución")
     */
    protected $institucion;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "contratoanclaje")
     * @ORM\JoinColumn(name="personal1_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Solicitante")
     */
    protected $personal1;

    /**
     * @var string
     * @ORM\Column(name="login", type="string",  nullable=false, length=100, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=4, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $login;

    /**
     * @var string
     * @ORM\Column(name="contrasenna", type="string",  nullable=false, length=100)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=4, max=100, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $contrasenna;

    /**
     * @var integer
     * @ORM\Column(name="accesotelefonico", type="integer",  nullable=true)
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @Assert\Length(min=6, max=10, minMessage="Debe contener al menos {{ limit }} números", maxMessage="Debe contener a lo sumo {{ limit }} números")
     */
    private $accesotelefonico;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "contratoanclaje2")
     * @ORM\JoinColumn(name="personal2_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Director del Centro")
     */
    protected $personal2;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "contratoanclaje")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "contratoanclaje")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    public function getNombreCompleto() {

        return $this->getCodigo() . " para el usuario " . $this->getPersonal1();

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

    public function getContrasenna(): ?string
    {
        return $this->contrasenna;
    }

    public function setContrasenna(string $contrasenna): self
    {
        $this->contrasenna = $contrasenna;

        return $this;
    }

    public function getAccesotelefonico(): ?int
    {
        return $this->accesotelefonico;
    }

    public function setAccesotelefonico(?int $accesotelefonico): self
    {
        $this->accesotelefonico = $accesotelefonico;

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