<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Taf;
use JanetTransit\AdminBundle\Form\TafType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Taf controller.
 *
 * @Route("/taf")
 */
class TafController extends Controller
{

    /**
     * Lists all Taf entities.
     *
     * @Route("/", name="taf")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Taf();
        $form       = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Taf')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView()
        );
    }

    /**
     * Lists all DemandePermission entities.
     *
     * @Route("/suivi", name="suivi_informations")
     * @Method("GET")
     * @Template()
     */
    public function suiviAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entities   = $em->getRepository('JanetTransitAdminBundle:Employe')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Suivi of Employes entities.
     *
     * @Route("/suivi/{idEmploye}", name="suvi_show")
     * @Method("GET")
     * @Template()
     */
    public function suiviEmployeAction($idEmploye){

        $em         = $this->getDoctrine()->getManager();
        $employe    = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);
        $entities   = $em->getRepository('JanetTransitAdminBundle:Tache')->findByIdEmploye($idEmploye);


        return array(
            'entities' => $entities,
            "employe"  => $employe
        );
    }

    /**
     * Check Date.
     *
     * @Route("/tafcheckDate", name="taf_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction(){

        $em             = $this->getDoctrine()->getManager();
        $request        = $this->get('request');
        $date           = $request->query->get('date');
        $entities       = $em->getRepository('JanetTransitAdminBundle:Taf')->findBy(
                array('dateTache' => $date)
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
     * Creates a new Taf entity.
     *
     * @Route("/", name="taf_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Taf:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Taf();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('taf_informations'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Taf entity.
     *
     * @param Taf $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Taf $entity)
    {
        $form = $this->createForm(new TafType(), $entity, array(
            'action' => $this->generateUrl('taf_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing Taf entity.
     *
     * @Route("/{id}/edit", name="taf_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Taf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taf entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Taf entity.
    *
    * @param Taf $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Taf $entity)
    {
        $form = $this->createForm(new TafType(), $entity, array(
            'action' => $this->generateUrl('taf_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Taf entity.
     *
     * @Route("/{id}", name="taf_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Taf:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Taf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Taf entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('taf_informations'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

}
