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

    protected $users;


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
        $this->periodicTimer->addPeriodicTimer($this, 'hello', 5, function () use ($topic) {
            $topic->broadcast(['msg' => "ellooooo"]);
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

        /** @var ConnectionPeriodicTimer $topicTimer */
        $topicTimer = $connection->PeriodicTimer;

        //Add periodic timer
        $topicTimer->addPeriodicTimer('hello', 150, function () use ($topic, $connection) {
            ;
            $topic->broadcast([
                'refresh' => "coucou",
            ]);
        });


        //exist
        $topicTimer->isPeriodicTimerActive('hello'); //true or false

//        $user = $this->clientManipulator->getClient($connection);
        $this->users[$topic->getId()] = array($connection->resourceId => "");

        $topic->broadcast(
            [
                'se_co' => $connection->resourceId,
                'users' => $this->users[$topic->getId()]
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
        $tmp = null;

        if (isset($this->users)) {
            $tmp = $this->users[$topic->getId()][$connection->resourceId];
            unset($this->users[$topic->getId()][$connection->resourceId]);
        }

        if ($tmp != null) {
            $topic->broadcast([
                'msg_deco' => $connection->resourceId . " has left " . $topic->getId() . " --> ",
//            'users' => $this->users[$topic->getId()]
                'user_remove' => $tmp
            ]);
        } else {
            $topic->broadcast([
                'msg_deco' => $connection->resourceId . " has left " . $topic->getId() . " --> ",
//            'users' => $this->users[$topic->getId()]
//                'user_remove' => $this->users[$topic->getId()][$connection->resourceId]
            ]);
        }

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

        switch ($event['type']) {
            // Quand un user se connecte
            case "user_co":
                $this->users[$topic->getId()][$connection->resourceId] = intval($event['id_user']);
                var_dump($this->users[$topic->getId()]);
                $topic->broadcast([
                    'user_add' => intval($event['id_user']),
//                    'users' => $this->users[$topic->getId()]
                ]);

                break;
            case "msg":
                $topic->broadcast([
                    'msg' => $event,
//                    'users' => $this->users[$topic->getId()]
                ]);
                break;
        }
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