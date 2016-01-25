<?php

namespace AGIL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * AgilUser
 *
 * @ORM\Table(name="agil_user")
 * @ORM\Entity(repositoryClass="AGIL\DefaultBundle\Repository\AgilUserRepository")
 */
class AgilUser extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50)
     */
    protected $firstName;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signupDate", type="datetime")
     */
    protected $signupDate;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdayDate", type="datetime")
     */
    protected $birthdayDate;


    /**
     * @var string
     *
     * @ORM\Column(name="cvUrl", type="string", length=255)
     */
    protected $cvUrl;


    /**
     * @var string
     *
     * @ORM\Column(name="profilePictureUrl", type="string", length=255)
     */
    protected $profilePictureUrl;





    /**
     * Set lastName
     *
     * @param string $lastName
     * @return AgilUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return AgilUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set signupDate
     *
     * @param \DateTime $signupDate
     * @return AgilUser
     */
    public function setSignupDate($signupDate)
    {
        $this->signupDate = $signupDate;

        return $this;
    }

    /**
     * Get signupDate
     *
     * @return \DateTime
     */
    public function getSignupDate()
    {
        return $this->signupDate;
    }

    /**
     * Set birthdayDate
     *
     * @param \DateTime $birthdayDate
     * @return AgilUser
     */
    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * Get birthdayDate
     *
     * @return \DateTime
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * Set cvUrl
     *
     * @param string $cvUrl
     * @return AgilUser
     */
    public function setCvUrl($cvUrl)
    {
        $this->cvUrl = $cvUrl;

        return $this;
    }

    /**
     * Get cvUrl
     *
     * @return string
     */
    public function getCvUrl()
    {
        return $this->cvUrl;
    }

    /**
     * Set profilePictureUrl
     *
     * @param string $profilePictureUrl
     * @return AgilUser
     */
    public function setProfilePictureUrl($profilePictureUrl)
    {
        $this->profilePictureUrl = $profilePictureUrl;

        return $this;
    }

    /**
     * Get profilePictureUrl
     *
     * @return string
     */
    public function getProfilePictureUrl()
    {
        return $this->profilePictureUrl;
    }




}
