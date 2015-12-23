<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Reunion;
use JanetTransit\AdminBundle\Form\ReunionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Reunion controller.
 *
 * @Route("/reunion")
 */
class ReunionController extends Controller
{

    /**
     * Lists all Reunion entities.
     *
     * @Route("/", name="reunion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $entity     = new Reunion();
        $form       = $this->createCreateForm($entity);
        $entities   = $em->getRepository('JanetTransitAdminBundle:Reunion')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
            'success'  => $success,
        );
    }

    /**
     * Check Date.
     *
     * @Route("/reunioncheckDate/{idEmploye}", name="reunion_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request        = $this->get('request');
        $date           = $request->query->get('date');
        $em             = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JanetTransitAdminBundle:Reunion')->findBy(
            array('dateReunion' => $date, 'del' => 0)
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
     * Creates a new Reunion entity.
     *
     * @Route("/", name="reunion_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Reunion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity     = new Reunion();
        $em         = $this->getDoctrine()->getManager();
        $form       = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('reunion_informations'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Reunion entity.
     *
     * @param Reunion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Reunion $entity)
    {
        $form = $this->createForm(new ReunionType(), $entity, array(
            'action' => $this->generateUrl('reunion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Reunion entity.
     *
     * @Route("/new", name="reunion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Reunion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Reunion entity.
     *
     * @Route("/{id}", name="reunion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $entity     = $em->getRepository('JanetTransitAdminBundle:Reunion')->find($id);
        $form       = $this->createEditForm($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reunion entity.');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $form->createView(),
            'success'       => $success,
        );
    }


    /**
    * Creates a form to edit a Reunion entity.
    *
    * @param Reunion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reunion $entity)
    {
        $form = $this->createForm(new ReunionType(), $entity, array(
            'action' => $this->generateUrl('reunion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Reunion entity.
     *
     * @Route("/{id}", name="reunion_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Reunion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Reunion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reunion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('reunion_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Reunion entity.
     *
     * @Route("/{id}", name="reunion_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Reunion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reunion entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('reunion_informations'));
    }

}
