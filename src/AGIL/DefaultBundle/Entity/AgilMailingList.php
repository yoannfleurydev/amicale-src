<?php

namespace AGIL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgilMailingList
 *
 * @ORM\Table(name="agil_mailing_list")
 * @ORM\Entity(repositoryClass="AGIL\DefaultBundle\Repository\AgilMailingListRepository")
 */
class AgilMailingList
{
    /**
     * @var int
     *
     * @ORM\Column(name="mailingListId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $mailingListId;

    /**
     * @var string
     *
     * @ORM\Column(name="mailingListName", type="string", length=100, unique=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "La taille minimale est de {{ limit }} caractères",
     *      maxMessage = "La taille maximale est de {{ limit }} caractères"
     * )
     */
    private $mailingListName;


    /**
     * Get mailingListId
     *
     * @return integer 
     */
    public function getMailingListId()
    {
        return $this->mailingListId;
    }

    /**
     * Set mailingListName
     *
     * @param string $mailingListName
     * @return AgilMailingList
     */
    public function setMailingListName($mailingListName)
    {
        $this->mailingListName = $mailingListName;

        return $this;
    }

    /**
     * Get mailingListName
     *
     * @return string 
     */
    public function getMailingListName()
    {
        return $this->mailingListName;
    }
}
