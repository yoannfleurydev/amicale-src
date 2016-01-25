<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilForumAnswer
 *
 * @ORM\Table(name="agil_forum_answer")
 * @ORM\Entity(repositoryClass="AGIL\ForumBundle\Repository\AgilForumAnswerRepository")
 */
class AgilForumAnswer
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
     * @ORM\Column(name="forumAnswerText", type="text")
     */
    private $forumAnswerText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="forumAnswerPostDate", type="datetime")
     */
    private $forumAnswerPostDate;


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
     * Set forumAnswerText
     *
     * @param string $forumAnswerText
     * @return AgilForumAnswer
     */
    public function setForumAnswerText($forumAnswerText)
    {
        $this->forumAnswerText = $forumAnswerText;

        return $this;
    }

    /**
     * Get forumAnswerText
     *
     * @return string 
     */
    public function getForumAnswerText()
    {
        return $this->forumAnswerText;
    }

    /**
     * Set forumAnswerPostDate
     *
     * @param \DateTime $forumAnswerPostDate
     * @return AgilForumAnswer
     */
    public function setForumAnswerPostDate($forumAnswerPostDate)
    {
        $this->forumAnswerPostDate = $forumAnswerPostDate;

        return $this;
    }

    /**
     * Get forumAnswerPostDate
     *
     * @return \DateTime 
     */
    public function getForumAnswerPostDate()
    {
        return $this->forumAnswerPostDate;
    }
}
