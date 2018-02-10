<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserHistoryRepository")
 */
class UserHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $oldUsername;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $oldEmail;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $oldCountry;

    /**
     * @ORM\Column(type="datetime")
     */
    private $savedOn;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getOldUsername()
    {
        return $this->oldUsername;
    }

    /**
     * @param mixed $oldUsername
     */
    public function setOldUsername($oldUsername): void
    {
        $this->oldUsername = $oldUsername;
    }

    /**
     * @return mixed
     */
    public function getOldEmail()
    {
        return $this->oldEmail;
    }

    /**
     * @param mixed $oldEmail
     */
    public function setOldEmail($oldEmail): void
    {
        $this->oldEmail = $oldEmail;
    }

    /**
     * @return mixed
     */
    public function getOldCountry()
    {
        return $this->oldCountry;
    }

    /**
     * @param mixed $oldCountry
     */
    public function setOldCountry($oldCountry): void
    {
        $this->oldCountry = $oldCountry;
    }

    /**
     * @return mixed
     */
    public function getSavedOn()
    {
        return $this->savedOn;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setSavedOn(\DateTime $dateTime)
    {
        $this->savedOn = $dateTime;
    }
}
