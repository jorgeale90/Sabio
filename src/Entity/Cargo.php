<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation\Auditable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CargoRepository")
 * @UniqueEntity(fields={"nombre"},message="Ya existe este Cargo u Ocupación en nuestra Base de Datos.")
 * @Auditable()
 */
class Cargo
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
     * @ORM\OneToMany(targetEntity="Especialidad", mappedBy="cargo")
     */
    protected $especialidad;

    /**
     * @ORM\OneToMany(targetEntity="PersonalMedico", mappedBy="cargo")
     */
    protected $personal;

    public function __construct()
    {
        $this->especialidad = new ArrayCollection();
        $this->personal = new ArrayCollection();
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

    /**
     * @return Collection|Especialidad[]
     */
    public function getEspecialidad(): Collection
    {
        return $this->especialidad;
    }

    public function addEspecialidad(Especialidad $especialidad): self
    {
        if (!$this->especialidad->contains($especialidad)) {
            $this->especialidad[] = $especialidad;
            $especialidad->setCargo($this);
        }

        return $this;
    }

    public function removeEspecialidad(Especialidad $especialidad): self
    {
        if ($this->especialidad->removeElement($especialidad)) {
            // set the owning side to null (unless already changed)
            if ($especialidad->getCargo() === $this) {
                $especialidad->setCargo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PersonalMedico[]
     */
    public function getPersonal(): Collection
    {
        return $this->personal;
    }

    public function addPersonal(PersonalMedico $personal): self
    {
        if (!$this->personal->contains($personal)) {
            $this->personal[] = $personal;
            $personal->setCargo($this);
        }

        return $this;
    }

    public function removePersonal(PersonalMedico $personal): self
    {
        if ($this->personal->removeElement($personal)) {
            // set the owning side to null (unless already changed)
            if ($personal->getCargo() === $this) {
                $personal->setCargo(null);
            }
        }

        return $this;
    }
}
