<?php

namespace AGIL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgilTag
 *
 * @ORM\Table(name="agil_tag")
 * @ORM\Entity(repositoryClass="AGIL\DefaultBundle\Repository\AgilTagRepository")
 */
class AgilTag
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
     * @ORM\Column(name="tagName", type="string", length=20, unique=true)
     */
    private $tagName;


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
}
