<?php

namespace AGIL\DefaultBundle\TagService;


use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\ProfileBundle\Entity\AgilSkill;
use Doctrine\ORM\EntityManager;

class Tags {

	public function __construct(EntityManager $entityManager) {
		$this->em = $entityManager;
	}

	/**
	 * Permet d'insérer un tag dans la BDD
	 *
	 * @param $tagName Le nom du tag à insérer
	 * @param string $color La couleur qu'on donnera au tag
	 * @param AgilSkill $skillCat La catégorie à associer au tag
	 */
	function insertTag($tagName, $color = 'tag-default', AgilSkill $skillCat = null) {
		if (!$tagName) {
			// Si le tagName est une chaine vide on ne fait rien.
			/*
			 * Cela peut arriver quand il y a un (ou plusieurs) espace de trop
			 * dans la chaine qui est explode par les espaces
			 */
			return;
		}

		$tagRepo = $this->em->getRepository("AGILDefaultBundle:AgilTag");

		if (null === $tagRepo->findOneByTagName($tagName)) {
			$tag = new AgilTag($tagName, $color, null);
			$tag->setSkillCategory((null == $skillCat)? null : $skillCat);
			$this->em->persist($tag);
		}
	}
}