<?php

declare(strict_types=1);

namespace App\Library\Infrastructure\Events;


use App\Service\BaseService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;

class DoctrineEventSubscriber extends BaseService implements EventSubscriber
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {

        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [Events::postFlush,];
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $logger = $this->getLogger();
//        $logger->info("startDoctrinePostFlushEvent");
        try {
            $this->eventDispatcher->dispatchDoctrineEvents();

//            $logger->info("endDoctrinePostFlushEvent");
        } catch (\Exception $e) {
            $logger->critical($e->getMessage(), $e->getTrace());
        } catch (\Throwable $e) {
            $logger->emergency($e->getMessage(), $e->getTrace());
        }

    }
}
