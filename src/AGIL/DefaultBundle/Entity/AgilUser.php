<?php

namespace AGIL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilUser
 *
 * @ORM\Table(name="agil_user")
 * @ORM\Entity(repositoryClass="AGIL\DefaultBundle\Repository\AgilUserRepository")
 */
class AgilUser extends BaseUser
{

    /**
     * @ORM\ManyToMany(targetEntity="AGIL\DefaultBundle\Entity\AgilMailingList")
     * @ORM\JoinTable(name="agil_users_mailing_list",
     *      joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="userId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mailingListId", referencedColumnName="mailingListId")}
     *      )
     */
    private $mailingLists;


    /**
     * @ORM\Column(name="userId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $userId;


    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 50,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 50,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
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
     * @ORM\Column(name="birthdayDate", type="datetime", nullable=true)
     */
    protected $birthdayDate;


    /**
     * @var string
     *
     * @ORM\Column(name="cvUrl", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    protected $cvUrl;


    /**
     * @var string
     *
     * @ORM\Column(name="profilePictureUrl", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
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


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->mailingLists = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mailingLists
     *
     * @param \AGIL\DefaultBundle\Entity\AgilMailingList $mailingLists
     * @return AgilUser
     */
    public function addMailingList(\AGIL\DefaultBundle\Entity\AgilMailingList $mailingLists)
    {
        $this->mailingLists[] = $mailingLists;

        return $this;
    }

    /**
     * Remove mailingLists
     *
     * @param \AGIL\DefaultBundle\Entity\AgilMailingList $mailingLists
     */
    public function removeMailingList(\AGIL\DefaultBundle\Entity\AgilMailingList $mailingLists)
    {
        $this->mailingLists->removeElement($mailingLists);
    }

    /**
     * Get mailingLists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMailingLists()
    {
        return $this->mailingLists;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
