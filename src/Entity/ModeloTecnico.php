<?php

namespace App\Entity;

use App\Repository\ModeloTecnicoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=ModeloTecnicoRepository::class)
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class ModeloTecnico
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Institucion", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Intitución.")
     */
    protected $institucion;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\PersonalMedico", inversedBy = "modelotecnico1")
     * @ORM\JoinColumn(name="personal1_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal.")
     */
    protected $personal1;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\PersonalMedico", inversedBy = "modelotecnico2")
     * @ORM\JoinColumn(name="personal2_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Personal.")
     */
    protected $personal2;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\FichaTecnica", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="fichatecnica_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Ficha Técnica.")
     */
    protected $fichatecnica;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\TipoMedio", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="tipomedio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Tipo de Medio.")
     */
    protected $tipomedio;

    /**
     * @var string
     * @ORM\Column(name="noinventario", type="string", nullable=true, length=50)
     */
    private $noinventario;

    /**
     * @var string
     * @ORM\Column(name="proyecto", type="string", nullable=true, length=50)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     */
    private $proyecto;

    /**
     * @var string
     * @ORM\Column(name="area", type="string", nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Marca", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Marca")
     */
    protected $marca;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Modelo", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="modelo_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Modelo")
     */
    protected $modelo;

    /**
     * @var string
     * @ORM\Column(name="serie", type="string", nullable=true, length=50)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\User", inversedBy = "modelotecnico")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete = "CASCADE")
     */
    protected $user;

    public function __toString()
    {
        return $this->getNoinventario();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoinventario(): ?string
    {
        return $this->noinventario;
    }

    public function setNoinventario(?string $noinventario): self
    {
        $this->noinventario = $noinventario;

        return $this;
    }

    public function getProyecto(): ?string
    {
        return $this->proyecto;
    }

    public function setProyecto(?string $proyecto): self
    {
        $this->proyecto = $proyecto;

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

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(?string $serie): self
    {
        $this->serie = $serie;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getFichatecnica(): ?FichaTecnica
    {
        return $this->fichatecnica;
    }

    public function setFichatecnica(?FichaTecnica $fichatecnica): self
    {
        $this->fichatecnica = $fichatecnica;

        return $this;
    }
}
