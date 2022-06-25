<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;



/**
 * ResetPasswordRequest
 *
 * @ORM\Table(name="reset_password_request", indexes={@ORM\Index(name="IDX_7CE748A6B3CA4B", columns={"id_user"})})
 * @ORM\Entity
 */
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;
    /**
     * @ORM\Column(name="id_request", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    public function __construct(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): object
    {
        return $this->user;
    }


}
