<?php

namespace AGIL\ProfileBundle\EventListener;

use AGIL\HallBundle\Entity\AgilEvent;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AGIL\DefaultBundle\Entity\AgilMailingList;


class EventsListner
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if(!$entity instanceof AgilEvent) {
            return;
        }

        $message = new \Swift_Message(
            'Nouvel événement',
            'Un nouvel événement a été publié ...'
        );

        $message
            ->addTo($entity->getUser()->getEmail())
            ->addFrom("amicale@amicale.dev")
        ;

        $this->mailer->send($message);
    }
}