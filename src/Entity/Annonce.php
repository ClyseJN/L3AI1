<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="user_id_idx", columns={"id_owner"}), @ORM\Index(name="user_id_idx_owner", columns={"id_owner"})})
 * @ORM\Entity
 */
class Annonce
{

    /**
     * @var int
     *
     * @ORM\Column(name="id_annonce", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAnnonce;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=false)
     */
    private $type;
      /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=45, nullable=false)
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publication_date", type="datetime", nullable=false)
     */
    private $publicationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="lastupdatetime", type="datetime", nullable=true)
     */
    private $lastupdatetime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_owner", referencedColumnName="id_user")
     * })
     */
    private $idOwner;

    public function getIdAnnonce(): ?int
    {
        return $this->idAnnonce;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getLastupdatetime(): ?\DateTimeInterface
    {
        return $this->lastupdatetime;
    }

    public function setLastupdatetime(?\DateTimeInterface $lastupdatetime): self
    {
        $this->lastupdatetime = $lastupdatetime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getIdOwner(): ?user
    {
        return $this->idOwner;
    }

    public function setIdOwner(?User $idOwner): self
    {
        $this->idOwner = $idOwner;

        return $this;
    }
    public  function getIDUser(?User $idOwner)
    {
        return  $idOwner-> getIdUser();
    }
   

}
