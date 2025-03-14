<?php

namespace App\Library\Infrastructure\Events;


interface EventDispatcherInterface {
    public function dispatchDoctrineEvents();

    public function dispatchNonDoctrineEvents();
}
