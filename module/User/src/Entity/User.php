<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email_idx", columns={"email"})})
 * @ORM\Entity(repositoryClass="User\Entity\Repositories\User")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=512, nullable=false)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=256, nullable=false)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd_reset_token", type="string", length=32, nullable=true)
     */
    private $pwdResetToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pwd_reset_token_creation_date", type="datetime", nullable=true)
     */
    private $pwdResetTokenCreationDate;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return User
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set pwdResetToken
     *
     * @param string $pwdResetToken
     *
     * @return User
     */
    public function setPwdResetToken($pwdResetToken)
    {
        $this->pwdResetToken = $pwdResetToken;

        return $this;
    }

    /**
     * Get pwdResetToken
     *
     * @return string
     */
    public function getPwdResetToken()
    {
        return $this->pwdResetToken;
    }

    /**
     * Set pwdResetTokenCreationDate
     *
     * @param \DateTime $pwdResetTokenCreationDate
     *
     * @return User
     */
    public function setPwdResetTokenCreationDate($pwdResetTokenCreationDate)
    {
        $this->pwdResetTokenCreationDate = $pwdResetTokenCreationDate;

        return $this;
    }

    /**
     * Get pwdResetTokenCreationDate
     *
     * @return \DateTime
     */
    public function getPwdResetTokenCreationDate()
    {
        return $this->pwdResetTokenCreationDate;
    }
}
