<?php

namespace Library\Infrastructure\Validation;

interface FilterResultsInterface {

    public function isValid(): bool;

    public function getMessage(): ?string;
}
