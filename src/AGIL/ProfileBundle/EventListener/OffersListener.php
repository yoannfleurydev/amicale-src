<?php

namespace AGIL\ProfileBundle\EventListener;

use AGIL\OfferBundle\Entity\AgilOffer;

class OffersListener
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if(!$entity instanceof AgilOffer) {
            return;
        }

        $message = new \Swift_Message(
            'Nouvelle offre',
            'Un nouvelle offre a été publiée ...'
        );

        $message
            ->addTo("amicale@amicale.dev")
            ->addFrom("test@amicale.dev")
        ;

        $this->mailer->send($message);
    }
}