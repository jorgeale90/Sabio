<?php

namespace App\Entity;

use App\Repository\EntradaSalidaEquipoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=EntradaSalidaEquipoRepository::class)
 * @UniqueEntity(fields={"numero"},message="Ya existe este Número en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class EntradaSalidaEquipo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @ORM\Column(name="numero", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $numero;

    /**
     * @ORM\Column(name="fechaentrada", type="date",  nullable=true)
     */
    private $fechaentrada;

    /**
     * @var \Date $fechasalida
     * @ORM\Column(name="fechasalida", type="date",  nullable=false)
     */
    private $fechasalida;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $datoequipo;

    /**
     * @var string
     * @Assert\Regex(pattern="/\d/", match=false, message="Debe contener solo letras")
     * @ORM\Column(name="procedencia", type="string", nullable=false, length=80)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $procedencia;

    /**
     * @var string
     * @Assert\Regex(pattern="/\d/", match=false, message="Debe contener solo letras")
     * @ORM\Column(name="destino", type="string", nullable=false, length=80)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $destino;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $motivo;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\PersonalMedico", inversedBy = "entradasalida")
     * @ORM\JoinColumn(name="personal_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal")
     */
    protected $personal;

    public function __toString()
    {
        return $this->getNumero();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getFechaentrada(): ?\DateTimeInterface
    {
        return $this->fechaentrada;
    }

    public function setFechaentrada(\DateTimeInterface $fechaentrada = null): self
    {
        $this->fechaentrada = $fechaentrada;

        return $this;
    }

    public function getFechasalida(): ?\DateTimeInterface
    {
        return $this->fechasalida;
    }

    public function setFechasalida(?\DateTimeInterface $fechasalida): self
    {
        $this->fechasalida = $fechasalida;

        return $this;
    }

    public function getDatoequipo(): ?string
    {
        return $this->datoequipo;
    }

    public function setDatoequipo(?string $datoequipo): self
    {
        $this->datoequipo = $datoequipo;

        return $this;
    }

    public function getProcedencia(): ?string
    {
        return $this->procedencia;
    }

    public function setProcedencia(string $procedencia): self
    {
        $this->procedencia = $procedencia;

        return $this;
    }

    public function getDestino(): ?string
    {
        return $this->destino;
    }

    public function setDestino(string $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(?string $motivo): self
    {
        $this->motivo = $motivo;

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
}
