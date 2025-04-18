<?php

namespace Sample\Infra\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sample_table")
 */
class SampleEntity {
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=Ramsey\Uuid\Doctrine\UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(name="sample_string", type="string", length=255, nullable=true)
     */
    private $sample_string;

    public function getId(): ?string {
        return $this->id;
    }

    public function getSampleString(): ?string {
        return $this->sample_string;
    }

    public function setSampleString(?string $sample_string) {
        $this->sample_string = $sample_string;
        return $this;
    }
}