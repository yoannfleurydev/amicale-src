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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="offerTitle", type="string", length=255)
     */
    private $offerTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="offerText", type="text")
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
     */
    private $offerPdfUrl;


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
}
