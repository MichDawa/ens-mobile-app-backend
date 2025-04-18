<?php

namespace Sample\Infra\Query;

use Sample\Infra\Entity\SampleEntity;
use Doctrine\ORM\QueryBuilder;

class SampleQuery {
    private $qb;

    function __construct(QueryBuilder $qb) {
        $this->qb = $qb;
    }

    public function getQueryBuilder(): QueryBuilder {
        return $this->qb;
    }

    public function baseQuery() {
        $qb = $this->getQueryBuilder()
            ->select("s")
            ->from(SampleEntity::class, "s");
        return $this;
    }

    // public function addSampleString($param) {
    //     $qb = $this->getQueryBuilder();
    //     // $qb-> PUT IN THE DB s.sample_string;
    //     return $this;
    // }
}