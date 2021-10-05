<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaCientificaRepository")
 * @UniqueEntity(fields={"nombre"},message="Ya existe esta Categoría Científica.")
 */

class CategoriaCientifica
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string",  nullable=false, length=25, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=2, max=25, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="PersonalMedico", mappedBy="categoriacientifica")
     */
    protected $personal;

    public function __construct()
    {
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
            $personal->setCategoriacientifica($this);
        }

        return $this;
    }

    public function removePersonal(PersonalMedico $personal): self
    {
        if ($this->personal->removeElement($personal)) {
            // set the owning side to null (unless already changed)
            if ($personal->getCategoriacientifica() === $this) {
                $personal->setCategoriacientifica(null);
            }
        }

        return $this;
    }
}
