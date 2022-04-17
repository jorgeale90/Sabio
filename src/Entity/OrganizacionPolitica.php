<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizacionPoliticaRepository")
 * @UniqueEntity(fields={"nombre"},message="Ya existe esta Organización Política en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class OrganizacionPolitica
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
}
