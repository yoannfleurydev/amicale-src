<?php

namespace AGIL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilTag
 *
 * @ORM\Table(name="agil_tag")
 * @ORM\Entity(repositoryClass="AGIL\DefaultBundle\Repository\AgilTagRepository")
 */
class AgilTag
{

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\ProfileBundle\Entity\AgilProfileSkillsCategory")
     * @ORM\JoinColumn(nullable=true,referencedColumnName="profileSkillsCategoryId")
     */
    private $skillCategory;

    /**
     * @var int
     *
     * @ORM\Column(name="tagId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $tagId;

    /**
     * @var string
     *
     * @ORM\Column(name="tagName", type="string", length=20, unique=true)
     * @Assert\NotBlank(message="Le nom d'un tag ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $tagName;


    /**
     * @var string
     *
     * @ORM\Column(name="tagColor", type="string", length=30)
     * @Assert\NotBlank(message="La couleur d'un tag doit être spécifiée")
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $tagColor;

    /**
     * AgilTag constructor.
     * @param $name
     * @param $color
     * @param $skillCategory
     */
    public function __construct($name,$color="primary-blue",$skillCategory){
        $this->tagName = $name;
        $this->tagColor = $color;

        if($skillCategory != NULL){
            $this->skillCategory = $skillCategory;
        }
    }




    /**
     * Get tagId
     *
     * @return integer 
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * Set tagName
     *
     * @param string $tagName
     * @return AgilTag
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;

        return $this;
    }

    /**
     * Get tagName
     *
     * @return string 
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * Set skillCategory
     *
     * @param \AGIL\ProfileBundle\Entity\AgilProfileSkillsCategory $skillCategory
     * @return AgilTag
     */
    public function setSkillCategory(\AGIL\ProfileBundle\Entity\AgilProfileSkillsCategory $skillCategory = null)
    {
        $this->skillCategory = $skillCategory;

        return $this;
    }

    /**
     * Get skillCategory
     *
     * @return \AGIL\ProfileBundle\Entity\AgilProfileSkillsCategory 
     */
    public function getSkillCategory()
    {
        return $this->skillCategory;
    }

    /**
     * Set tagColor
     *
     * @param string $tagColor
     * @return AgilTag
     */
    public function setTagColor($tagColor)
    {
        $this->tagColor = $tagColor;

        return $this;
    }

    /**
     * Get tagColor
     *
     * @return string 
     */
    public function getTagColor()
    {
        return $this->tagColor;
    }
}
