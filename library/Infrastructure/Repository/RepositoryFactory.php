<?php

namespace Library\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RepositoryFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $em = $container->get(EntityManager::class);
        return new $requestedName($em);
    }

}