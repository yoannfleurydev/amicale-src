<?php

namespace AGIL\OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilOffer
 *
 * @ORM\Table(name="agil_offer")
 * @ORM\Entity(repositoryClass="AGIL\OfferBundle\Repository\AgilOfferRepository")
 */
class AgilOffer
{

    /**
     * @ORM\ManyToMany(targetEntity="AGIL\DefaultBundle\Entity\AgilTag")
     * @ORM\JoinTable(name="agil_offer_tags",
     *      joinColumns={@ORM\JoinColumn(name="offerId", referencedColumnName="offerId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tagId", referencedColumnName="tagId")}
     *      )
     */
    private $tags;


    /**
     * @ORM\ManyToOne(targetEntity="AGIL\UserBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=true,referencedColumnName="id")
     */
    private $user;


    /**
     * @var int
     *
     * @ORM\Column(name="offerId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $offerId;


    /**
     * @var string
     *
     * @ORM\Column(name="offerTitle", type="string", length=255)
     * @Assert\NotBlank(message="L'offre doit contenir un titre")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $offerTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="offerText", type="text")
     * @Assert\NotBlank(message="L'offre doit contenir une description")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La taille minimale est de {{ limit }} caractères"
     * )
     */
    private $offerText;

    /**
     * @var string
     *
     * @ORM\Column(name="offerType", type="string", length=50, unique=true)
     * @Assert\Choice(choices = {"stage", "emploi"}, message = "Choose a valid choice.")
     */
    private $offerType;

    /**
     * @var string
     *
     * @ORM\Column(name="offerAuthor", type="string", length=100, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 100,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $offerAuthor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="offerPostDate", type="datetime")
     */
    private $offerPostDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="offerExpirationDate", type="datetime")
     */
    private $offerExpirationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="offerPdfUrl", type="string", length=255, nullable=true, unique=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $offerPdfUrl;


    /**
     * Get offerId
     *
     * @return integer 
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * Set offerTitle
     *
     * @param string $offerTitle
     * @return AgilOffer
     */
    public function setOfferTitle($offerTitle)
    {
        $this->offerTitle = $offerTitle;

        return $this;
    }

    /**
     * Get offerTitle
     *
     * @return string 
     */
    public function getOfferTitle()
    {
        return $this->offerTitle;
    }

    /**
     * Set offerText
     *
     * @param string $offerText
     * @return AgilOffer
     */
    public function setOfferText($offerText)
    {
        $this->offerText = $offerText;

        return $this;
    }

    /**
     * Get offerText
     *
     * @return string 
     */
    public function getOfferText()
    {
        return $this->offerText;
    }

    /**
     * Set offerType
     *
     * @param string $offerType
     * @return AgilOffer
     */
    public function setOfferType($offerType)
    {
        $this->offerType = $offerType;

        return $this;
    }

    /**
     * Get offerType
     *
     * @return string 
     */
    public function getOfferType()
    {
        return $this->offerType;
    }

    /**
     * Set offerAuthor
     *
     * @param string $offerAuthor
     * @return AgilOffer
     */
    public function setOfferAuthor($offerAuthor)
    {
        $this->offerAuthor = $offerAuthor;

        return $this;
    }

    /**
     * Get offerAuthor
     *
     * @return string 
     */
    public function getOfferAuthor()
    {
        return $this->offerAuthor;
    }

    /**
     * Set offerPostDate
     *
     * @param \DateTime $offerPostDate
     * @return AgilOffer
     */
    public function setOfferPostDate($offerPostDate)
    {
        $this->offerPostDate = $offerPostDate;

        return $this;
    }

    /**
     * Get offerPostDate
     *
     * @return \DateTime 
     */
    public function getOfferPostDate()
    {
        return $this->offerPostDate;
    }

    /**
     * Set offerExpirationDate
     *
     * @param \DateTime $offerExpirationDate
     * @return AgilOffer
     */
    public function setOfferExpirationDate($offerExpirationDate)
    {
        $this->offerExpirationDate = $offerExpirationDate;

        return $this;
    }

    /**
     * Get offerExpirationDate
     *
     * @return \DateTime 
     */
    public function getOfferExpirationDate()
    {
        return $this->offerExpirationDate;
    }

    /**
     * Set offerPdfUrl
     *
     * @param string $offerPdfUrl
     * @return AgilOffer
     */
    public function setOfferPdfUrl($offerPdfUrl)
    {
        $this->offerPdfUrl = $offerPdfUrl;

        return $this;
    }

    /**
     * Get offerPdfUrl
     *
     * @return string 
     */
    public function getOfferPdfUrl()
    {
        return $this->offerPdfUrl;
    }

   

    /**
     * Set user
     *
     * @param \AGIL\UserBundle\Entity\AgilUser $user
     * @return AgilOffer
     */
    public function setUser(\AGIL\UserBundle\Entity\AgilUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AGIL\UserBundle\Entity\AgilUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $date = new \DateTime();
        $this->offerPostDate = $date;
        $this->offerExpirationDate = $date->add(new \DateInterval("P3M"));
    }

    /**
     * Add tags
     *
     * @param \AGIL\DefaultBundle\Entity\AgilTag $tags
     * @return AgilOffer
     */
    public function addTag(\AGIL\DefaultBundle\Entity\AgilTag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \AGIL\DefaultBundle\Entity\AgilTag $tags
     */
    public function removeTag(\AGIL\DefaultBundle\Entity\AgilTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }


    /**
     * Fonction qui test si une offre est expirée ou non
     * @return bool
     */
    public function isExpired(){
        return ($this->offerExpirationDate > $this->offerPostDate);
    }
}
