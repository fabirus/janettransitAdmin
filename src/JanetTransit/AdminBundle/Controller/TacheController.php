<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Tache;
use JanetTransit\AdminBundle\Form\TacheType;

/**
 * Tache controller.
 *
 * @Route("/tache")
 */
class TacheController extends Controller
{

    /**
     * Lists all Tache entities.
     *
     * @Route("/", name="tache")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Tache();
        $form       = $this->createCreateForm($entity);
        $taf        = $em->getRepository('JanetTransitAdminBundle:Taf')->find($id);
        $entities   = $em->getRepository('JanetTransitAdminBundle:Tache')->findBy(
            array('taf' => $id)
        );

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
            'taf'      => $taf
        );
    }
    /**
     * Creates a new Tache entity.
     *
     * @Route("/", name="tache_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Tache:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new Tache();
        $dataform       = $request->request->get('janettransit_adminbundle_tache');
        $idTaf          = $dataform['taf'];
        $entityTaf      = $em->getRepository('JanetTransitAdminBundle:Taf')->find($idTaf);


        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tache_informations', array('id' => $entityTaf->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'taf'    => $entityTaf
        );
    }

    /**
     * Creates a form to create a Tache entity.
     *
     * @param Tache $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tache $entity)
    {
        $form = $this->createForm(new TacheType(), $entity, array(
            'action' => $this->generateUrl('tache_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Tache entity.
     *
     * @Route("/{id}/edit", name="tache_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idTaf){
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Tache')->find($id);
        $taf    = $em->getRepository('JanetTransitAdminBundle:Taf')->find($idTaf);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tache entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'taf'         => $taf
        );
    }

    /**
    * Creates a form to edit a Tache entity.
    *
    * @param Tache $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tache $entity)
    {
        $form = $this->createForm(new TacheType(), $entity, array(
            'action' => $this->generateUrl('tache_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tache entity.
     *
     * @Route("/{id}", name="tache_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Tache:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_tache');
        $idTaf          = $dataform['taf'];
        $entityTaf      = $em->getRepository('JanetTransitAdminBundle:Taf')->find($idTaf);

        $entity = $em->getRepository('JanetTransitAdminBundle:Tache')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tache entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tache_informations', array('id' => $entityTaf->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Tache entity.
     *
     * @Route("/{id}", name="tache_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JanetTransitAdminBundle:Tache')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tache entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tache'));
    }

    /**
     * Valid tache entity.
     *
     * @Route("/tache/{id}/{valid}/{idTaf}", name="tache_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idTaf)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Tache')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tache entity.');
        }
        $entity->setEtat($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('tache_informations', array('id' => $idTaf)));
    }

}
