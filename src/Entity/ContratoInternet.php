<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratoInternetRepository")
 * @UniqueEntity(fields={"folio","login"},message="Ya existe este Folio de este Contrato en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class ContratoInternet
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
     * @ORM\Column(name="folio", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $folio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "contratointernet")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "contratointernet")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "Institucion", inversedBy = "contratointernet")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Institución")
     */
    protected $institucion;

    /**
     * @var \Date $fecha
     * @ORM\Column(name="fecha", type="date",  nullable=false)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "contratointernet1")
     * @ORM\JoinColumn(name="personal1_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Solicitante")
     */
    protected $personal1;

    /**
     * @var string
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @ORM\Column(name="telefono", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $telefono;

    /**
     * @ORM\ManyToOne(targetEntity = "PersonalMedico", inversedBy = "contratointernet2")
     * @ORM\JoinColumn(name="personal2_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Jefe que Autoriza")
     */
    protected $personal2;

    /**
     * @var string $serviciocorreo
     * @ORM\Column(name="serviciocorreo", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Si","No"},  message="Debe seleccionar una Opción")
     */
    private $serviciocorreo;

    /**
     * @var string $accesoredes
     * @ORM\Column(name="accesoredes", type="string", nullable=false, length=30)
     * @Assert\Choice(choices={"Si","No"},  message="Debe seleccionar una Opción")
     */
    private $accesoredes;

    /**
     * @var string
     * @ORM\Column(name="login", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=4, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $login;

    /**
     * @var string
     * @ORM\Column(name="pass", type="string",  nullable=false, length=80)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=6, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $pass;

    public function getNombreCompleto() {

        return $this->getFolio() . " para el usuario " . $this->getPersonal1();

    }

    public function __toString() {

        return $this->getNombreCompleto();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFolio(): ?string
    {
        return $this->folio;
    }

    public function setFolio(string $folio): self
    {
        $this->folio = $folio;

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getServiciocorreo(): ?string
    {
        return $this->serviciocorreo;
    }

    public function setServiciocorreo(string $serviciocorreo): self
    {
        $this->serviciocorreo = $serviciocorreo;

        return $this;
    }

    public function getAccesoredes(): ?string
    {
        return $this->accesoredes;
    }

    public function setAccesoredes(string $accesoredes): self
    {
        $this->accesoredes = $accesoredes;

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

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;

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
