<?php

namespace JanetTransit\AdminBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Repository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use JanetTransit\AdminBundle\Entity\Operation;
use Symfony\Component\Validator\Constraints\DateTime;



class OperationApp extends Controller{

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
public function update($data, $user, $action) {

    $entity = new Operation();
    $entity->setUpdatedAt(new DateTime());
    $entity->setUsername($user->getUsername());
    $entity->setAction($action);
    $entity->setEntity($data);
    $entity->setNomComplet($user->getFirstname().' '. $user->getLastname());
    $this->em->persist($entity);
    $this->em->flush();
//    echo $action;



}



}