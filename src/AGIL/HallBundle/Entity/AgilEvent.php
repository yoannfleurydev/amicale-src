<?php

namespace AGIL\HallBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\JoinColumn(nullable=true,referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AGIL\HallBundle\Entity\AgilPhoto", mappedBy="event")
     * @ORM\JoinColumn(nullable=true,referencedColumnName="photoId")
     */
    private $photos;
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
     * @var \DateTime
     *
     * @ORM\Column(name="eventDateEnd", type="datetime", nullable=true)
     * @Assert\NotBlank(message="La date de fin l'évènement doit être spécifiée")
     */
    private $eventDateEnd;

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
     * AgilEvent constructor.
     */
    public function __construct(){
        // Date de publication
        $this->eventDate = new \DateTime();
        $this->eventDateEnd = new \DateTime();
        $this->eventPostDate = new \DateTime();
        $this->photos = new ArrayCollection();
    }

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
     * Get eventDateEnd
     *
     * @return \DateTime 
     */
    public function getEventDateEnd()
    {
        return $this->eventDateEnd;
    }

    /**
     * Set eventDateEnd
     *
     * @param \DateTime $eventDateEnd
     * @return AgilEvent
     */
    public function setEventDateEnd($eventDateEnd)
    {
        $this->eventDateEnd = $eventDateEnd;

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
     * @param \AGIL\UserBundle\Entity\AgilUser $user
     * @return AgilEvent
     */
    public function setUser(\AGIL\UserBundle\Entity\AgilUser $user)
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

    public function removeTags()
    {
        foreach($this->tags as $tag) {
            $this->tags->removeElement($tag);
        }
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
     * Set tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function setTags($collection)
    {
        $this->tags = $collection;
    }

    /**
     * @param AgilPhoto $photo
     * @return $this
     */
    public function addPhoto(AgilPhoto $photo)
    {
        $this->photos[] = $photo;

        $photo->setEvent($this);

        return $this;
    }

    /**
     * @param AgilPhoto $photo
     */
    public function removePhoto(AgilPhoto $photo)
    {
        $this->photos->removeElement($photo);
    }

    public function setImages(ArrayCollection $photos)
    {
        foreach ($photos as $photo) {
            $photo->setEvent($this);
        }

        $this->photos = $photos;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
