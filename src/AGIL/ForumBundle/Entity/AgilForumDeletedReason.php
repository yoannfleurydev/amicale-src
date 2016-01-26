<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Le texte ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La taille minimale est de {{ limit }} caractères"
     * )
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
