<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competence
 *
 * @ORM\Table(name="competence", indexes={@ORM\Index(name="id_domaine_idx", columns={"id_domaine"}), @ORM\Index(name="id_owner_index", columns={"id_owner"})})
 * @ORM\Entity
 */
class Competence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=0, nullable=false)
     */
    private $content;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \Domaine
     *
     * @ORM\ManyToOne(targetEntity="Domaine")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domaine", referencedColumnName="id")
     * })
     */
    private $idDomaine;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_owner", referencedColumnName="id_user")
     * })
     */
    private $idOwner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
 
    
    public function getIdDomaine(): ? int
    {
        return $this->idDomaine->getId;
    }

    public function setIdDomaine(int $idDomaine): self
    {
       $this->idDomaine = $idDomaine;
       return $this;
    }
    public function getIdOwner(): ? User
    {
        return $this->idOwner->getIdUser;

    }

    public function setIdOwner(User $idOwner): self
    {
       $this->idOwner = $idOwner;
       return $this;
    }

    public function getType(): ? string
    {
        return $this->type;

    }

    public function setType(string $type): self
    {
       $this->type = $type;
       return $this;
    }
 
}
