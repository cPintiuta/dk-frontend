<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Frontend\App\Common\AbstractEntity;

/**
 * Class UserResetPassword
 * @ORM\Entity()
 * @ORM\Table(name="user_reset_password")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\User\Entity
 */
class UserResetPassword extends AbstractEntity
{
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_REQUESTED = 'requested';
    public const STATUSES = [
        self::STATUS_COMPLETED,
        self::STATUS_REQUESTED
    ];

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"}, inversedBy="resetPasswords")
     * @ORM\JoinColumn(name="userUuid", referencedColumnName="uuid", nullable=false)
     */
    protected User $user;

    /**
     * @ORM\Column(name="expires", type="datetime_immutable", nullable=false)
     */
    protected DateTimeImmutable $expires;

    /**
     * @ORM\Column(name="hash", type="string", length=64, nullable=false, unique=true)
     */
    protected string $hash;

    /**
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    protected string $status = self::STATUS_REQUESTED;

    /**
     * UserResetPassword constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->expires = DateTimeImmutable::createFromMutable(
            (new DateTime())->add(new DateInterval('P1D'))
        );
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpires(): DateTimeImmutable
    {
        return $this->expires;
    }

    /**
     * @param DateTimeImmutable $expires
     * @return self
     */
    public function setExpires(DateTimeImmutable $expires): self
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return self
     */
    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Helper methods
     */

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->getStatus() === self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        try {
            return $this->getExpires() > (new DateTimeImmutable());
        } catch (Exception) {
        }

        return false;
    }

    /**
     * @return self
     */
    public function markAsCompleted(): self
    {
        $this->status = self::STATUS_COMPLETED;

        return $this;
    }
}
