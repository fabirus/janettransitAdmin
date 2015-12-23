<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\PeriodeCarburation;
use JanetTransit\AdminBundle\Form\PeriodeCarburationType;
use Symfony\Component\HttpFoundation\Response;


/**
 * PeriodeCarburation controller.
 *
 * @Route("/periodecarburation")
 */
class PeriodeCarburationController extends Controller
{

    /**
     * Lists all PeriodeCarburation entities.
     *
     * @Route("/", name="periodecarburation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $entity     = new PeriodeCarburation();
        $form       = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->findBy(
            array(),
            array('dateCarburation' => 'desc')
        );

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
            'success'  => $success,
        );
    }

    /**
     * Check Date.
     *
     * @Route("/periodecarburationcheckDate/{idEmploye}", name="periodecarburation_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction(){

        $request        = $this->get('request');
        $date           = $request->query->get('date');
        $em             = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->findBy(
            array('dateCarburation' => $date, 'del' => 0)
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
     * Creates a new PeriodeCarburation entity.
     *
     * @Route("/", name="periodecarburation_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:PeriodeCarburation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity     = new PeriodeCarburation();
        $em         = $this->getDoctrine()->getManager();
        $form       = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('periodecarburation_informations'));
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
            "entite"            => 'PERIODE CARBURATION',
            "date"              =>  $entity->getDateCarburation(),
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a PeriodeCarburation entity.
     *
     * @param PeriodeCarburation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PeriodeCarburation $entity)
    {
        $form = $this->createForm(new PeriodeCarburationType(), $entity, array(
            'action' => $this->generateUrl('periodecarburation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing PeriodeCarburation entity.
     *
     * @Route("/{id}/edit", name="periodecarburation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeCarburation entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a PeriodeCarburation entity.
    *
    * @param PeriodeCarburation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PeriodeCarburation $entity)
    {
        $form = $this->createForm(new PeriodeCarburationType(), $entity, array(
            'action' => $this->generateUrl('periodecarburation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PeriodeCarburation entity.
     *
     * @Route("/{id}", name="periodecarburation_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:PeriodeCarburation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeCarburation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('periodecarburation_informations'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a PeriodeCarburation entity.
     *
     * @Route("/{id}", name="periodecarburation_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeCarburation entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1){
            $this->operationUpdate($entity, 'SUPPRESSION');
        }

        return $this->redirect($this->generateUrl('periodecarburation_informations'));
    }

}
