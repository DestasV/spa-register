<?php

namespace App\Service;


use App\Entity\User;
use App\Entity\UserHistory;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserHistoryCreator
 *
 * @package App\Service
 */
class UserHistoryCreator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserHistoryCreator constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     */
    public function saveUserHistory(User $user)
    {
        $userHistory = new UserHistory();

        $userHistory->setUser($user);
        $userHistory->setOldUsername($user->getUsername());
        $userHistory->setOldEmail($user->getEmail());
        $userHistory->setOldCountry($user->getCountry());
        $userHistory->setSavedOn(new \DateTime('now'));

        $this->entityManager->persist($userHistory);
        $this->entityManager->flush();
    }
}