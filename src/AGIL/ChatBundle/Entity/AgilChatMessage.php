<?php

namespace AGIL\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilChatMessage
 *
 * @ORM\Table(name="agil_chat_message")
 * @ORM\Entity(repositoryClass="AGIL\ChatBundle\Repository\AgilChatMessageRepository")
 */
class AgilChatMessage
{
    /**
     * @var int
     *
     * @ORM\Column(name="chatMessageId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $chatMessageId;

    /**
     * @var string
     *
     * @ORM\Column(name="chatMessageText", type="text", nullable=true)
     */
    private $chatMessageText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="chatMessageDate", type="datetime")
     */
    private $chatMessageDate;

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\UserBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\ChatBundle\Entity\AgilChatTable")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="chatTableId",onDelete="CASCADE")
     */
    private $table;

    public function __construct($user,$table,$text,$date)
    {
        $this->user = $user;
        $this->table = $table;
        $this->chatMessageText = $text;
        $this->chatMessageDate = $date;
    }

    /**
     * Get chatMessageId
     *
     * @return int
     */
    public function getChatMessageId()
    {
        return $this->chatMessageId;
    }

    /**
     * Set chatMessageText
     *
     * @param string $chatMessageText
     *
     * @return AgilChatMessage
     */
    public function setChatMessageText($chatMessageText)
    {
        $this->chatMessageText = $chatMessageText;

        return $this;
    }

    /**
     * Get chatMessageText
     *
     * @return string
     */
    public function getChatMessageText()
    {
        return $this->chatMessageText;
    }

    /**
     * Set chatMessageDat
     *
     * @param \DateTime $chatMessageDat
     *
     * @return AgilChatMessage
     */
    public function setChatMessageDate($chatMessageDat)
    {
        $this->chatMessageDat = $chatMessageDate;

        return $this;
    }

    /**
     * Get chatMessageDat
     *
     * @return \DateTime
     */
    public function getChatMessageDate()
    {
        return $this->chatMessageDate;
    }

    /**
     * Set user
     *
     * @param \AGIL\UserBundle\Entity\AgilUser $user
     * @return AgilForumAnswer
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
     * Set table
     *
     * @param \AGIL\ChatBundle\Entity\AgilChatTable $table
     * @return AgilChatTable
     */
    public function setTable(\AGIL\ChatBundle\Entity\AgilChatTable $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \AGIL\ChatBundle\Entity\AgilChatTable
     */
    public function getTable()
    {
        return $this->table;
    }
}

