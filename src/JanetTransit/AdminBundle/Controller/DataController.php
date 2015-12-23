<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Data;
use JanetTransit\AdminBundle\Form\DataType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Data controller.
 *
 * @Route("/data")
 */
class DataController extends Controller
{

    /**
     * Lists all Data entities.
     *
     * @Route("/", name="data")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Data();
        $form       = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Data')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView()

        );
    }
    /**
     * Creates a new Data entity.
     *
     * @Route("/", name="data_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Data:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = new Data();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('data_informations'));
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
            "id"                => $entity->getId(),
            "entite"            => 'DONNEES',
            'nom'               => $entity->getNom(),
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a Data entity.
     *
     * @param Data $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Data $entity)
    {
        $form = $this->createForm(new DataType(), $entity, array(
            'action' => $this->generateUrl('data_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing Data entity.
     *
     * @Route("/{id}/edit", name="data_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Data entity.
    *
    * @param Data $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Data $entity)
    {
        $form = $this->createForm(new DataType(), $entity, array(
            'action' => $this->generateUrl('data_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Data entity.
     *
     * @Route("/{id}", name="data_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Data:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('data_informations'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Data entity.
     *
     * @Route("/{id}", name="data_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1){
            $this->operationUpdate($entity, 'SUPPRESSION');
        }

        return $this->redirect($this->generateUrl('data_informations'));
    }

}
