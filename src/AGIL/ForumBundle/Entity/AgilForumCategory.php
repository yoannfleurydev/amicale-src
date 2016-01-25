<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilForumCategory
 *
 * @ORM\Table(name="agil_forum_category")
 * @ORM\Entity(repositoryClass="AGIL\ForumBundle\Repository\AgilForumCategoryRepository")
 */
class AgilForumCategory
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
     * @ORM\Column(name="forumCategoryName", type="string", length=100, unique=true)
     */
    private $forumCategoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="forumCategoryText", type="string", length=255)
     */
    private $forumCategoryText;


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
     * Set forumCategoryName
     *
     * @param string $forumCategoryName
     * @return AgilForumCategory
     */
    public function setForumCategoryName($forumCategoryName)
    {
        $this->forumCategoryName = $forumCategoryName;

        return $this;
    }

    /**
     * Get forumCategoryName
     *
     * @return string 
     */
    public function getForumCategoryName()
    {
        return $this->forumCategoryName;
    }

    /**
     * Set forumCategoryText
     *
     * @param string $forumCategoryText
     * @return AgilForumCategory
     */
    public function setForumCategoryText($forumCategoryText)
    {
        $this->forumCategoryText = $forumCategoryText;

        return $this;
    }

    /**
     * Get forumCategoryText
     *
     * @return string 
     */
    public function getForumCategoryText()
    {
        return $this->forumCategoryText;
    }
}
