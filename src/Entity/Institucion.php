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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DireccionamientoIP", mappedBy="institucion")
     */
    protected $direccionamiento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MantenimientoReparacion", mappedBy="institucion")
     */
    protected $mantenimiento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonalMedico", mappedBy="institucion")
     */
    protected $personal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedioTecnologico", mappedBy="institucion")
     */
    protected $medio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SistemaContable", mappedBy="institucion")
     */
    protected $sistemacontable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeloTecnico", mappedBy="institucion")
     */
    protected $modelotecnico;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AuditoriaInterna", mappedBy="institucion")
     */
    protected $auditoria;

    public function __construct()
    {
        $this->contratocorreo = new ArrayCollection();
        $this->contratoanclaje = new ArrayCollection();
        $this->contratointernet = new ArrayCollection();
        $this->fichatecnica = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->direccionamiento = new ArrayCollection();
        $this->mantenimiento = new ArrayCollection();
        $this->personal = new ArrayCollection();
        $this->sistemacontable = new ArrayCollection();
        $this->medio = new ArrayCollection();
        $this->modelotecnico = new ArrayCollection();
        $this->auditoria = new ArrayCollection();
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

    /**
     * @return Collection<int, DireccionamientoIP>
     */
    public function getDireccionamiento(): Collection
    {
        return $this->direccionamiento;
    }

    public function addDireccionamiento(DireccionamientoIP $direccionamiento): self
    {
        if (!$this->direccionamiento->contains($direccionamiento)) {
            $this->direccionamiento[] = $direccionamiento;
            $direccionamiento->setInstitucion($this);
        }

        return $this;
    }

    public function removeDireccionamiento(DireccionamientoIP $direccionamiento): self
    {
        if ($this->direccionamiento->removeElement($direccionamiento)) {
            // set the owning side to null (unless already changed)
            if ($direccionamiento->getInstitucion() === $this) {
                $direccionamiento->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MantenimientoReparacion>
     */
    public function getMantenimiento(): Collection
    {
        return $this->mantenimiento;
    }

    public function addMantenimiento(MantenimientoReparacion $mantenimiento): self
    {
        if (!$this->mantenimiento->contains($mantenimiento)) {
            $this->mantenimiento[] = $mantenimiento;
            $mantenimiento->setInstitucion($this);
        }

        return $this;
    }

    public function removeMantenimiento(MantenimientoReparacion $mantenimiento): self
    {
        if ($this->mantenimiento->removeElement($mantenimiento)) {
            // set the owning side to null (unless already changed)
            if ($mantenimiento->getInstitucion() === $this) {
                $mantenimiento->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonalMedico>
     */
    public function getPersonal(): Collection
    {
        return $this->personal;
    }

    public function addPersonal(PersonalMedico $personal): self
    {
        if (!$this->personal->contains($personal)) {
            $this->personal[] = $personal;
            $personal->setInstitucion($this);
        }

        return $this;
    }

    public function removePersonal(PersonalMedico $personal): self
    {
        if ($this->personal->removeElement($personal)) {
            // set the owning side to null (unless already changed)
            if ($personal->getInstitucion() === $this) {
                $personal->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SistemaContable>
     */
    public function getSistemacontable(): Collection
    {
        return $this->sistemacontable;
    }

    public function addSistemacontable(SistemaContable $sistemacontable): self
    {
        if (!$this->sistemacontable->contains($sistemacontable)) {
            $this->sistemacontable[] = $sistemacontable;
            $sistemacontable->setInstitucion($this);
        }

        return $this;
    }

    public function removeSistemacontable(SistemaContable $sistemacontable): self
    {
        if ($this->sistemacontable->removeElement($sistemacontable)) {
            // set the owning side to null (unless already changed)
            if ($sistemacontable->getInstitucion() === $this) {
                $sistemacontable->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedioTecnologico>
     */
    public function getMedio(): Collection
    {
        return $this->medio;
    }

    public function addMedio(MedioTecnologico $medio): self
    {
        if (!$this->medio->contains($medio)) {
            $this->medio[] = $medio;
            $medio->setInstitucion($this);
        }

        return $this;
    }

    public function removeMedio(MedioTecnologico $medio): self
    {
        if ($this->medio->removeElement($medio)) {
            // set the owning side to null (unless already changed)
            if ($medio->getInstitucion() === $this) {
                $medio->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ModeloTecnico>
     */
    public function getModelotecnico(): Collection
    {
        return $this->modelotecnico;
    }

    public function addModelotecnico(ModeloTecnico $modelotecnico): self
    {
        if (!$this->modelotecnico->contains($modelotecnico)) {
            $this->modelotecnico[] = $modelotecnico;
            $modelotecnico->setInstitucion($this);
        }

        return $this;
    }

    public function removeModelotecnico(ModeloTecnico $modelotecnico): self
    {
        if ($this->modelotecnico->removeElement($modelotecnico)) {
            // set the owning side to null (unless already changed)
            if ($modelotecnico->getInstitucion() === $this) {
                $modelotecnico->setInstitucion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AuditoriaInterna>
     */
    public function getAuditoria(): Collection
    {
        return $this->auditoria;
    }

    public function addAuditorium(AuditoriaInterna $auditorium): self
    {
        if (!$this->auditoria->contains($auditorium)) {
            $this->auditoria[] = $auditorium;
            $auditorium->setInstitucion($this);
        }

        return $this;
    }

    public function removeAuditorium(AuditoriaInterna $auditorium): self
    {
        if ($this->auditoria->removeElement($auditorium)) {
            // set the owning side to null (unless already changed)
            if ($auditorium->getInstitucion() === $this) {
                $auditorium->setInstitucion(null);
            }
        }

        return $this;
    }

}
