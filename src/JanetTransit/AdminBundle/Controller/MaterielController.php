<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Materiel;
use JanetTransit\AdminBundle\Form\MaterielType;

/**
 * Materiel controller.
 *
 * @Route("/materiel")
 */
class MaterielController extends Controller
{

    /**
     * Creates a new Materiel entity.
     *
     * @Route("/", name="materiel_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Materiel:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Materiel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materiel_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
     * Displays a form to create a new Materiel entity.
     *
     * @Route("/new", name="materiel_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Materiel();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
     * Displays a form to edit an existing Materiel entity.
     *
     * @Route("/{id}/edit", name="materiel_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Materiel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materiel entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Materiel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materiel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materiel_edit', array('id' => $id)));
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
