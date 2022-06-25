<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


/**
 * Table User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
   
    /**
     * @var int
     * 
     * @ORM\Column(name="id_user", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
    
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    public $email;

    /**
     * @var string
  
     * @ORM\Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;

    /**
     * @var string
    
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     */
    public $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    public $lastName;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="birth_day", type="date", nullable=false)
     */
    public $birthDay;

    /**
     * @var string
     
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=false)
     */
    public $adresse;

    /**
     * @var int
 
     * @ORM\Column(name="phone", type="integer", nullable=false)
     */
    public $phone;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="idUser")
     * @ORM\JoinTable(name="skills_list",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_skill", referencedColumnName="id_skill")
     *   }
     * )
     */
    private $idSkill;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;
  

   
    public function __construct()
    {
        $this->idSkill = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sent = new ArrayCollection();
        $this->received = new ArrayCollection();
    
    }
    public function getRoles():array
    {
         return array('ROLE_USER');
    }

    public function getPassword (): ?string
    {
        return $this->password;
    }
    
    //#[ORM\OneToMany(mappedBy: 'sender', targetEntity: Messages::class, orphanRemoval: true)]
    /** 
    * @ORM\OneToMany(targetEntity="Messages",mappedBy="sender")
    */
    private $sent;

    //#[ORM\OneToMany(mappedBy: 'recipient', targetEntity: Messages::class, orphanRemoval: true)]
    /** 
    * @ORM\OneToMany(targetEntity="Messages",mappedBy="recipient")
    */
    private $received;
    /**
     * @ORM\Column(type="string")
     * 
     */
    private $image;

    public function getImage() 
    {
        return $this->image;
    }

    public function setImage($image) :self
    {
        $this->image = $image;

        return $this;
    }

    public function setPassword (string $password):self
    {
        $this->password = $password;
        return $this;
    }
    
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function eraseCredentials(){}
    public function getUserName(){}
    
    public function getUserIdentifier():string{
        return $this -> email;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(\DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getIdSkill(): Collection
    {
        return $this->idSkill;
    }

    public function addIdSkill(Skill $idSkill): self
    {
        if (!$this->idSkill->contains($idSkill)) {
            $this->idSkill[] = $idSkill;
        }

        return $this;
    }

    public function removeIdSkill(Skill $idSkill): self
    {
        $this->idSkill->removeElement($idSkill);

        return $this;
    }
    
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt()
    {
    }

    /** 
     * Fonction permettant de récupérer les messages qui ont été envoyés
     * @return Collection|Messages[]
     */
    public function getSent(): Collection
    {
        return $this->sent;
    }

    public function addSent(Messages $sent): self
    {
        if (!$this->sent->contains($sent)) {
            $this->sent[] = $sent;
            $sent->setSender($this);
        }
        return $this;
    }

    public function removeSent(Messages $sent): self
    {
        if ($this->sent->removeElement($sent)) {
            // set the owning side to null (unless already changed)
            if ($sent->getSender() === $this) {
                $sent->setSender(null);
            }
        }
        return $this;
    }

    /** 
     * Fonction permettant de récupérer les messages qui ont été reçus
     * @return Collection|Messages[]
     */
    public function getReceived(): Collection
    {
        return $this->received;
    }
    public function addReceived(Messages $received): self
    {
        if (!$this->received->contains($received)) {
            $this->received[] = $received;
            $received->setRecipient($this);
        }

        return $this;
    }
    public function removeReceived(Messages $received): self
    {
        if ($this->received->removeElement($received)) {
            // set the owning side to null (unless already changed)
            if ($received->getRecipient() === $this) {
                $received->setRecipient(null);
            }
        }

        return $this;
    }

}
