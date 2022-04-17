<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitucionRepository")
 * @UniqueEntity(fields={"nombre"},message="Ya existe esta Institución en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class Institucion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string",  nullable=false, length=50, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="codpostal", type="string",  nullable=true, length=50)
     * @Assert\Length(min=2, max=50, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $codpostal;

    /**
     * @var string
     * @ORM\Column(name="telefono", type="string",  nullable=true, length=10)
     * @Assert\Length(min=6, max=10, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $telefono;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=200, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $direccion;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "institucion")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "institucion")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoCorreo", mappedBy="institucion")
     */
    protected $contratocorreo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoAnclaje", mappedBy="institucion")
     */
    protected $contratoanclaje;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoInternet", mappedBy="institucion")
     */
    protected $contratointernet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaTecnica", mappedBy="institucion")
     */
    protected $fichatecnica;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="institucion")
     */
    protected $user;

    public function __construct()
    {
        $this->contratocorreo = new ArrayCollection();
        $this->contratoanclaje = new ArrayCollection();
        $this->contratointernet = new ArrayCollection();
        $this->fichatecnica = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function __toString() {

        return $this->getNombre();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCodpostal(): ?string
    {
        return $this->codpostal;
    }

    public function setCodpostal(?string $codpostal): self
    {
        $this->codpostal = $codpostal;

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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

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

    /**
     * @return Collection|ContratoCorreo[]
     */
    public function getContratocorreo(): Collection
    {
        return $this->contratocorreo;
    }

    public function addContratocorreo(ContratoCorreo $contratocorreo): self
    {
        if (!$this->contratocorreo->contains($contratocorreo)) {
            $this->contratocorreo[] = $contratocorreo;
            $contratocorreo->setInstitucion($this);
        }

        return $this;
    }

    public function removeContratocorreo(ContratoCorreo $contratocorreo): self
    {
        if ($this->contratocorreo->removeElement($contratocorreo)) {
            // set the owning side to null (unless already changed)
            if ($contratocorreo->getInstitucion() === $this) {
                $contratocorreo->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContratoAnclaje[]
     */
    public function getContratoanclaje(): Collection
    {
        return $this->contratoanclaje;
    }

    public function addContratoanclaje(ContratoAnclaje $contratoanclaje): self
    {
        if (!$this->contratoanclaje->contains($contratoanclaje)) {
            $this->contratoanclaje[] = $contratoanclaje;
            $contratoanclaje->setInstitucion($this);
        }

        return $this;
    }

    public function removeContratoanclaje(ContratoAnclaje $contratoanclaje): self
    {
        if ($this->contratoanclaje->removeElement($contratoanclaje)) {
            // set the owning side to null (unless already changed)
            if ($contratoanclaje->getInstitucion() === $this) {
                $contratoanclaje->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContratoInternet[]
     */
    public function getContratointernet(): Collection
    {
        return $this->contratointernet;
    }

    public function addContratointernet(ContratoInternet $contratointernet): self
    {
        if (!$this->contratointernet->contains($contratointernet)) {
            $this->contratointernet[] = $contratointernet;
            $contratointernet->setInstitucion($this);
        }

        return $this;
    }

    public function removeContratointernet(ContratoInternet $contratointernet): self
    {
        if ($this->contratointernet->removeElement($contratointernet)) {
            // set the owning side to null (unless already changed)
            if ($contratointernet->getInstitucion() === $this) {
                $contratointernet->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FichaTecnica[]
     */
    public function getFichatecnica(): Collection
    {
        return $this->fichatecnica;
    }

    public function addFichatecnica(FichaTecnica $fichatecnica): self
    {
        if (!$this->fichatecnica->contains($fichatecnica)) {
            $this->fichatecnica[] = $fichatecnica;
            $fichatecnica->setInstitucion($this);
        }

        return $this;
    }

    public function removeFichatecnica(FichaTecnica $fichatecnica): self
    {
        if ($this->fichatecnica->removeElement($fichatecnica)) {
            // set the owning side to null (unless already changed)
            if ($fichatecnica->getInstitucion() === $this) {
                $fichatecnica->setInstitucion(null);
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

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setInstitucion($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getInstitucion() === $this) {
                $user->setInstitucion(null);
            }
        }

        return $this;
    }

}
