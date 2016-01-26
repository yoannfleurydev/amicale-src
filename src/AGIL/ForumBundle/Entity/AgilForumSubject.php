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
     * @ORM\ManyToMany(targetEntity="AGIL\DefaultBundle\Entity\AgilTag")
     * @ORM\JoinTable(name="agil_forum_subject_tags",
     *      joinColumns={@ORM\JoinColumn(name="forumSubjectId", referencedColumnName="forumSubjectId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tagId", referencedColumnName="tagId")}
     *      )
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\DefaultBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="userId")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="AGIL\ForumBundle\Entity\AgilForumCategory")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="forumCategoryId")
     */
    private $category;


    /**
     * @var int
     *
     * @ORM\Column(name="forumSubjectId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $forumSubjectId;

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
     * Get forumSubjectId
     *
     * @return integer 
     */
    public function getForumSubjectId()
    {
        return $this->forumSubjectId;
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

    /**
     * Set user
     *
     * @param \AGIL\DefaultBundle\Entity\AgilUser $user
     * @return AgilForumSubject
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
     * Set category
     *
     * @param \AGIL\ForumBundle\Entity\AgilForumCategory $category
     * @return AgilForumSubject
     */
    public function setCategory(\AGIL\ForumBundle\Entity\AgilForumCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AGIL\ForumBundle\Entity\AgilForumCategory 
     */
    public function getCategory()
    {
        return $this->category;
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
     * @return AgilForumSubject
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
