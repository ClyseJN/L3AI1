<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnoncesHistory
 *
 * @ORM\Table(name="annonces_history", indexes={@ORM\Index(name="annonce_id_idx", columns={"id_annonce"}), @ORM\Index(name="owner_id_idx", columns={"id_annonce_owner"})})
 * @ORM\Entity
 */
class AnnoncesHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_history", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHistory;

    /**
     * @var \Annonce
     *
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonce", referencedColumnName="id_annonce")
     * })
     */
    private $idAnnonce;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonce_owner", referencedColumnName="id_user")
     * })
     */
    private $idAnnonceOwner;

    public function getIdHistory(): ?int
    {
        return $this->idHistory;
    }

    public function getIdAnnonce(): ?Annonce
    {
        return $this->idAnnonce;
    }

    public function setIdAnnonce(?Annonce $idAnnonce): self
    {
        $this->idAnnonce = $idAnnonce;

        return $this;
    }

    public function getIdAnnonceOwner(): ?User
    {
        return $this->idAnnonceOwner;
    }

    public function setIdAnnonceOwner(?User $idAnnonceOwner): self
    {
        $this->idAnnonceOwner = $idAnnonceOwner;

        return $this;
    }


}
