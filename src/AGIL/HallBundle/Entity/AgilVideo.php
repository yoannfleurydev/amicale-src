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
     * @ORM\ManyToOne(targetEntity="AGIL\HallBundle\Entity\AgilEvent")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="eventId")
     */
    private $event;

    /**
     * @var int
     *
     * @ORM\Column(name="videoId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $videoId;

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
     * Get videoId
     *
     * @return integer 
     */
    public function getVideoId()
    {
        return $this->videoId;
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

    /**
     * Set event
     *
     * @param \AGIL\HallBundle\Entity\AgilEvent $event
     * @return AgilVideo
     */
    public function setEvent(\AGIL\HallBundle\Entity\AgilEvent $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AGIL\HallBundle\Entity\AgilEvent 
     */
    public function getEvent()
    {
        return $this->event;
    }
}
