<?php

namespace App\Entity;

use App\Repository\DireccionamientoIPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=DireccionamientoIPRepository::class)
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 * @Vich\Uploadable
 */
class DireccionamientoIP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="bloque", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $bloque;

    /**
     * @var string
     * @ORM\Column(name="direccionenlace", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $direccionenlace;

    /**
     * @var string
     * @ORM\Column(name="prefijo", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $prefijo;

    /**
     * @var string
     * @ORM\Column(name="puertaenlace", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $puertaenlace;

    /**
     * @var string
     * @ORM\Column(name="topologia", type="string",  nullable=false, length=50)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $topologia;

    /**
     * @var string
     * @ORM\Column(name="lan", type="string",  nullable=true, length=50)
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $lan;

    /**
     * @var string
     * @ORM\Column(name="router", type="string",  nullable=true, length=50)
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $router;

    /**
     * @var string
     * @ORM\Column(name="dmz", type="string",  nullable=true, length=50)
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $dmz;

    /**
     * @var string
     * @ORM\Column(name="gateways", type="string",  nullable=true, length=50)
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $gateways;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $direccionesdisponibles;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "direccionamiento")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "direccionamiento")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Institucion", inversedBy = "direccionamiento")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Intitución.")
     */
    protected $institucion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TablaIP", mappedBy="direccionamientoip", cascade={"all"}, orphanRemoval=true)
     */
    private $tablaip;

    /**
     * @Vich\UploadableField(mapping="direccionamiento_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string",  nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     *
     * @var int|null
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime",  nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    public function getNombreCompleto()
    {
        return $this->getTopologia();
    }

    public function __toString()
    {
        return $this->getNombreCompleto();
    }

    public function __construct()
    {
        $this->tablaip = new ArrayCollection();
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopologia(): ?string
    {
        return $this->topologia;
    }

    public function setTopologia(string $topologia): self
    {
        $this->topologia = $topologia;

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

    /**
     * @return Collection<int, TablaIP>
     */
    public function getTablaip(): Collection
    {
        return $this->tablaip;
    }

    public function addTablaip(TablaIP $tablaip): self
    {
        if (!$this->tablaip->contains($tablaip)) {
            $this->tablaip[] = $tablaip;
            $tablaip->setDireccionamientoip($this);
        }

        return $this;
    }

    public function removeTablaip(TablaIP $tablaip): self
    {
        if ($this->tablaip->removeElement($tablaip)) {
            // set the owning side to null (unless already changed)
            if ($tablaip->getDireccionamientoip() === $this) {
                $tablaip->setDireccionamientoip(null);
            }
        }

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

    public function getBloque(): ?string
    {
        return $this->bloque;
    }

    public function setBloque(string $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }

    public function getDireccionenlace(): ?string
    {
        return $this->direccionenlace;
    }

    public function setDireccionenlace(string $direccionenlace): self
    {
        $this->direccionenlace = $direccionenlace;

        return $this;
    }

    public function getPrefijo(): ?string
    {
        return $this->prefijo;
    }

    public function setPrefijo(string $prefijo): self
    {
        $this->prefijo = $prefijo;

        return $this;
    }

    public function getPuertaenlace(): ?string
    {
        return $this->puertaenlace;
    }

    public function setPuertaenlace(string $puertaenlace): self
    {
        $this->puertaenlace = $puertaenlace;

        return $this;
    }

    public function getLan(): ?string
    {
        return $this->lan;
    }

    public function setLan(?string $lan): self
    {
        $this->lan = $lan;

        return $this;
    }

    public function getRouter(): ?string
    {
        return $this->router;
    }

    public function setRouter(?string $router): self
    {
        $this->router = $router;

        return $this;
    }

    public function getDmz(): ?string
    {
        return $this->dmz;
    }

    public function setDmz(?string $dmz): self
    {
        $this->dmz = $dmz;

        return $this;
    }

    public function getGateways(): ?string
    {
        return $this->gateways;
    }

    public function setGateways(?string $gateways): self
    {
        $this->gateways = $gateways;

        return $this;
    }

    public function getDireccionesdisponibles(): ?string
    {
        return $this->direccionesdisponibles;
    }

    public function setDireccionesdisponibles(?string $direccionesdisponibles): self
    {
        $this->direccionesdisponibles = $direccionesdisponibles;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
