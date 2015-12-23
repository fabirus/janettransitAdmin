<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Presence;
use JanetTransit\AdminBundle\Form\PresenceType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

/**
 * Presence controller.
 *
 * @Route("/presence")
 */
class PresenceController extends Controller
{
    /**
     * Check File.
     *
     * @Route("/presence/check/{file}", name="presence_checkFile")
     * @Method("GET")
     * @Template()
     */
    public function checkFileAction($file){
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Presence')->findOneBy(array('absenceFileName' => $file));

        if($entity == null) {
            $response = new Response('false');
        }
        else {
            $response = new Response('true');
        }
        return $response;

    }


    /**
     * Check Date.
     *
     * @Route("/presence/check/{idEmploye}", name="presence_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request    = $this->get('request');
        $date       = $request->query->get('date');
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:Presence')->findOneBy(
            array('at'        => $date,
                  'employe'   => $idEmploye
            ));

        if($entity == null) {
            $response = new Response('false');
        }
        else {
            $response = new Response('true');
        }
        return $response;

    }


    /**
     * Creates a new Presence entity.
     *
     * @Route("/presence/create", name="presence_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Presence:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new Presence();
        $em             = $this->getDoctrine()->getManager();
        $form           = $this->createCreateForm($entity);
        $dataform       = $request->request->get('janettransit_adminbundle_presence');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);
        $form->handleRequest($request);

        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('presence_show', array('id' => $entityEmploye->getId())));
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'employe'   => $entityEmploye,
        );
    }

    /**
     * Creates a form to create a Presence entity.
     *
     * @param Presence $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Presence $entity)
    {
        $form = $this->createForm(new PresenceType(), $entity, array(
            'action' => $this->generateUrl('presence_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a Presence entity.
     *
     * @Route("/presence/{id}", name="presence_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id){

        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Presence();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Presence')->findBy(
            array('employe' => $id), array('at' => 'DESC'));


        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success
        );
    }

    /**
     * Displays a form to edit an existing Presence entity.
     *
     * @Route("/presence/{id}/edit/{idEmploye}", name="presence_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idEmploye)
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:Presence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presence entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'idEmploye'   => $idEmploye,
        );
    }

    /**
    * Creates a form to edit a Presence entity.
    *
    * @param Presence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Presence $entity)
    {
        $form = $this->createForm(new PresenceType(), $entity, array(
            'action' => $this->generateUrl('presence_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Presence entity.
     *
     * @Route("/presence/{id}", name="presence_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Presence:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:Presence')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_presence');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presence entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('presence_show', array('id' => $entityEmploye->getId())));

        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

}
