<?php

namespace AGIL\HallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilEvent
 *
 * @ORM\Table(name="agil_event")
 * @ORM\Entity(repositoryClass="AGIL\HallBundle\Repository\AgilEventRepository")
 */
class AgilEvent
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
     * @ORM\Column(name="eventTitle", type="string", length=255)
     */
    private $eventTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventPostDate", type="datetime")
     */
    private $eventPostDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventDate", type="datetime")
     */
    private $eventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="eventText", type="text")
     */
    private $eventText;


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
     * Set eventTitle
     *
     * @param string $eventTitle
     * @return AgilEvent
     */
    public function setEventTitle($eventTitle)
    {
        $this->eventTitle = $eventTitle;

        return $this;
    }

    /**
     * Get eventTitle
     *
     * @return string 
     */
    public function getEventTitle()
    {
        return $this->eventTitle;
    }

    /**
     * Set eventPostDate
     *
     * @param \DateTime $eventPostDate
     * @return AgilEvent
     */
    public function setEventPostDate($eventPostDate)
    {
        $this->eventPostDate = $eventPostDate;

        return $this;
    }

    /**
     * Get eventPostDate
     *
     * @return \DateTime 
     */
    public function getEventPostDate()
    {
        return $this->eventPostDate;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return AgilEvent
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set eventText
     *
     * @param string $eventText
     * @return AgilEvent
     */
    public function setEventText($eventText)
    {
        $this->eventText = $eventText;

        return $this;
    }

    /**
     * Get eventText
     *
     * @return string 
     */
    public function getEventText()
    {
        return $this->eventText;
    }
}
