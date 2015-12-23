<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\PeriodeFacture;
use JanetTransit\AdminBundle\Form\PeriodeFactureType;
use Symfony\Component\HttpFoundation\Response;

/**
 * PeriodeFacture controller.
 *
 * @Route("/periodefacture")
 */
class PeriodeFactureController extends Controller
{

    /**
     * Lists all PeriodeFacture entities.
     *
     * @Route("/", name="periodefacture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($idContrat)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new PeriodeFacture();
        $form           = $this->createCreateForm($entity);
        $contrat        = $em->getRepository('JanetTransitAdminBundle:ContratEts')->find($idContrat);
        $entities       = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->findBy(
            array('contrat' => $idContrat)
        );

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
            'contrat'  => $contrat

        );
    }

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
        $em             = $this->getDoctrine()->getManager();

        $entities   = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->findBy(
            array('contrat' => $idEmploye, 'dateFacture' => $date, 'del' => 0)
        );

        if(count($entities) == 0) {
            $response = new Response('false');
        }
        else {
            $response = new Response('true');
        }
        return $response;

    }
    /**
     * Creates a new PeriodeFacture entity.
     *
     * @Route("/", name="periodefacture_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:PeriodeFacture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity             = new PeriodeFacture();
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_periodefacture');
        $idContrat          = $dataform['contrat'];
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('periodefacture_informations', array('idContrat' => $idContrat)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PeriodeFacture entity.
     *
     * @param PeriodeFacture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PeriodeFacture $entity)
    {
        $form = $this->createForm(new PeriodeFactureType(), $entity, array(
            'action' => $this->generateUrl('periodefacture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing PeriodeFacture entity.
     *
     * @Route("/{id}/edit", name="periodefacture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idContrat)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeFacture entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'idContrat'   => $idContrat

        );
    }

    /**
    * Creates a form to edit a PeriodeFacture entity.
    *
    * @param PeriodeFacture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PeriodeFacture $entity)
    {
        $form = $this->createForm(new PeriodeFactureType(), $entity, array(
            'action' => $this->generateUrl('periodefacture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PeriodeFacture entity.
     *
     * @Route("/{id}", name="periodefacture_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:PeriodeFacture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $entity             = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->find($id);
        $dataform           = $request->request->get('janettransit_adminbundle_periodefacture');
        $idContrat          = $dataform['contrat'];

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeFacture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('periodefacture_informations', array('idContrat' => $idContrat)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }
    /**
     * Deletes a Data entity.
     *
     * @Route("/{id}", name="data_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del, $idRefresh)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeFacture entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('periodefacture_informations', array(
            'idContrat' => $idRefresh,
        )));
    }


}
