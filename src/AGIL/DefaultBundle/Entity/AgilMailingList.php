<?php

namespace AGIL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
