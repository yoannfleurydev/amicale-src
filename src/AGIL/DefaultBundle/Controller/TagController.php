<?php

namespace AGIL\DefaultBundle\Controller;

use AGIL\OfferBundle\Entity\AgilOffer;
use AGIL\ProfileBundle\Entity\AgilSkill;
use InvalidArgumentException;
use Proxies\__CG__\AGIL\DefaultBundle\Entity\AgilTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TagController extends Controller {

	/**
	 * @param $char Le préfixe
	 * @return string Ensemble de résultat au format JSON
	 * Récupère une liste de tags dont le préfixe est $char et la renvoie au format JSON
	 */
	public function searchAction($char) {
		$tagsList = $this
			->getDoctrine()
			->getManager()
			->getRepository('AGILDefaultBundle:AgilTag')
			->getStartedTagsList($char);

		return json_encode($tagsList);
	}

	/**
	 * @param $object L'objet qui doit (et peut) recevoir un tag
	 * @param AgilTag $tag Le tag à ajouter
	 * Ajoute un tag à un objet candidat
	 */
	public function addTags($object, Array $tag) {

		// Si c'est une compétence, il n'y a qu'un tag
		if ($object instanceof AgilSkill) {
			$object->setTag($tag[0]);
		}
		// Si c'est une offre d'emploi/stage
		elseif ($object instanceof AgilOffer) {
			/*
			 * On est obligé d'ajouter les tags un à un
			 * car la fonction de l'entité ajoute l'argument
			 * que l'on passe à un tableau.
			 */
			foreach($tag as $t) {
				$object->addTag($t);
			}
		}
		// L'objet ne supporte pas les tags
		else {
			throw new InvalidArgumentException('Les tags ne sont pas admis sur cet objet');
		}
		$this->addFlash('notice', 'Tags ajoutés avec succès !');
	}
}