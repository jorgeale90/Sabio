<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitucionRepository")
 * @UniqueEntity(fields={"nombre"},message="Ya existe esta Institución.")
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
     * @ORM\ManyToOne(targetEntity = "Municipio", inversedBy = "institucion")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\OneToMany(targetEntity="ContratoCorreo", mappedBy="institucion")
     */
    protected $contratocorreo;

    /**
     * @ORM\OneToMany(targetEntity="ContratoAnclaje", mappedBy="institucion")
     */
    protected $contratoanclaje;

    /**
     * @ORM\OneToMany(targetEntity="ContratoInternet", mappedBy="institucion")
     */
    protected $contratointernet;

    public function __construct()
    {
        $this->contratocorreo = new ArrayCollection();
        $this->contratoanclaje = new ArrayCollection();
        $this->contratointernet = new ArrayCollection();
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
}
