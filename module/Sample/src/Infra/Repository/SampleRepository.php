<?php

namespace Sample\Infra\Repository;

use Library\Infrastructure\Repository\BaseRepository;
use Library\Infrastructure\Cache\CacheNames;
use Sample\Infra\Query\SampleQuery;

class SampleRepository extends BaseRepository {

    const CACHE_LIFE = 3600;

    private function createQuery(): SampleQuery {
        return new SampleQuery($this->getEntityManager()->createQueryBuilder());
    }

    public function findAll(): array {
        $builder = $this->createQuery()
            ->baseQuery();

        $qb = $builder->getQueryBuilder();
        $query = $qb->getQuery()
            ->enableResultCache(self::CACHE_LIFE, CacheNames::SAMPLE_TABLE);
        return $query->getResult();
    }

    public function clearCache() {
        $cache = $this->getEntityManager()->getConfiguration()->getResultCache();
        if ($cache !== null) {
            $cache->deleteItem(CacheNames::SAMPLE_TABLE);
        }
    }
}