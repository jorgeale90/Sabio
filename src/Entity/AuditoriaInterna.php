<?php

namespace App\Entity;

use App\Repository\AuditoriaInternaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=AuditoriaInternaRepository::class)
 * @UniqueEntity(fields={"noidentificacion"},message="Ya existe este No. de Identificación en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class AuditoriaInterna
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "auditoria")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia.")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "auditoria")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio.")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Institucion", inversedBy = "auditoria")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Institución.")
     */
    protected $institucion;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\FichaTecnica", inversedBy = "auditoria")
     * @ORM\JoinColumn(name="fichatecnica_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Ficha Técnica.")
     */
    protected $fichatecnica;

    /**
     * @var string
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @ORM\Column(name="noidentificacion", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $noidentificacion;

    /**
     * @var string
     * @ORM\Column(name="accionrealizada", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $accionrealizada;

    /**
     * @var \Date $fecha
     * @ORM\Column(name="fecha", type="date",  nullable=false)
     */
    protected $fecha;

    /**
     * @var string
     * @ORM\Column(name="area", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $area;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PersonalMedico")
     * @ORM\JoinTable(name="personalmedico_auditoriainterna",
     *           joinColumns={@ORM\JoinColumn(name="personalmedico_id", referencedColumnName="id")},
     *           inverseJoinColumns={@ORM\JoinColumn(name="auditoriainterna_id",referencedColumnName="id")})
     * @Assert\Count(min=1, max=15, minMessage="Debe seleccionar al menos {{ limit }} Organización", maxMessage="Debe seleccionar a lo sumo {{ limit }} Organizaciones")*
     */
    protected $personalmedico;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $situaciones;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\User", inversedBy = "auditoria")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete = "CASCADE")
     */
    protected $user;

    public function __construct()
    {
        $this->personalmedico = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNoidentificacion();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoidentificacion(): ?string
    {
        return $this->noidentificacion;
    }

    public function setNoidentificacion(string $noidentificacion): self
    {
        $this->noidentificacion = $noidentificacion;

        return $this;
    }

    public function getAccionrealizada(): ?string
    {
        return $this->accionrealizada;
    }

    public function setAccionrealizada(string $accionrealizada): self
    {
        $this->accionrealizada = $accionrealizada;

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

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getSituaciones(): ?string
    {
        return $this->situaciones;
    }

    public function setSituaciones(?string $situaciones): self
    {
        $this->situaciones = $situaciones;

        return $this;
    }

    /**
     * @return Collection<int, PersonalMedico>
     */
    public function getPersonalmedico(): Collection
    {
        return $this->personalmedico;
    }

    public function addPersonalmedico(PersonalMedico $personalmedico): self
    {
        if (!$this->personalmedico->contains($personalmedico)) {
            $this->personalmedico[] = $personalmedico;
        }

        return $this;
    }

    public function removePersonalmedico(PersonalMedico $personalmedico): self
    {
        $this->personalmedico->removeElement($personalmedico);

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

    public function getFichatecnica(): ?FichaTecnica
    {
        return $this->fichatecnica;
    }

    public function setFichatecnica(?FichaTecnica $fichatecnica): self
    {
        $this->fichatecnica = $fichatecnica;

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
