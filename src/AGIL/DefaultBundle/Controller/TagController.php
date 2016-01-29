<?php

namespace AGIL\DefaultBundle\Controller;

use AGIL\ForumBundle\Entity\AgilForumSubject;
use AGIL\OfferBundle\Entity\AgilOffer;
use AGIL\ProfileBundle\Entity\AgilSkill;
use InvalidArgumentException;
use AGIL\DefaultBundle\Entity\AgilTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller {

	public function testFuncAction() {
		return $this->render('AGILDefaultBundle:Default:tags.html.twig');
	}

	/**
	 * @param $char String Le préfixe
	 * @return string Ensemble de résultat au format JSON
	 * Récupère une liste de tags dont le préfixe est $char et la renvoie au format JSON
	 */
	public function searchAction(Request $request) {

		// On récupère la valeur envoyée par la requête
		$prefix = $request->get('prefix');

		// Récupération du tableau de AgilTag
		$tagsList = $this
			->getDoctrine()
			->getManager()
			->getRepository('AGILDefaultBundle:AgilTag')
			// TODO changer 'a' pour $prefix
			->getTagsList('a');

		$jsonTagsList = Array();
		foreach ($tagsList as $tag) {
			$jsonTagsList[] = $tag->getTagName();
		}

		// Retourne le tableau encodé en JSON
		return new Response(json_encode($jsonTagsList));
	}

	/**
	 * @param $object mixed L'objet qui doit (et peut) recevoir un tag
	 * @param AgilTag $tags Le tag à ajouter
	 * Ajoute un tag à un objet candidat
	 */
	public function addTags($object, Array $tags) {

		// Si c'est une compétence, il n'y a qu'un tag
		if ($object instanceof AgilSkill ) {
			$object->setTag($tags[0]);
		}
		// Si c'est une offre d'emploi/stage
		elseif ($object instanceof AgilOffer || $object instanceof AgilForumSubject) {
			/*
			 * On est obligé d'ajouter les tags un à un
			 * car la fonction de l'entité ajoute l'argument
			 * que l'on passe à un tableau.
			 */
			foreach ($tags as $t) {
				$object->addTag($t);
			}
		}
		// L'objet ne supporte pas les tags
		else {
			throw new InvalidArgumentException('Les tags ne sont pas admis sur cet objet');
		}
		$this->addFlash('success', 'Tags ajoutés avec succès !');
	}
}