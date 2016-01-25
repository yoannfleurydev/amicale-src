<?php

namespace AGIL\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilChatTable
 *
 * @ORM\Table(name="agil_chat_table")
 * @ORM\Entity(repositoryClass="AGIL\ChatBundle\Repository\AgilChatTableRepository")
 */
class AgilChatTable
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
     * @ORM\Column(name="chatTableName", type="string", length=50, unique=true)
     */
    private $chatTableName;

    /**
     * @var string
     *
     * @ORM\Column(name="chatTablePassword", type="string", length=255)
     */
    private $chatTablePassword;


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
}
