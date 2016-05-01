<?php

namespace AGIL\ProfileBundle\EventListener;
use AGIL\ForumBundle\Entity\AgilForumSubject;

/**
 * Class ForumListener
 *
 * @package \AGIL\ProfileBundle\EventListener
 */
class ForumListener {
    private $mailer;

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if(!$entity instanceof AgilForumSubject) {
            return;
        }

        $message = new \Swift_Message(
            'Nouveau sujet dans le forum',
            'Une nouvelle offre a été publiée ...'
        );

        $message
            ->addTo("amicale@amicale.dev")
            ->addFrom("test@amicale.dev")
        ;

        $this->mailer->send($message);
    }
}