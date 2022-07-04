<?php

namespace Frontend\User\Service;

use Doctrine\ORM\ORMException;
use Dot\Mail\Exception\MailException;
use Frontend\User\Entity\User;
use Frontend\User\Entity\UserInterface;
use Frontend\User\Repository\UserRepository;

/**
 * Interface UserServiceInterface
 * @package Frontend\User\Service
 */
interface UserServiceInterface
{
    /**
     * @param array $data
     * @return UserInterface
     * @throws \Exception
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(array $data): UserInterface;

    /**
     * @param User $user
     * @return bool
     * @throws MailException
     */
    public function sendActivationMail(User $user);

    /**
     * @param array $params
     * @return User|null
     */
    public function findOneBy(array $params = []): ?User;

    /**
     * @param User $user
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function activateUser(User $user);

    /**
     * @param string $email
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRoleNamesByEmail(string $email);

    /**
     * @param string $uuid
     * @return User|null
     */
    public function findByUuid(string $uuid);

    /**
     * @return UserRepository
     */
    public function getRepository(): UserRepository;

    /**
     * @param User $user
     * @param string $userAgent
     * @return void
     * @throws ORMException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addRememberMeToken(User $user, string $userAgent);

    /**
     * @return void
     * @throws ORMException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteRememberMeCookie();
}
