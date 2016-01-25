<?php

namespace AGIL\ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="AGIL\DefaultBundle\Entity\AgilUser")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="userId")
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
     */
    private $skillLevel;


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
     * @param \AGIL\DefaultBundle\Entity\AgilUser $user
     * @return AgilSkill
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
