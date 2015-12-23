<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Poste;
use JanetTransit\AdminBundle\Form\PosteType;
use Symfony\Component\HttpFoundation\Response;


/**
 * Poste controller.
 *
 * @Route("/poste")
 */
class PosteController extends Controller
{

    /**
     * Lists all Poste entities.
     *
     * @Route("/poste", name="poste_informations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(){

        $em         = $this->getDoctrine()->getManager();
        $entity     = new Poste();
        $form       = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Poste')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView()
        );
    }

    /**
     * Lists all Poste By passing id of entity Service.
     *
     * @Route("/poste/service/{id}", name="poste_of_service")
     * @Method("GET")
     * @Template()
     */
    public function servicePosteAction($id)
    {
        $em       = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JanetTransitAdminBundle:Poste')->findBy(array(
            'service' => $id,
            'del'     => 0
        ));

        $json['view'] = $this->renderView('JanetTransitAdminBundle:Poste:servicePoste.html.twig',
            array(
                'entities' => $entities
            ));

        $response = new Response(json_encode($json));
        return $response;

    }


    /**
     * Creates a new Poste entity.
     *
     * @Route("/poste/create", name="poste_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Poste:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Poste();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poste_informations'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Poste entity.
     *
     * @param Poste $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Poste $entity)
    {
        $form = $this->createForm(new PosteType(), $entity, array(
            'action' => $this->generateUrl('poste_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Poste entity.
     *
     * @Route("/poste/{id}", name="poste_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Poste')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poste entity.');
        }


        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Poste entity.
     *
     * @Route("/poste/{id}/edit", name="poste_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Poste')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poste entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Poste entity.
    *
    * @param Poste $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Poste $entity)
    {
        $form = $this->createForm(new PosteType(), $entity, array(
            'action' => $this->generateUrl('poste_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Poste entity.
     *
     * @Route("/poste/{id}", name="poste_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Poste:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Poste')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poste entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('poste_informations'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Poste entity.
     *
     * @Route("/poste/delete/{id}/{del}", name="poste_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Poste')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poste entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('poste_informations'));
    }

}
