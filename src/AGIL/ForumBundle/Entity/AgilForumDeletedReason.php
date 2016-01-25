<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilForumDeletedReason
 *
 * @ORM\Table(name="agil_forum_deleted_reason")
 * @ORM\Entity(repositoryClass="AGIL\ForumBundle\Repository\AgilForumDeletedReasonRepository")
 */
class AgilForumDeletedReason
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
     * @ORM\Column(name="forumDeletedReasonText", type="text")
     */
    private $forumDeletedReasonText;


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
     * Set forumDeletedReasonText
     *
     * @param string $forumDeletedReasonText
     * @return AgilForumDeletedReason
     */
    public function setForumDeletedReasonText($forumDeletedReasonText)
    {
        $this->forumDeletedReasonText = $forumDeletedReasonText;

        return $this;
    }

    /**
     * Get forumDeletedReasonText
     *
     * @return string 
     */
    public function getForumDeletedReasonText()
    {
        return $this->forumDeletedReasonText;
    }
}
