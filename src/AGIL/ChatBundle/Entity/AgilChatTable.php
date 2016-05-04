<?php

namespace AGIL\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilChatTable
 *
 * @ORM\Table(name="agil_chat_table")
 * @ORM\Entity(repositoryClass="AGIL\ChatBundle\Repository\AgilChatTableRepository")
 */
class AgilChatTable
{

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\UserBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     */
    private $user;


    /**
     * @ORM\ManyToMany(targetEntity="AGIL\DefaultBundle\Entity\AgilTag")
     * @ORM\JoinTable(name="agil_chat_table_tags",
     *      joinColumns={@ORM\JoinColumn(name="chatTableId", referencedColumnName="chatTableId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tagId", referencedColumnName="tagId")}
     *      )
     */
    private $tags;

    /**
     * @var int
     *
     * @ORM\Column(name="chatTableId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
        private $chatTableId;

    /**
     * @var string
     *
     * @ORM\Column(name="chatTableName", type="string", length=50, unique=true)
     * @Assert\NotBlank(message="Le nom d'une table ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $chatTableName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="chatTableDate", type="datetime")
     */
    private $chatTableDate;



    /**
     * @var string
     *
     * @ORM\Column(name="chatTablePassword", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 0,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $chatTablePassword;


    /**
     * Get chatTableId
     *
     * @return integer 
     */
    public function getChatTableId()
    {
        return $this->chatTableId;
    }

    /**
     * Set chatTableName
     *
     * @param string $chatTableName
     * @return AgilChatTable
     */
    public function setChatTableName($chatTableName)
    {
        $this->chatTableName = $chatTableName;

        return $this;
    }

    /**
     * Get chatTableName
     *
     * @return string 
     */
    public function getChatTableName()
    {
        return $this->chatTableName;
    }

    /**
     * Set chatTablePassword
     *
     * @param string $chatTablePassword
     * @return AgilChatTable
     */
    public function setChatTablePassword($chatTablePassword)
    {
        $this->chatTablePassword = $chatTablePassword;

        return $this;
    }

    /**
     * Get chatTablePassword
     *
     * @return string 
     */
    public function getChatTablePassword()
    {
        return $this->chatTablePassword;
    }

    /**
     * Set user
     *
     * @param \AGIL\UserBundle\Entity\AgilUser $user
     * @return AgilChatTable
     */
    public function setUser(\AGIL\UserBundle\Entity\AgilUser $user)
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
    }

    /**
     * Add tags
     *
     * @param \AGIL\DefaultBundle\Entity\AgilTag $tags
     * @return AgilChatTable
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
     * Set chatTableDate
     *
     * @param \DateTime $chatTableDate
     *
     * @return AgilChatTable
     */
    public function setChatTableDate($chatTableDate)
    {
        $this->chatTableDate = $chatTableDate;

        return $this;
    }
    /**
     * Get chatTableDate
     *
     * @return \DateTime
     */
    public function getChatTableDate()
    {
        return $this->chatTableDate;
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
