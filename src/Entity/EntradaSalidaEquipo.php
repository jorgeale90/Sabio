<?php

namespace App\Entity;

use App\Repository\EntradaSalidaEquipoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntradaSalidaEquipoRepository::class)
 */
class EntradaSalidaEquipo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
