<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Carburation;
use JanetTransit\AdminBundle\Form\CarburationType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Carburation controller.
 *
 * @Route("/carburation")
 */
class CarburationController extends Controller
{

    /**
     * Lists all Carburation entities.
     *
     * @Route("/carburation", name="carburation_informations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $entity     = new Carburation();
        $entityPeriodeCarburation  = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($id);
        $form       = $this->createCreateForm($entity);


        $entities = $em->getRepository('JanetTransitAdminBundle:Carburation')->findBy(
            array('periodeCarburation' => $id)
        );

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
            'success'  => $success,
            'periode'  => $entityPeriodeCarburation,
        );
    }
    /**
     * Creates a new Carburation entity.
     *
     * @Route("/carburation/{id}", name="carburation_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Carburation:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $em                             = $this->getDoctrine()->getManager();
        $dataform                       = $request->request->get('janettransit_adminbundle_carburation');
        $idPeriodeCarburation           = $dataform['periodeCarburation'];
        $entityPeriodeCarburation       = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($idPeriodeCarburation);
        $entity                         = new Carburation();
        $form                           = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');
            return $this->redirect($this->generateUrl('carburation_informations', array('id' => $entityPeriodeCarburation->getId())));
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'periode'   => $entityPeriodeCarburation,
        );
    }

    /**
     * Operation Create Entity
     */

    public function operationUpdate($entity, $action) {
        $user  = $this->get('security.context')->getToken()->getUser();
        $data   = array(
            "id"                =>  $entity->getId(),
            "entite"            => 'CARBURATION',
            'employe'           => $entity->getEmploye()->getNom(),
            "date"              =>  $entity->getPeriodeCarburation()->getDateCarburation(),
            "montant"           => $entity->getMontant()
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a Carburation entity.
     *
     * @param Carburation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Carburation $entity)
    {
        $form = $this->createForm(new CarburationType(), $entity, array(
            'action' => $this->generateUrl('carburation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing Carburation entity.
     *
     * @Route("/{id}/edit", name="carburation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idPeriode)
    {
        $em                         = $this->getDoctrine()->getManager();
        $entity                     = $em->getRepository('JanetTransitAdminBundle:Carburation')->find($id);
        $entityPeriodeCarburation   = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($idPeriode);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carburation entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'periode'     => $entityPeriodeCarburation,
        );
    }

    /**
    * Creates a form to edit a Carburation entity.
    *
    * @param Carburation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Carburation $entity)
    {
        $form = $this->createForm(new CarburationType(), $entity, array(
            'action' => $this->generateUrl('carburation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Carburation entity.
     *
     * @Route("/{id}", name="carburation_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Carburation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                             = $this->getDoctrine()->getManager();
        $dataform                       = $request->request->get('janettransit_adminbundle_carburation');
        $idPeriodeCarburation           = $dataform['periodeCarburation'];
        $entityPeriodeCarburation       = $em->getRepository('JanetTransitAdminBundle:PeriodeCarburation')->find($idPeriodeCarburation);
        $entity                         = $em->getRepository('JanetTransitAdminBundle:Carburation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carburation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');

            return $this->redirect($this->generateUrl('carburation_informations', array('id' => $entityPeriodeCarburation->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'periode'   => $entityPeriodeCarburation,
        );
    }
    /**
     * Deletes a Carburation entity.
     *
     * @Route("/{id}", name="carburation_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Carburation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carburation entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1){
            $this->operationUpdate($entity, 'SUPPRESSION');
        }

        return $this->redirect($this->generateUrl('periodecarburation_informations'));
    }

    /**
     * Valid AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}/{valid}/{idEmploye}", name="avancesalaire_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idPeriode)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Carburation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carburation entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('carburation_informations', array('id' => $idPeriode)));
    }

}
