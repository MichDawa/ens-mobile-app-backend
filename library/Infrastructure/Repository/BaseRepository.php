<?php

namespace Library\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class BaseRepository {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager() {
        return $this->em;
    }

    public function persist($entity) {
        $this->getEntityManager()->persist($entity);
    }

    public function beginTransaction() {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
    }

    public function flush($entity = null) {
        $this->getEntityManager()->flush($entity);
    }

    public function commit() {
        if ($this->isTransactionActive()) {
            $this->getEntityManager()->getConnection()->commit();
        }
    }

    public function flushAndCommit() {
        $this->flush();
        $this->commit();
    }

    public function isTransactionActive() {
        return $this->getEntityManager()->getConnection()->isTransactionActive();
    }

    public function rollback() {
        if ($this->isTransactionActive()) {
            $this->getEntityManager()->getConnection()->rollBack();
        }
    }

    public function rollbackAndClose() {
        if ($this->isTransactionActive()) {
            $this->getEntityManager()->getConnection()->rollBack();
            $this->getEntityManager()->close();
        }
    }

    public function remove($entity) {
        $this->getEntityManager()->remove($entity);
    }
    
    public function clearEntityManager() {
        $this->getEntityManager()->clear();
    }

    protected function toLiteralList($list, QueryBuilder $qb) {
        $forReturn = [];
        foreach ($list as $forLiteral) {
            $forReturn[] = $qb->expr()->literal($forLiteral);
        }
        return $forReturn;
    }

}
