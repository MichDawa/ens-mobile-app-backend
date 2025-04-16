<?php

namespace Library\Infrastructure\Validation;

class ValidationResult implements FilterResultsInterface {

    private bool $isValid = true;
    private ?string $message = null;

    public function __construct(bool $isValid = false, ?string $message = null) {
        $this->isValid = $isValid;
        $this->message = $message;
    }

    public function valid() {
        $this->isValid = true;
    }

    public function invalid() {
        $this->isValid = false;
    }

    public function setMessage(?string $message) {
        $this->message = $message;
    }

    public function isValid(): bool {
        return $this->isValid;
    }

    public function getMessage(): ?string {
        return $this->message;
    }
}