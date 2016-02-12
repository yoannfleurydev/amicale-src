<?php
namespace AGIL\UserBundle\Entity;
use AGIL\DefaultBundle\Entity\AgilMailingList;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * AgilUser
 *
 * @ORM\Table(name="agil_user")
 * @ORM\Entity(repositoryClass="AGIL\UserBundle\Repository\AgilUserRepository")
 */
class AgilUser extends BaseUser
{
    /**
     * @ORM\ManyToMany(targetEntity="AGIL\DefaultBundle\Entity\AgilMailingList")
     * @ORM\JoinTable(name="agil_users_mailing_list",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mailingListId", referencedColumnName="mailingListId")}
     *      )
     */
    protected $mailingLists;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="userLastName", type="string", length=50, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 50,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    protected $userLastName;
    /**
     * @var string
     *
     * @ORM\Column(name="userFirstName", type="string", length=50, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 50,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    protected $userFirstName;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="userSignupDate", type="datetime")
     */
    protected $userSignupDate;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="userBirthdayDate", type="datetime", nullable=true)
     */
    protected $userBirthdayDate;
    /**
     * @var string
     *
     * @ORM\Column(name="userCVUrl", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    protected $userCVUrl;
    /**
     * @ORM\Column(name="userCVUrlVisibility", type="boolean")
     */
    protected $userCVUrlVisibility = true;
    /**
     * @var string
     *
     * @ORM\Column(name="userProfilePictureUrl", type="string", length=255, nullable=true)
     *
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png", "image/bmp" })
     */
    protected $userProfilePictureUrl;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->mailingLists = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userSignupDate = new \Datetime();
        $this->userProfilePictureUrl = 'default.jpg';
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
        return $this->id;
    }

    /**
     * Set userLastName
     *
     * @param string $userLastName
     * @return AgilUser
     */
    public function setUserLastName($userLastName)
    {
        $this->userLastName = $userLastName;
        return $this;
    }
    /**
     * Get userLastName
     *
     * @return string
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }
    /**
     * Set userFirstName
     *
     * @param string $userFirstName
     * @return AgilUser
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;
        return $this;
    }
    /**
     * Get userFirstName
     *
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }
    /**
     * Set userSignupDate
     *
     * @param \DateTime $userSignupDate
     * @return AgilUser
     */
    public function setUserSignupDate($userSignupDate)
    {
        $this->userSignupDate = $userSignupDate;
        return $this;
    }
    /**
     * Get userSignupDate
     *
     * @return \DateTime
     */
    public function getUserSignupDate()
    {
        return $this->userSignupDate;
    }
    /**
     * Set userBirthdayDate
     *
     * @param \DateTime $userBirthdayDate
     * @return AgilUser
     */
    public function setUserBirthdayDate($userBirthdayDate)
    {
        $this->userBirthdayDate = $userBirthdayDate;
        return $this;
    }
    /**
     * Get userBirthdayDate
     *
     * @return \DateTime
     */
    public function getUserBirthdayDate()
    {
        return $this->userBirthdayDate;
    }
    /**
     * Set userCVUrl
     *
     * @param string $userCVUrl
     * @return AgilUser
     */
    public function setUserCVUrl($userCVUrl)
    {
        $this->userCVUrl = $userCVUrl;
        return $this;
    }
    /**
     * Get userCVUrl
     *
     * @return string
     */
    public function getUserCVUrl()
    {
        return $this->userCVUrl;
    }
    /**
     * Set userProfilePictureUrl
     *
     * @param string $userProfilePictureUrl
     * @return AgilUser
     */
    public function setUserProfilePictureUrl($userProfilePictureUrl)
    {
        $this->userProfilePictureUrl = $userProfilePictureUrl;
        return $this;
    }
    /**
     * Get userProfilePictureUrl
     *
     * @return string
     */
    public function getUserProfilePictureUrl()
    {
        return $this->userProfilePictureUrl;
    }

    /**
     * Set userCVUrlVisibility
     *
     * @param boolean $userCVUrlVisibility
     * @return AgilUser
     */
    public function setUserCVUrlVisibility($userCVUrlVisibility)
    {
        $this->userCVUrlVisibility = $userCVUrlVisibility;

        return $this;
    }

    /**
     * Get userCVUrlVisibility
     *
     * @return boolean 
     */
    public function getUserCVUrlVisibility()
    {
        return $this->userCVUrlVisibility;
    }
}
