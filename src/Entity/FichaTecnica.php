<?php

namespace App\Entity;

use App\Repository\FichaTecnicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=FichaTecnicaRepository::class)
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class FichaTecnica
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "fichatecnica")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "fichatecnica")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Municipio")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Institucion", inversedBy = "fichatecnica")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Unidad")
     */
    protected $institucion;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\PersonalMedico", inversedBy = "fichatecnica1")
     * @ORM\JoinColumn(name="personal1_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Responsable")
     */
    protected $personal1;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\PersonalMedico", inversedBy = "fichatecnica2")
     * @ORM\JoinColumn(name="personal2_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar el Creador")
     */
    protected $personal2;

    /**
     * @var string
     * @ORM\Column(name="tipoequipo", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $tipoequipo;

    /**
     * @var string
     * @ORM\Column(name="noinventario", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[0-9 ]*$/",
     *     message="Debe de contener solo números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $noinventario;

    /**
     * @var string
     * @ORM\Column(name="proyecto", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $proyecto;

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
     * @var string
     * @ORM\Column(name="modeloboard", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $modeloboard;

    /**
     * @var string
     * @ORM\Column(name="socketboard", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $socketboard;

    /**
     * @var string
     * @ORM\Column(name="serieboard", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $serieboard;

    /**
     * @var string
     * @ORM\Column(name="tipocpu", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $tipocpu;

    /**
     * @var string
     * @ORM\Column(name="marcacpu", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $marcacpu;

    /**
     * @var string
     * @ORM\Column(name="velocidadcpu", type="string",  nullable=true, length=50)
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $velicidadcpu;

    /**
     * @var string
     * @ORM\Column(name="seriecpu", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $seriecpu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hardware", mappedBy="fichatecnica", cascade={"all"}, orphanRemoval=true)
     */
    private $hardware;

    public function __construct()
    {
        $this->ram = new ArrayCollection();
        $this->discoduro = new ArrayCollection();
        $this->hardware = new ArrayCollection();
    }

    public function getNombreCompleto() {

        return $this->getNoinventario() . " para el equipo " . $this->getTipoequipo();

    }

    public function __toString() {

        return $this->getNombreCompleto();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoequipo(): ?string
    {
        return $this->tipoequipo;
    }

    public function setTipoequipo(string $tipoequipo): self
    {
        $this->tipoequipo = $tipoequipo;

        return $this;
    }

    public function getNoinventario(): ?string
    {
        return $this->noinventario;
    }

    public function setNoinventario(string $noinventario): self
    {
        $this->noinventario = $noinventario;

        return $this;
    }

    public function getProyecto(): ?string
    {
        return $this->proyecto;
    }

    public function setProyecto(string $proyecto): self
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

    public function getModeloboard(): ?string
    {
        return $this->modeloboard;
    }

    public function setModeloboard(string $modeloboard): self
    {
        $this->modeloboard = $modeloboard;

        return $this;
    }

    public function getSocketboard(): ?string
    {
        return $this->socketboard;
    }

    public function setSocketboard(string $socketboard): self
    {
        $this->socketboard = $socketboard;

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

    public function getSerieboard(): ?string
    {
        return $this->serieboard;
    }

    public function setSerieboard(string $serieboard): self
    {
        $this->serieboard = $serieboard;

        return $this;
    }

    public function getTipocpu(): ?string
    {
        return $this->tipocpu;
    }

    public function setTipocpu(string $tipocpu): self
    {
        $this->tipocpu = $tipocpu;

        return $this;
    }

    public function getMarcacpu(): ?string
    {
        return $this->marcacpu;
    }

    public function setMarcacpu(string $marcacpu): self
    {
        $this->marcacpu = $marcacpu;

        return $this;
    }

    public function getVelicidadcpu(): ?string
    {
        return $this->velicidadcpu;
    }

    public function setVelicidadcpu(?string $velicidadcpu): self
    {
        $this->velicidadcpu = $velicidadcpu;

        return $this;
    }

    public function getSeriecpu(): ?string
    {
        return $this->seriecpu;
    }

    public function setSeriecpu(string $seriecpu): self
    {
        $this->seriecpu = $seriecpu;

        return $this;
    }

    /**
     * @return Collection|Hardware[]
     */
    public function getHardware(): Collection
    {
        return $this->hardware;
    }

    public function addHardware(Hardware $hardware): self
    {
        if (!$this->hardware->contains($hardware)) {
            $this->hardware[] = $hardware;
            $hardware->setFichatecnica($this);
        }

        return $this;
    }

    public function removeHardware(Hardware $hardware): self
    {
        if ($this->hardware->removeElement($hardware)) {
            // set the owning side to null (unless already changed)
            if ($hardware->getFichatecnica() === $this) {
                $hardware->setFichatecnica(null);
            }
        }

        return $this;
    }
}
