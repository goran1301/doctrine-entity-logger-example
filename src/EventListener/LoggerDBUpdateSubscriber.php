<?php


namespace App\EventListener;


use App\Entity\History;
use App\Logger\CreateEventProcession;
use App\Logger\EventMessageComposer;
use App\Logger\UpdateEventProcession;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerDBUpdateSubscriber
 * @package App\EventListener
 */
class LoggerDBUpdateSubscriber implements EventSubscriber
{
    /**
     * @var EventMessageComposer
     */
    private $eventMessageComposer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggerDBUpdateSubscriber constructor.
     * @param EventMessageComposer $eventMessageComposer
     * @param LoggerInterface $logger
     */
    public function __construct(EventMessageComposer $eventMessageComposer, LoggerInterface $logger)
    {
        $this->eventMessageComposer = $eventMessageComposer;
        $this->logger = $logger;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postUpdate,
            Events::postPersist
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->logEntity(UpdateEventProcession::EVENT, $args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->logEntity(CreateEventProcession::EVENT, $args);
    }

    /**
     * @param string $eventName
     * @param LifecycleEventArgs $args
     */
    private function logEntity(string $eventName, LifecycleEventArgs $args)
    {
        try {
            $message = $this->eventMessageComposer->compose($args->getEntity(), $eventName, $args);
            if ($message !== null) {
                $args->getEntityManager()->persist(new History($message));
                $args->getEntityManager()->flush();
            }
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage().": ".$exception->getTraceAsString());
        }
    }
}