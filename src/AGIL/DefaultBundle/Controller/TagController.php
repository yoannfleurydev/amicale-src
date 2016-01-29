<?php

namespace AGIL\DefaultBundle\Controller;

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
}