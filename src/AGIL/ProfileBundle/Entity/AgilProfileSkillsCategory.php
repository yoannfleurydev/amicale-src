<?php

namespace AGIL\ProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilProfileSkillsCategory
 *
 * @ORM\Table(name="agil_profile_skills_category")
 * @ORM\Entity(repositoryClass="AGIL\ProfileBundle\Repository\AgilProfileSkillsCategoryRepository")
 */
class AgilProfileSkillsCategory
{
    /**
     * @var int
     *
     * @ORM\Column(name="profileSkillsCategoryId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $profileSkillsCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="profileSkillsCategoryName", type="string", length=30, unique=true)
     */
    private $profileSkillsCategoryName;


    /**
     * Get profileSkillsCategoryId
     *
     * @return integer 
     */
    public function getProfileSkillsCategoryId()
    {
        return $this->profileSkillsCategoryId;
    }

    /**
     * Set profileSkillsCategoryName
     *
     * @param string $profileSkillsCategoryName
     * @return AgilProfileSkillsCategory
     */
    public function setProfileSkillsCategoryName($profileSkillsCategoryName)
    {
        $this->profileSkillsCategoryName = $profileSkillsCategoryName;

        return $this;
    }

    /**
     * Get profileSkillsCategoryName
     *
     * @return string 
     */
    public function getProfileSkillsCategoryName()
    {
        return $this->profileSkillsCategoryName;
    }
}
