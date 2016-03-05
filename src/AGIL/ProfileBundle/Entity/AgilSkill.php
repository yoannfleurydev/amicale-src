<?php

namespace AGIL\ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilSkill
 *
 * @ORM\Table(name="agil_skill")
 * @ORM\Entity(repositoryClass="AGIL\ProfileBundle\Repository\AgilSkillRepository")
 */
class AgilSkill
{

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\DefaultBundle\Entity\AgilTag")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="tagId")
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity="AGIL\UserBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="skillId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $skillId;

    /**
     * @var int
     *
     * @ORM\Column(name="skillLevel", type="integer")
     * @Assert\NotBlank(message="Le niveau /10 doit être spécifié")
     * @Assert\Range(
     *      min = 0,
     *      max = 10
     * )
     */
    private $skillLevel;


    /**
     * AgilSkill constructor.
     * @param $tag
     * @param $user
     * @param $skillLevel
     */
    public function __construct($tag,$user,$skillLevel = 0){
        $this->tag = $tag;
        $this->user = $user;
        $this->skillLevel = $skillLevel;
    }


    /**
     * Get skillId
     *
     * @return integer 
     */
    public function getSkillId()
    {
        return $this->skillId;
    }

    /**
     * Set skillLevel
     *
     * @param integer $skillLevel
     * @return AgilSkill
     */
    public function setSkillLevel($skillLevel)
    {
        $this->skillLevel = $skillLevel;

        return $this;
    }

    /**
     * Get skillLevel
     *
     * @return integer 
     */
    public function getSkillLevel()
    {
        return $this->skillLevel;
    }

    /**
     * Set user
     *
     * @param \AGIL\UserBundle\Entity\AgilUser $user
     * @return AgilSkill
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
     * Set tag
     *
     * @param \AGIL\DefaultBundle\Entity\AgilTag $tag
     * @return AgilSkill
     */
    public function setTag(\AGIL\DefaultBundle\Entity\AgilTag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \AGIL\DefaultBundle\Entity\AgilTag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
