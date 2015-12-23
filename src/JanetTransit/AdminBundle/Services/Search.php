<?php

namespace JanetTransit\AdminBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Repository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class Search extends Controller{

    private $em;
    private $requestStack;

///**
//* @InjectParams({
//*    "em" = @Inject("doctrine.orm.entity_manager")
//* })
//*/
public function __construct(EntityManager $em, RequestStack $requestStack){
    $this->request  = $requestStack->getCurrentRequest();
    $this->em       = $em;
}


/**
 * @param $select Array of Informations of Select
 * @return array
 */
public function search($select) {

    $qb = $this->em->createQueryBuilder();
    $qb->select($select['select'])
        ->from($select['entity'], $select['select'])
        ->where($select['where'])
        ->orderBy($select['orderBy'])
        ->setParameter('searchText', '%'.$select['searchText'].'%');

    $query = $qb->getQuery();

    return $query->getResult();
}



}