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
     * @ORM\Column(name="forumDeletedReasonId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $forumDeletedReasonId;

    /**
     * @var string
     *
     * @ORM\Column(name="forumDeletedReasonText", type="text")
     */
    private $forumDeletedReasonText;


    /**
     * Get forumDeletedReasonId
     *
     * @return integer 
     */
    public function getForumDeletedReasonId()
    {
        return $this->forumDeletedReasonId;
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
