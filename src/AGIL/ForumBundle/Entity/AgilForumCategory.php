<?php

namespace AGIL\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="forumCategoryId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $forumCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="forumCategoryName", type="string", length=100, unique=true)
     * @Assert\NotBlank(message="Le nom d'une catégorie ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $forumCategoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="forumCategoryText", type="string", length=255)
     * @Assert\NotBlank(message="La description ne peut être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $forumCategoryText;


    /**
     * Get forumCategoryId
     *
     * @return integer 
     */
    public function getForumCategoryId()
    {
        return $this->forumCategoryId;
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
