<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Materiel;
use JanetTransit\AdminBundle\Form\MaterielType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
/**
 * Materiel controller.
 *
 * @Route("/materiel")
 */
class MaterielController extends Controller
{

    /**
     * Check Date.
     *
     * @Route("/avancesalairecheckDate/{idEmploye}", name="avancesalaire_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request        = $this->get('request');
        $date           = $request->query->get('date');

        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:Materiel')
            ->createQueryBuilder('a')
            ->select('a')
            ->where('a.employe =:idEmploye AND a.at =:date')
            ->setParameters(array('date' => $date,'idEmploye' => $idEmploye))
            ->getQuery();

        $results = $query->getArrayResult();

        if(count($results) == 0) {
            $response = new Response('false');
        }
        else {
            $response = new Response('true');
        }
        return $response;

    }


    /**
     * Check Qte.
     *
     * @Route("/avancesalairecheckDate/{idEmploye}", name="avancesalaire_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkQteAction($idStock){

        $em             = $this->getDoctrine()->getManager();
        $request        = $this->get('request');
        $qte            = $request->query->get('qte');
        $entityStock    = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);

        if($entityStock->getQteStock() >= $qte) {
            $response = new Response('false');
        }
        else {
            $response = new Response($entityStock->getQteStock());
        }
        return $response;

    }

    /**
     * Creates a new Materiel entity.
     *
     * @Route("/", name="materiel_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Materiel:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new Materiel();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_materiel');
        $idEmploye      = $dataform['employe'];
        $idStock        = $dataform['stock'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);
        $entityStock    = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);

        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->mouvementStock($em, $entityStock, $entity->getQte());
            $this->operationUpdate($entity, 'CREATION');

            return $this->redirect($this->generateUrl('materiel_show', array('id' => $entityEmploye->getId())));
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'employe'   => $entityEmploye,
        );
    }

    public function mouvementStock($em, $entityStock, $qte){
        $newQte = $entityStock->getQteStock() - $qte;
        $entityStock->setQteStock($newQte);
        $em->flush();
//        echo 'update'.$entityStock->getQteStock();

    }

    public function mouvementStockPreUpdate($em, $entityStock, $qte){
        $newQte = $entityStock->getQteStock() + $qte;
        $entityStock->setQteStock($newQte);
        $em->flush();
//        echo 'preupdate'.$entityStock->getQteStock();

    }

    /**
     * Operation Create Entity
     */

    public function operationUpdate($entity, $action) {
        $user  = $this->get('security.context')->getToken()->getUser();
        $data   = array(
            "id"                =>  $entity->getId(),
            "entite"            => 'MATERIEL FOURNI',
            "date"              =>  $entity->getAt(),
            "qte"               =>  $entity->getQte(),
            "materiel"          =>  $entity->getStock(),
            "employe"           =>  $entity->getEmploye()->getNom()
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Finds and displays a AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}/{idEmploye}", name="avancesalaire_print")
     * @Method("GET")
     * @Template("")
     */
    public function printAction($id, $idEmploye)
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:Materiel')->find($id);
        $editForm   = $this->createEditForm($entity);
        $motif      = wordwrap($entity->getMotif(), 50, "\n", true);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvanceSalaire entity.');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'motif'         => $motif,
            'idEmploye'     => $idEmploye,
        );
    }

    /**
     * Creates a form to create a Materiel entity.
     *
     * @param Materiel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Materiel $entity)
    {
        $form = $this->createForm(new MaterielType(), $entity, array(
            'action' => $this->generateUrl('materiel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Materiel entity.
     *
     * @Route("/{id}", name="materiel_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Materiel();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Materiel')->findBy(
            array('employe' => $id), array('at' => 'DESC'));


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materiel entity.');
        }

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success,
        );
    }


    /**
    * Creates a form to edit a Materiel entity.
    *
    * @param Materiel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Materiel $entity)
    {
        $form = $this->createForm(new MaterielType(), $entity, array(
            'action' => $this->generateUrl('materiel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Materiel entity.
     *
     * @Route("/{id}", name="materiel_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Materiel:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_materiel');
        $idEmploye      = $dataform['employe'];
        $idStock        = $dataform['stock'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);
        $entityStock    = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);

        $entity = $em->getRepository('JanetTransitAdminBundle:Materiel')->find($id);
        $qteStock =  $entity->getQte();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materiel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->mouvementStockPreUpdate($em, $entityStock, $qteStock);
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');
            $this->mouvementStock($em, $entityStock, $entity->getQte());
            echo 'afer'.$entity->getQte();

            return $this->redirect($this->generateUrl('materiel_show', array('id' => $entityEmploye->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
//    /**
//     * Deletes a Materiel entity.
//     *
//     * @Route("/{id}", name="materiel_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, $id)
//    {
//        $form = $this->createDeleteForm($id);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $entity = $em->getRepository('JanetTransitAdminBundle:Materiel')->find($id);
//
//            if (!$entity) {
//                throw $this->createNotFoundException('Unable to find Materiel entity.');
//            }
//
//            $em->remove($entity);
//            $em->flush();
//        }
//
//        return $this->redirect($this->generateUrl('materiel'));
//    }

}
