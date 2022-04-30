<?php

namespace App\Entity;

use App\Repository\TablaIPRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=TablaIPRepository::class)
 * @UniqueEntity(fields={"ip"},message="Ya existe este Número de IP en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class TablaIP
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
     * @ORM\Column(name="numero", type="string",  nullable=true, length=90, unique=true)
     * @Assert\Length(min=1, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $ip;

    /**
     * @var string
     * @ORM\Column(name="mac", type="string",  nullable=true, length=150)
     * @Assert\Length(min=2, max=150, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $mac;

    /**
     * @var string
     * @ORM\Column(name="departamento", type="string",  nullable=true, length=150)
     * @Assert\Length(min=2, max=150, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $departamento;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\DireccionamientoIP", inversedBy = "tablaip")
     * @ORM\JoinColumn(nullable=true)
     */
    private $direccionamientoip;

    public function __toString()
    {
        return $this->getIp();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    public function setDepartamento(?string $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getDireccionamientoip(): ?DireccionamientoIP
    {
        return $this->direccionamientoip;
    }

    public function setDireccionamientoip(?DireccionamientoIP $direccionamientoip): self
    {
        $this->direccionamientoip = $direccionamientoip;

        return $this;
    }

    public function getMac(): ?string
    {
        return $this->mac;
    }

    public function setMac(?string $mac): self
    {
        $this->mac = $mac;

        return $this;
    }

}
