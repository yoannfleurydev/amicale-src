<?php

namespace AGIL\HallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilPhoto
 *
 * @ORM\Table(name="agil_photo")
 * @ORM\Entity(repositoryClass="AGIL\HallBundle\Repository\AgilPhotoRepository")
 */
class AgilPhoto
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
     * @ORM\Column(name="photoUrl", type="string", length=255, unique=true)
     */
    private $photoUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="photoUploadDate", type="datetime")
     */
    private $photoUploadDate;

    /**
     * @var string
     *
     * @ORM\Column(name="photoDescription", type="text")
     */
    private $photoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="photoTitle", type="string", length=100)
     */
    private $photoTitle;


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
     * Set photoUrl
     *
     * @param string $photoUrl
     * @return AgilPhoto
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

    /**
     * Get photoUrl
     *
     * @return string 
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * Set photoUploadDate
     *
     * @param \DateTime $photoUploadDate
     * @return AgilPhoto
     */
    public function setPhotoUploadDate($photoUploadDate)
    {
        $this->photoUploadDate = $photoUploadDate;

        return $this;
    }

    /**
     * Get photoUploadDate
     *
     * @return \DateTime 
     */
    public function getPhotoUploadDate()
    {
        return $this->photoUploadDate;
    }

    /**
     * Set photoDescription
     *
     * @param string $photoDescription
     * @return AgilPhoto
     */
    public function setPhotoDescription($photoDescription)
    {
        $this->photoDescription = $photoDescription;

        return $this;
    }

    /**
     * Get photoDescription
     *
     * @return string 
     */
    public function getPhotoDescription()
    {
        return $this->photoDescription;
    }

    /**
     * Set photoTitle
     *
     * @param string $photoTitle
     * @return AgilPhoto
     */
    public function setPhotoTitle($photoTitle)
    {
        $this->photoTitle = $photoTitle;

        return $this;
    }

    /**
     * Get photoTitle
     *
     * @return string 
     */
    public function getPhotoTitle()
    {
        return $this->photoTitle;
    }
}
