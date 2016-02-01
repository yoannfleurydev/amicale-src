<?php

namespace AGIL\HallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilEvent
 *
 * @ORM\Table(name="agil_event")
 * @ORM\Entity(repositoryClass="AGIL\HallBundle\Repository\AgilEventRepository")
 */
class AgilEvent
{

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\UserBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id")
     */
    private $user;


    /**
     * @ORM\ManyToMany(targetEntity="AGIL\DefaultBundle\Entity\AgilTag")
     * @ORM\JoinTable(name="agil_event_tags",
     *      joinColumns={@ORM\JoinColumn(name="eventId", referencedColumnName="eventId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tagId", referencedColumnName="tagId")}
     *      )
     */
    private $tags;


    /**
     * @var int
     *
     * @ORM\Column(name="eventId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(name="eventTitle", type="string", length=255)
     * @Assert\NotBlank(message="Le titre ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
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
     * @Assert\NotBlank(message="La date de l'évènement doit être spécifiée")
     */
    private $eventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="eventText", type="text")
     * @Assert\NotBlank(message="La description de l'évènement ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La taille minimale est de {{ limit }} caractères"
     * )
     */
    private $eventText;


    /**
     * Get eventId
     *
     * @return integer 
     */
    public function getEventId()
    {
        return $this->eventId;
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

    /**
     * Set user
     *
     * @param \AGIL\DefaultBundle\Entity\AgilUser $user
     * @return AgilEvent
     */
    public function setUser(\AGIL\DefaultBundle\Entity\AgilUser $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AGIL\DefaultBundle\Entity\AgilUser 
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
        $this->eventPostDate = new \DateTime();
    }

    /**
     * Add tags
     *
     * @param \AGIL\DefaultBundle\Entity\AgilTag $tags
     * @return AgilEvent
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
}
