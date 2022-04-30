<?php

namespace App\Entity;

use App\Repository\SoporteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=SoporteRepository::class)
 * @UniqueEntity(fields={"numero"},message="Ya existe este No. de Identificación en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class Soporte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(pattern="/\w/", match=true, message="Debe contener solo números")
     * @ORM\Column(name="numero", type="string",  nullable=false, length=80, unique=true)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $numero;

    /**
     * @ORM\Column(type = "text", nullable=false)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $contenidofundamental;

    /**
     * @var string
     * @ORM\Column(name="nivelacceso", type="string",  nullable=false, length=90)
     * @Assert\NotBlank(message="No debe estar vacío")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Debe de contener solo letras o números"
     * )
     * @Assert\Length(min=2, max=90, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nivelacceso;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @Assert\Length(min=1, max=1000, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $observaciones;

    public function __toString()
    {
        return $this->getNumero();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getContenidofundamental(): ?string
    {
        return $this->contenidofundamental;
    }

    public function setContenidofundamental(string $contenidofundamental): self
    {
        $this->contenidofundamental = $contenidofundamental;

        return $this;
    }

    public function getNivelacceso(): ?string
    {
        return $this->nivelacceso;
    }

    public function setNivelacceso(string $nivelacceso): self
    {
        $this->nivelacceso = $nivelacceso;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }
}
