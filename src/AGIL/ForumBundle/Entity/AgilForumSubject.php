<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilForumSubject
 *
 * @ORM\Table(name="agil_forum_subject")
 * @ORM\Entity(repositoryClass="AGIL\ForumBundle\Repository\AgilForumSubjectRepository")
 */
class AgilForumSubject
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
     * @ORM\Column(name="forumSubjectTitle", type="string", length=255, unique=true)
     */
    private $forumSubjectTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="forumSubjectPostDate", type="datetime")
     */
    private $forumSubjectPostDate;

    /**
     * @var string
     *
     * @ORM\Column(name="forumSubjectDescription", type="text")
     */
    private $forumSubjectDescription;


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
     * Set forumSubjectTitle
     *
     * @param string $forumSubjectTitle
     * @return AgilForumSubject
     */
    public function setForumSubjectTitle($forumSubjectTitle)
    {
        $this->forumSubjectTitle = $forumSubjectTitle;

        return $this;
    }

    /**
     * Get forumSubjectTitle
     *
     * @return string 
     */
    public function getForumSubjectTitle()
    {
        return $this->forumSubjectTitle;
    }

    /**
     * Set forumSubjectPostDate
     *
     * @param \DateTime $forumSubjectPostDate
     * @return AgilForumSubject
     */
    public function setForumSubjectPostDate($forumSubjectPostDate)
    {
        $this->forumSubjectPostDate = $forumSubjectPostDate;

        return $this;
    }

    /**
     * Get forumSubjectPostDate
     *
     * @return \DateTime 
     */
    public function getForumSubjectPostDate()
    {
        return $this->forumSubjectPostDate;
    }

    /**
     * Set forumSubjectDescription
     *
     * @param string $forumSubjectDescription
     * @return AgilForumSubject
     */
    public function setForumSubjectDescription($forumSubjectDescription)
    {
        $this->forumSubjectDescription = $forumSubjectDescription;

        return $this;
    }

    /**
     * Get forumSubjectDescription
     *
     * @return string 
     */
    public function getForumSubjectDescription()
    {
        return $this->forumSubjectDescription;
    }
}
