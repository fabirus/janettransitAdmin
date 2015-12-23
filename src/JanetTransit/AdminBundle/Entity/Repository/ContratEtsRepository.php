<?php

namespace JanetTransit\AdminBundle\Entity\Repository;

/**
 * ContratEtsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContratEtsRepository extends \Doctrine\ORM\EntityRepository
{
    public function search($searchText){

        $qb =  $this->createQueryBuilder('c')
            ->leftJoin('c.typeContratEts', 't')
            ->addSelect('t')
            ->where('t.nom LIKE :searchText OR c.nom LIKE :searchText')
            ->setParameter('searchText', '%'.$searchText.'%')
        ;
        return $qb->getQuery()->getResult();
    }

    public function findTypeMecaniqueQueryBuilder(){

        $qb =  $this->createQueryBuilder('c')
            ->leftJoin('c.typeContratEts', 't')
            ->addSelect('t')
            ->where('t.nom LIKE :mecanique AND c.del = 0')
            ->setParameter('mecanique', '%mecanique%')
        ;
        return $qb->getQuery()->getResult();
    }

    public function findTypeMecaniqueSearchQueryBuilder($searchText){

        $qb =  $this->createQueryBuilder('c')
            ->leftJoin('c.typeContratEts', 't')
            ->addSelect('t')
            ->where('t.nom LIKE :mecanique AND c.del = 0 AND c.nom LIKE :searchText')
            ->setParameters(array('mecanique' => '%mecanique%', 'searchText' => '%'.$searchText.'%'))
        ;
        return $qb->getQuery()->getResult();
    }

    public function findTypeManutentionQueryBuilder(){

        $qb =  $this->createQueryBuilder('c')
            ->leftJoin('c.typeContratEts', 't')
            ->addSelect('t')
            ->where('t.nom LIKE :manutention AND c.del = 0')
            ->setParameter('manutention', '%manutention%')
        ;
        return $qb->getQuery()->getResult();
    }

    public function findTypeManutentionSearchQueryBuilder($searchText){

        $qb =  $this->createQueryBuilder('c')
            ->leftJoin('c.typeContratEts', 't')
            ->addSelect('t')
            ->where('t.nom LIKE :manutention AND c.del = 0 AND c.nom LIKE :searchText')
            ->setParameters(array('manutention' => '%manutention%', 'searchText' => '%'.$searchText.'%'))
        ;
        return $qb->getQuery()->getResult();
    }
}