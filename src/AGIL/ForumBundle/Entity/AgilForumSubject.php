<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     *      joinColumns={@ORM\JoinColumn(name="forumSubjectId", referencedColumnName="forumSubjectId", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tagId", referencedColumnName="tagId", onDelete="cascade")}
     *      )
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\UserBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="AGIL\ForumBundle\Entity\AgilForumCategory")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="forumCategoryId",onDelete="CASCADE")
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
     * @ORM\Column(name="forumSubjectTitle", type="string", length=255)
     * @Assert\NotBlank(message="Le titre ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
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
     * @Assert\NotBlank(message="La description ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La taille minimale est de {{ limit }} caractères"
     * )
     */
    private $forumSubjectDescription;


    /**
     * @var boolean
     *
     * @ORM\Column(name="forumSubjectIsResolved", type="boolean")
     */
    private $forumSubjectIsResolved;


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
     * @param \AGIL\UserBundle\Entity\AgilUser $user
     * @return AgilForumSubject
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
     * AgilForumSubject constructor.
     * @param $user
     * @param $category
     * @param $title
     * @param $desc
     * @param bool|false $isResolved
     */
    public function __construct($user,$category,$title,$desc,$isResolved=false)
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->forumSubjectPostDate = new \DateTime();
        $this->user = $user;
        $this->category = $category;
        $this->forumSubjectTitle = $title;
        $this->forumSubjectDescription = $desc;
        $this->forumSubjectIsResolved = $isResolved;
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
     * Set forumSubjectIsResolved
     *
     * @param boolean $forumSubjectIsResolved
     * @return AgilForumSubject
     */
    public function setForumSubjectIsResolved($forumSubjectIsResolved)
    {
        $this->forumSubjectIsResolved = $forumSubjectIsResolved;

        return $this;
    }

    /**
     * Get forumSubjectIsResolved
     *
     * @return boolean 
     */
    public function getForumSubjectIsResolved()
    {
        return $this->forumSubjectIsResolved;
    }
}
