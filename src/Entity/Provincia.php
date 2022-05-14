<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProvinciaRepository")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe esta Provincia en nuestra Base de Datos.")
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class Provincia
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
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z ]*$/",
     *     message="Debe de contener solo letras"
     * )
     * @Assert\Length(min=2, max=20, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity = "Pais", inversedBy = "provincia")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un País")
     */
    protected $pais;

    /**
     * @ORM\OneToMany(targetEntity="Municipio", mappedBy="provincia")
     */
    protected $municipio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Institucion", mappedBy="provincia")
     */
    protected $institucion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaTecnica", mappedBy="provincia")
     */
    protected $fichatecnica;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoAnclaje", mappedBy="provincia")
     */
    protected $contratoanclaje;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoCorreo", mappedBy="provincia")
     */
    protected $contratocorreo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoInternet", mappedBy="provincia")
     */
    protected $contratointernet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DireccionamientoIP", mappedBy="provincia")
     */
    protected $direccionamiento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MantenimientoReparacion", mappedBy="provincia")
     */
    protected $mantenimiento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonalMedico", mappedBy="provincia")
     */
    protected $personal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SistemaContable", mappedBy="provincia")
     */
    protected $sistemacontable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedioTecnologico", mappedBy="provincia")
     */
    protected $medio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="provincia")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeloTecnico", mappedBy="provincia")
     */
    protected $modelotecnico;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AuditoriaInterna", mappedBy="provincia")
     */
    protected $auditoria;

    public function __construct()
    {
        $this->municipio = new ArrayCollection();
        $this->fichatecnica = new ArrayCollection();
        $this->institucion = new ArrayCollection();
        $this->contratoanclaje = new ArrayCollection();
        $this->contratocorreo = new ArrayCollection();
        $this->contratointernet = new ArrayCollection();
        $this->direccionamiento = new ArrayCollection();
        $this->mantenimiento = new ArrayCollection();
        $this->personal = new ArrayCollection();
        $this->sistemacontable = new ArrayCollection();
        $this->user = new ArrayCollection();
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

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * @return Collection|Municipio[]
     */
    public function getMunicipio(): Collection
    {
        return $this->municipio;
    }

    public function addMunicipio(Municipio $municipio): self
    {
        if (!$this->municipio->contains($municipio)) {
            $this->municipio[] = $municipio;
            $municipio->setProvincia($this);
        }

        return $this;
    }

    public function removeMunicipio(Municipio $municipio): self
    {
        if ($this->municipio->removeElement($municipio)) {
            // set the owning side to null (unless already changed)
            if ($municipio->getProvincia() === $this) {
                $municipio->setProvincia(null);
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
            $fichatecnica->setProvincia($this);
        }

        return $this;
    }

    public function removeFichatecnica(FichaTecnica $fichatecnica): self
    {
        if ($this->fichatecnica->removeElement($fichatecnica)) {
            // set the owning side to null (unless already changed)
            if ($fichatecnica->getProvincia() === $this) {
                $fichatecnica->setProvincia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Institucion[]
     */
    public function getInstitucion(): Collection
    {
        return $this->institucion;
    }

    public function addInstitucion(Institucion $institucion): self
    {
        if (!$this->institucion->contains($institucion)) {
            $this->institucion[] = $institucion;
            $institucion->setPais($this);
        }

        return $this;
    }

    public function removeInstitucion(Institucion $institucion): self
    {
        if ($this->institucion->removeElement($institucion)) {
            // set the owning side to null (unless already changed)
            if ($institucion->getPais() === $this) {
                $institucion->setPais(null);
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
            $contratoanclaje->setProvincia($this);
        }

        return $this;
    }

    public function removeContratoanclaje(ContratoAnclaje $contratoanclaje): self
    {
        if ($this->contratoanclaje->removeElement($contratoanclaje)) {
            // set the owning side to null (unless already changed)
            if ($contratoanclaje->getProvincia() === $this) {
                $contratoanclaje->setProvincia(null);
            }
        }

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
            $contratocorreo->setProvincia($this);
        }

        return $this;
    }

    public function removeContratocorreo(ContratoCorreo $contratocorreo): self
    {
        if ($this->contratocorreo->removeElement($contratocorreo)) {
            // set the owning side to null (unless already changed)
            if ($contratocorreo->getProvincia() === $this) {
                $contratocorreo->setProvincia(null);
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
            $contratointernet->setProvincia($this);
        }

        return $this;
    }

    public function removeContratointernet(ContratoInternet $contratointernet): self
    {
        if ($this->contratointernet->removeElement($contratointernet)) {
            // set the owning side to null (unless already changed)
            if ($contratointernet->getProvincia() === $this) {
                $contratointernet->setProvincia(null);
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
            $direccionamiento->setProvincia($this);
        }

        return $this;
    }

    public function removeDireccionamiento(DireccionamientoIP $direccionamiento): self
    {
        if ($this->direccionamiento->removeElement($direccionamiento)) {
            // set the owning side to null (unless already changed)
            if ($direccionamiento->getProvincia() === $this) {
                $direccionamiento->setProvincia(null);
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
            $mantenimiento->setProvincia($this);
        }

        return $this;
    }

    public function removeMantenimiento(MantenimientoReparacion $mantenimiento): self
    {
        if ($this->mantenimiento->removeElement($mantenimiento)) {
            // set the owning side to null (unless already changed)
            if ($mantenimiento->getProvincia() === $this) {
                $mantenimiento->setProvincia(null);
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
            $personal->setProvincia($this);
        }

        return $this;
    }

    public function removePersonal(PersonalMedico $personal): self
    {
        if ($this->personal->removeElement($personal)) {
            // set the owning side to null (unless already changed)
            if ($personal->getProvincia() === $this) {
                $personal->setProvincia(null);
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
            $sistemacontable->setProvincia($this);
        }

        return $this;
    }

    public function removeSistemacontable(SistemaContable $sistemacontable): self
    {
        if ($this->sistemacontable->removeElement($sistemacontable)) {
            // set the owning side to null (unless already changed)
            if ($sistemacontable->getProvincia() === $this) {
                $sistemacontable->setProvincia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setProvincia($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProvincia() === $this) {
                $user->setProvincia(null);
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
            $medio->setProvincia($this);
        }

        return $this;
    }

    public function removeMedio(MedioTecnologico $medio): self
    {
        if ($this->medio->removeElement($medio)) {
            // set the owning side to null (unless already changed)
            if ($medio->getProvincia() === $this) {
                $medio->setProvincia(null);
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
            $modelotecnico->setProvincia($this);
        }

        return $this;
    }

    public function removeModelotecnico(ModeloTecnico $modelotecnico): self
    {
        if ($this->modelotecnico->removeElement($modelotecnico)) {
            // set the owning side to null (unless already changed)
            if ($modelotecnico->getProvincia() === $this) {
                $modelotecnico->setProvincia(null);
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
            $auditorium->setProvincia($this);
        }

        return $this;
    }

    public function removeAuditorium(AuditoriaInterna $auditorium): self
    {
        if ($this->auditoria->removeElement($auditorium)) {
            // set the owning side to null (unless already changed)
            if ($auditorium->getProvincia() === $this) {
                $auditorium->setProvincia(null);
            }
        }

        return $this;
    }
}
