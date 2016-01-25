<?php

namespace AGIL\HallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilVideo
 *
 * @ORM\Table(name="agil_video")
 * @ORM\Entity(repositoryClass="AGIL\HallBundle\Repository\AgilVideoRepository")
 */
class AgilVideo
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
     * @ORM\Column(name="videoUrl", type="string", length=255, unique=true)
     */
    private $videoUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="videoUploadDate", type="datetime")
     */
    private $videoUploadDate;

    /**
     * @var string
     *
     * @ORM\Column(name="videoDescription", type="text")
     */
    private $videoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="videoTitle", type="string", length=100)
     */
    private $videoTitle;


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
     * Set videoUrl
     *
     * @param string $videoUrl
     * @return AgilVideo
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * Get videoUrl
     *
     * @return string 
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * Set videoUploadDate
     *
     * @param \DateTime $videoUploadDate
     * @return AgilVideo
     */
    public function setVideoUploadDate($videoUploadDate)
    {
        $this->videoUploadDate = $videoUploadDate;

        return $this;
    }

    /**
     * Get videoUploadDate
     *
     * @return \DateTime 
     */
    public function getVideoUploadDate()
    {
        return $this->videoUploadDate;
    }

    /**
     * Set videoDescription
     *
     * @param string $videoDescription
     * @return AgilVideo
     */
    public function setVideoDescription($videoDescription)
    {
        $this->videoDescription = $videoDescription;

        return $this;
    }

    /**
     * Get videoDescription
     *
     * @return string 
     */
    public function getVideoDescription()
    {
        return $this->videoDescription;
    }

    /**
     * Set videoTitle
     *
     * @param string $videoTitle
     * @return AgilVideo
     */
    public function setVideoTitle($videoTitle)
    {
        $this->videoTitle = $videoTitle;

        return $this;
    }

    /**
     * Get videoTitle
     *
     * @return string 
     */
    public function getVideoTitle()
    {
        return $this->videoTitle;
    }
}
