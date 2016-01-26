<?php

namespace AGIL\HallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="La vidéo doit contenir une url")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
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
     * @Assert\NotBlank(message="La vidéo doit contenir une description")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La taille minimale est de {{ limit }} caractères"
     * )
     */
    private $videoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="videoTitle", type="string", length=100)
     * @Assert\NotBlank(message="La vidéo doit contenir un titre")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
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
