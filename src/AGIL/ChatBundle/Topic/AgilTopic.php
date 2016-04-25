<?php

namespace AGIL\ChatBundle\Topic;

use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Gos\Bundle\WebSocketBundle\Topic\TopicPeriodicTimer;
use Gos\Bundle\WebSocketBundle\Topic\TopicPeriodicTimerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;

class AgilTopic implements TopicInterface, TopicPeriodicTimerInterface
{
    protected $clientManipulator;

    /**
     * @param ClientManipulatorInterface $clientManipulator
     */
    public function __construct(ClientManipulatorInterface $clientManipulator)
    {
        $this->clientManipulator = $clientManipulator;
    }

    /**
     * @var TopicPeriodicTimer
     */
    protected $periodicTimer;

    /**
     * @param TopicPeriodicTimer $periodicTimer
     */
    public function setPeriodicTimer(TopicPeriodicTimer $periodicTimer)
    {
        $this->periodicTimer = $periodicTimer;
    }

    /**
     * @param Topic $topic
     *
     * @return array
     */
    public function registerPeriodicTimer(Topic $topic)
    {
        //add
        $this->periodicTimer->addPeriodicTimer($this, 'hello', 5, function() use ($topic) {
            $topic->broadcast(['msg'=>"ellooooo"]);
        });

        //exist
        $this->periodicTimer->isPeriodicTimerActive($this, 'hello'); // true or false

        //remove
        $this->periodicTimer->cancelPeriodicTimer($this, 'hello');
    }

    /**
     * This will receive any Subscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return void
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {

        $user = $this->clientManipulator->getClient($connection);

        //this will broadcast the message to ALL subscribers of this topic.
        /** @var ConnectionPeriodicTimer $topicTimer */
        $topicTimer = $connection->PeriodicTimer;

        //Add periodic timer
        $topicTimer->addPeriodicTimer('hello', 60, function() use ($topic, $connection) {
            ;
            $topic->broadcast([
                'refresh' => "coucou",
            ]);
            // $topic->broadcast(['msg' => 'coucou']);
            //$connection->event($topic->getId(), ['msg' => 'hello world']);
        });

        //exist
        $topicTimer->isPeriodicTimerActive('hello'); //true or false

        //Remove periodic timer
        //$topicTimer->cancelPeriodicTimer('hello');
        $user = $this->clientManipulator->getClient($connection);
        $users = $this->clientManipulator->getAll($topic);
        $topic->broadcast(
            [
                'msg_co' => $user . " a rejoint " . $topic->getId(). '. Vous êtes maintenant : '.$topic->count(),
                'users' => json_encode($users)
            ]);
    }

    /**
     * This will receive any UnSubscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return voids
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        //this will broadcast the message to ALL subscribers of this topic.

        $topic->broadcast(['msg_deco' => $connection->resourceId . " has left " . $topic->getId() ." --> "]);
    }

    /**
     * This will receive any Publish requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param $Topic topic
     * @param WampRequest $request
     * @param $event
     * @param array $exclude
     * @param array $eligibles
     * @return mixed|void
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        /*
            $topic->getId() will contain the FULL requested uri, so you can proceed based on that

            if ($topic->getId() == "acme/channel/shout")
               //shout something to all subs.

        */
        //this will broadcast the message to ALL subscribers of this topic.
        $users = array();
        /** @var ConnectionInterface $client **/
        foreach ($topic as $client) {
            array_push($users, $client);
        }


        $topic->broadcast([
            'msg' => $event,
            'users' => json_encode($users),
        ]);
    }

    public function onCreateChan(ConnectionInterface $connection, Topic $topic, WampRequest $request){

    }


    /**
     * Like RPC is will use to prefix the channel
     * @return string
     */
    public function getName()
    {
        return 'agil.topic';
    }
}