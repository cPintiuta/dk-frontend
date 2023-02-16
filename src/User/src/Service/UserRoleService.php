<?php

declare(strict_types=1);

namespace Frontend\User\Service;

use Frontend\User\Entity\UserRole;
use Frontend\User\Repository\UserRoleRepository;
use Doctrine\ORM\EntityManager;
use Dot\AnnotatedServices\Annotation\Inject;

/**
 * Class UserRoleService
 * @package Frontend\User\Service
 */
class UserRoleService implements UserRoleServiceInterface
{
    protected UserRoleRepository $roleRepository;

    /**
     * UserRoleService constructor.
     * @param EntityManager $entityManager
     *
     * @Inject({
     *     EntityManager::class
     * })
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->roleRepository = $entityManager->getRepository(UserRole::class);
    }

    /**
     * @param array $params
     * @return UserRole|null
     */
    public function findOneBy(array $params = []): ?UserRole
    {
        if (empty($params)) {
            return null;
        }

        return $this->roleRepository->findOneBy($params);
    }
}
