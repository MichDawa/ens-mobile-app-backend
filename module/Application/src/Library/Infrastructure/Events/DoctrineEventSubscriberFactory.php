<?php

declare(strict_types=1);

namespace App\Library\Infrastructure\Events;

use Psr\Container\ContainerInterface;

class DoctrineEventSubscriberFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DoctrineEventSubscriber($container->get(EventDispatcherInterface::class));
    }
}

