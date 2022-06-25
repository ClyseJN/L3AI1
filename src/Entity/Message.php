<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="user_id2_idx", columns={"id_recipient"}), @ORM\Index(name="user_id_idx", columns={"id_sender"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_message", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=500, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="is_read", type="integer", nullable=false)
     */
    private $isRead;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sender", referencedColumnName="id_user")
     * })
     */
    private $idSender;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_recipient", referencedColumnName="id_user")
     * })
     */
    private $idRecipient;

    public function getIdMessage(): ?int
    {
        return $this->idMessage;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIsRead(): ?int
    {
        return $this->isRead;
    }

    public function setIsRead(int $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getIdSender(): ?User
    {
        return $this->idSender;
    }

    public function setIdSender(?User $idSender): self
    {
        $this->idSender = $idSender;

        return $this;
    }

    public function getIdRecipient(): ?User
    {
        return $this->idRecipient;
    }

    public function setIdRecipient(?User $idRecipient): self
    {
        $this->idRecipient = $idRecipient;

        return $this;
    }


}
