<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Service;
use JanetTransit\AdminBundle\Form\ServiceType;

/**
 * Service controller.
 *
 * @Route("/service")
 */
class ServiceController extends Controller
{

    /**
     * Lists all Service entities.
     *
     * @Route("/service", name="service_informations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Service();
        $form       = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Service')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView()
        );
    }
    /**
     * Creates a new Service entity.
     *
     * @Route("/service/create", name="service_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Service:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Service();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('service_informations'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Service entity.
     *
     * @param Service $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Service $entity)
    {
        $form = $this->createForm(new ServiceType(), $entity, array(
            'action' => $this->generateUrl('service_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a Service entity.
     *
     * @Route("/service/{id}", name="service_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }


        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Service entity.
     *
     * @Route("/{id}/edit", name="service_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Service entity.
    *
    * @param Service $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Service $entity)
    {
        $form = $this->createForm(new ServiceType(), $entity, array(
            'action' => $this->generateUrl('service_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Service entity.
     *
     * @Route("/service/{id}", name="service_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Service:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('service_informations'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Service entity.
     *
     * @Route("/service/delete/{id}/{del}", name="service_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('service_informations'));
    }

}
