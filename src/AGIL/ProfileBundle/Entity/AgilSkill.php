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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="skillLevel", type="integer")
     */
    private $skillLevel;


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
}
