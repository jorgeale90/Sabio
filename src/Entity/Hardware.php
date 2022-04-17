<?php

namespace App\Entity;

use App\Repository\RamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RamRepository::class)
 * @UniqueEntity(fields={"codigo"},message="Ya existe este Número de RAM en nuestra Base de Datos.")
 */
class Ram
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
     * @ORM\Column(name="numero", type="string",  nullable=true, length=80, unique=true)
     * @Assert\Length(min=1, max=11, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $numero;

    /**
     * @var string
     * @ORM\Column(name="clasificacion", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $clasificacion;

    /**
     * @var string
     * @ORM\Column(name="capacidad", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $capacidad;

    /**
     * @var string
     * @ORM\Column(name="marca", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $marca;

    /**
     * @var string
     * @ORM\Column(name="velocidad", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $velocidad;

    /**
     * @var string
     * @ORM\Column(name="serie", type="string",  nullable=true, length=80)
     * @Assert\Length(min=1, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\FichaTecnica", inversedBy = "ram")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fichatecnica;

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

    public function getFichatecnica(): ?FichaTecnica
    {
        return $this->fichatecnica;
    }

    public function setFichatecnica(?FichaTecnica $fichatecnica): self
    {
        $this->fichatecnica = $fichatecnica;

        return $this;
    }

    public function getClasificacion(): ?string
    {
        return $this->clasificacion;
    }

    public function setClasificacion(?string $clasificacion): self
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    public function getCapacidad(): ?string
    {
        return $this->capacidad;
    }

    public function setCapacidad(?string $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(?string $marca): self
    {
        $this->marca = $marca;

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

    public function getVelocidad(): ?string
    {
        return $this->velocidad;
    }

    public function setVelocidad(?string $velocidad): self
    {
        $this->velocidad = $velocidad;

        return $this;
    }
}
