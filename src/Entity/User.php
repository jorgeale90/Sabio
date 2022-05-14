<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"fullname"}, message="Ya existe este nombre completo en nuestra Base de Datos en nuestra Base de Datos.")
 * @UniqueEntity(fields={"email"}, message="Ya existe una cuenta con este correo.")
 * @Vich\Uploadable
 * @Audit\Auditable()
 * @Audit\Security(view={"ROLE_ADMIN"})
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Regex(pattern="/\d/", match=false, message="Debe contener solo letras")
     * @ORM\Column(name="fullname", type="string", length=80)
     * @Assert\Length(min=2, max=80, minMessage="Debe contener al menos {{ limit }} letras", maxMessage="Debe contener a lo sumo {{ limit }} letras")
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $esDenegar;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Provincia", inversedBy = "user")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Provincia")
     */
    protected $provincia;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Municipio", inversedBy = "user")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar un Municipio")
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity = "App\Entity\Institucion", inversedBy = "user")
     * @ORM\JoinColumn(name="institucion_id", referencedColumnName="id", onDelete = "CASCADE")
     * @Assert\NotBlank(message="Debe seleccionar una Institución")
     */
    protected $institucion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SistemaContable", mappedBy="user")
     */
    protected $sistemacontable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedioTecnologico", mappedBy="user")
     */
    protected $medio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonalMedico", mappedBy="user")
     */
    protected $personalmed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DireccionamientoIP", mappedBy="user")
     */
    protected $direccionamiento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeloTecnico", mappedBy="user")
     */
    protected $modelotecnico;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaTecnica", mappedBy="user")
     */
    protected $fichatecnica;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AuditoriaInterna", mappedBy="user")
     */
    protected $auditoria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContratoCorreo", mappedBy="user")
     */
    protected $contratocorreo;

    public function __construct()
    {
        $this->sistemacontable = new ArrayCollection();
        $this->medio = new ArrayCollection();
        $this->personalmed = new ArrayCollection();
        $this->direccionamiento = new ArrayCollection();
        $this->modelotecnico = new ArrayCollection();
        $this->fichatecnica = new ArrayCollection();
        $this->auditoria = new ArrayCollection();
        $this->contratocorreo = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFullname();
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->image,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->image,
            ) = unserialize($serialized);
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEsDenegar(): ?bool
    {
        return $this->esDenegar;
    }

    public function setEsDenegar(?bool $esDenegar): self
    {
        $this->esDenegar = $esDenegar;

        return $this;
    }

    public function getInstitucion(): ?Institucion
    {
        return $this->institucion;
    }

    public function setInstitucion(?Institucion $institucion): self
    {
        $this->institucion = $institucion;

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
            $sistemacontable->setUser($this);
        }

        return $this;
    }

    public function removeSistemacontable(SistemaContable $sistemacontable): self
    {
        if ($this->sistemacontable->removeElement($sistemacontable)) {
            // set the owning side to null (unless already changed)
            if ($sistemacontable->getUser() === $this) {
                $sistemacontable->setUser(null);
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
            $medio->setUser($this);
        }

        return $this;
    }

    public function removeMedio(MedioTecnologico $medio): self
    {
        if ($this->medio->removeElement($medio)) {
            // set the owning side to null (unless already changed)
            if ($medio->getUser() === $this) {
                $medio->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonalMedico>
     */
    public function getPersonalmed(): Collection
    {
        return $this->personalmed;
    }

    public function addPersonalmed(PersonalMedico $personalmed): self
    {
        if (!$this->personalmed->contains($personalmed)) {
            $this->personalmed[] = $personalmed;
            $personalmed->setUser($this);
        }

        return $this;
    }

    public function removePersonalmed(PersonalMedico $personalmed): self
    {
        if ($this->personalmed->removeElement($personalmed)) {
            // set the owning side to null (unless already changed)
            if ($personalmed->getUser() === $this) {
                $personalmed->setUser(null);
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
            $direccionamiento->setUser($this);
        }

        return $this;
    }

    public function removeDireccionamiento(DireccionamientoIP $direccionamiento): self
    {
        if ($this->direccionamiento->removeElement($direccionamiento)) {
            // set the owning side to null (unless already changed)
            if ($direccionamiento->getUser() === $this) {
                $direccionamiento->setUser(null);
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
            $modelotecnico->setUser($this);
        }

        return $this;
    }

    public function removeModelotecnico(ModeloTecnico $modelotecnico): self
    {
        if ($this->modelotecnico->removeElement($modelotecnico)) {
            // set the owning side to null (unless already changed)
            if ($modelotecnico->getUser() === $this) {
                $modelotecnico->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FichaTecnica>
     */
    public function getFichatecnica(): Collection
    {
        return $this->fichatecnica;
    }

    public function addFichatecnica(FichaTecnica $fichatecnica): self
    {
        if (!$this->fichatecnica->contains($fichatecnica)) {
            $this->fichatecnica[] = $fichatecnica;
            $fichatecnica->setUser($this);
        }

        return $this;
    }

    public function removeFichatecnica(FichaTecnica $fichatecnica): self
    {
        if ($this->fichatecnica->removeElement($fichatecnica)) {
            // set the owning side to null (unless already changed)
            if ($fichatecnica->getUser() === $this) {
                $fichatecnica->setUser(null);
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
            $auditorium->setUser($this);
        }

        return $this;
    }

    public function removeAuditorium(AuditoriaInterna $auditorium): self
    {
        if ($this->auditoria->removeElement($auditorium)) {
            // set the owning side to null (unless already changed)
            if ($auditorium->getUser() === $this) {
                $auditorium->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContratoCorreo>
     */
    public function getContratocorreo(): Collection
    {
        return $this->contratocorreo;
    }

    public function addContratocorreo(ContratoCorreo $contratocorreo): self
    {
        if (!$this->contratocorreo->contains($contratocorreo)) {
            $this->contratocorreo[] = $contratocorreo;
            $contratocorreo->setUser($this);
        }

        return $this;
    }

    public function removeContratocorreo(ContratoCorreo $contratocorreo): self
    {
        if ($this->contratocorreo->removeElement($contratocorreo)) {
            // set the owning side to null (unless already changed)
            if ($contratocorreo->getUser() === $this) {
                $contratocorreo->setUser(null);
            }
        }

        return $this;
    }
}
