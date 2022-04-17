<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoMedioRepository")
 * @UniqueEntity(fields={"nombre"},message="Ya existe este Tipo de Medio en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class TipoMedio
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
     * @ORM\OneToMany(targetEntity="MedioTecnologico", mappedBy="tipomedio")
     */
    protected $mediotecnologico;

    public function __construct()
    {
        $this->mediotecnologico = new ArrayCollection();
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
     * @return Collection|MedioTecnologico[]
     */
    public function getMediotecnologico(): Collection
    {
        return $this->mediotecnologico;
    }

    public function addMediotecnologico(MedioTecnologico $mediotecnologico): self
    {
        if (!$this->mediotecnologico->contains($mediotecnologico)) {
            $this->mediotecnologico[] = $mediotecnologico;
            $mediotecnologico->setTipomedio($this);
        }

        return $this;
    }

    public function removeMediotecnologico(MedioTecnologico $mediotecnologico): self
    {
        if ($this->mediotecnologico->removeElement($mediotecnologico)) {
            // set the owning side to null (unless already changed)
            if ($mediotecnologico->getTipomedio() === $this) {
                $mediotecnologico->setTipomedio(null);
            }
        }

        return $this;
    }
}
