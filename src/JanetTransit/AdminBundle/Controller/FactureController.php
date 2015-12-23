<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Facture;
use JanetTransit\AdminBundle\Form\FactureType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

/**
 * Facture controller.
 *
 * @Route("/facture")
 */
class FactureController extends Controller
{

    /**
     * Lists all Facture entities.
     *
     * @Route("/", name="facture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities   = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findTypeManutentionQueryBuilder();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Facture entity.
     *
     * @Route("/", name="facture_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Facture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em                 = $this->getDoctrine()->getManager();
        $entity             = new Facture();
        $dataform           = $request->request->get('janettransit_adminbundle_facture');
        $idPeriodeFacture   = $dataform['periodeFacture'];
        $idContrat          = $request->request->get('contrat');

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('facture_show', array('idPeriodeFacture' => $idPeriodeFacture, 'idContrat' => $idContrat)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Operation Create Entity
     */

    public function operationUpdate($entity, $action) {
        $user  = $this->get('security.context')->getToken()->getUser();
        $data   = array(
            "id"                =>  $entity->getId(),
            "entite"            => 'MANUTENTION',
            "heure"             =>  $entity->getHeure(),
            'container'         =>  $entity->getNumeroContainer(),
            'client'            =>  $entity->getClient(),
            'montant'           =>  $entity->getPercu(),
            'stationnement'     =>  $entity->getStationnement(),
            "voiture"           =>  ($entity->getVoiture() !== NULL ) ? $entity->getVoiture()->getImmatricule() : 'aucune',
            "Date"              =>  $entity->getPeriodeFacture()->getDateFacture(),
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a Facture entity.
     *
     * @param Facture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Facture $entity)
    {
        $form = $this->createForm(new FactureType(), $entity, array(
            'action' => $this->generateUrl('facture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Facture entity.
     *
     * @Route("/{id}", name="facture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($idPeriodeFacture, $idContrat)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new Facture();
        $form           = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Facture')->findBy(
            array('periodeFacture' => $idPeriodeFacture)
        );

        $entityContrat = $em->getRepository('JanetTransitAdminBundle:ContratEts')->find($idContrat);
        $entityPeriode = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->find($idPeriodeFacture);


        return array(
            'entities'          => $entities,
            'entityPeriode'     => $entityPeriode,
            'form'              => $form->createView(),
            'idContrat'         => $idContrat,
            'contrat'           => $entityContrat
        );
    }

    /**
     * Displays a form to edit an existing Facture entity.
     *
     * @Route("/{id}/edit", name="facture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idPeriodeFacture, $idContrat)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'            => $entity,
            'edit_form'         => $editForm->createView(),
            'idContrat'         => $idContrat,
            'idPeriodeFacture'  => $idPeriodeFacture
        );
    }

    /**
     * Print Facture entity.
     *
     * @Route("/{id}/edit", name="facture_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id, $idPeriodeFacture, $idContrat)
    {
        $em = $this->getDoctrine()->getManager();

        $entity         =  $em->getRepository('JanetTransitAdminBundle:Facture')->find($id);
        $entityPeriode  = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->find($idPeriodeFacture);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        return array(
            'entity'            => $entity,
            'entityPeriode'     => $entityPeriode,
            'idContrat'         => $idContrat
        );
    }

    /**
     * Find ContratEts entities.
     *
     * @Route("/recherche/contratets", name="contratetssearch")
     * @Method("GET")
     * @Template()
     */
    public function searchAction(){

        $request    = $this->get('request');
        $json       = array();
        $searchText = '';
        $searchText = $request->query->get('searchText');
        $em         = $this->getDoctrine()->getManager();

        if($request->isXmlHttpRequest()) {

            if ($searchText !== '') {
                $entities   = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findTypeManutentionSearchQueryBuilder($searchText);
            }
            else {
                $entities = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findTypeManutentionQueryBuilder();
            }

            $json['view'] = $this->renderView('JanetTransitAdminBundle:Facture:search.html.twig',
                array(
                    'entities' => $entities,
                    'searchText' => $searchText
                ));

            $response = new Response(json_encode($json));
            return $response;
        }
        else{
            $this->indexAction();

        }
    }

    /**
    * Creates a form to edit a Facture entity.
    *
    * @param Facture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Facture $entity)
    {
        $form = $this->createForm(new FactureType(), $entity, array(
            'action' => $this->generateUrl('facture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Facture entity.
     *
     * @Route("/{id}", name="facture_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Facture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $entity             = new Facture();
        $dataform           = $request->request->get('janettransit_adminbundle_facture');
        $idPeriodeFacture   = $dataform['periodeFacture'];
        $idContrat          = $request->request->get('contrat');
        $entity             = $em->getRepository('JanetTransitAdminBundle:Facture')->find($id);

//        echo $request->request->get('contrat');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('facture_show', array('idPeriodeFacture' => $idPeriodeFacture, 'idContrat' => $idContrat)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Valid AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}/{valid}/{idEmploye}", name="avancesalaire_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idPeriodeDepense, $idContrat)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('facture_show', array('idPeriodeFacture' => $idPeriodeDepense, 'idContrat' => $idContrat)));
    }
    /**
     * Deletes a Voiture entity.
     *
     * @Route("/{id}", name="voiture_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del, $idRefresh, $idRefresh2){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1) {
            $this->operationUpdate($entity, 'SUPPRESSION');
        }


        return $this->redirect($this->generateUrl('facture_show', array('idPeriodeFacture' => $idRefresh, 'idContrat' => $idRefresh2)));
    }

}
