<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Common\AbstractEntity;
use Frontend\User\EventListener\UserAvatarEventListener;

/**
 * Class UserAvatar
 * @ORM\Entity(repositoryClass="Frontend\User\Repository\UserAvatarRepository")
 * @ORM\Table(name="user_avatar")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\EntityListeners({UserAvatarEventListener::class})
 * @package Frontend\User\Entity
 */
class UserAvatar extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\User", inversedBy="avatar")
     * @ORM\JoinColumn(name="userUuid", referencedColumnName="uuid", nullable=false)
     */
    protected UserInterface $user;

    /**
     * @ORM\Column(name="name", type="string", length=191)
     */
    protected string $name;

    protected string $url;

    /**
     * UserAvatar constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'name' => $this->getName(),
            'url' => $this->getUrl(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }
}
