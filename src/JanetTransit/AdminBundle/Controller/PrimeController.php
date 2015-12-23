<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Prime;
use JanetTransit\AdminBundle\Form\PrimeType;
use Symfony\Component\HttpFoundation\Response;
/**
 * Prime controller.
 *
 * @Route("/prime")
 */
class PrimeController extends Controller
{

    /**
     * Lists all Prime entities.
     *
     * @Route("/prime", name="prime_informations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JanetTransitAdminBundle:Employe')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Prime entity.
     *
     * @Route("/", name="prime_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Prime:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new Prime();
        $em             = $this->getDoctrine()->getManager();
        $form           = $this->createCreateForm($entity);
        $dataform       = $request->request->get('janettransit_adminbundle_prime');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('prime_show', array('id' => $entityEmploye->getId())));
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
            "entite"            => 'PRIME',
            'mois'              =>  $entity->getPeriode(),
            "montant"           =>  $entity->getMontant(),
            "employe"           =>  ($entity->getEmploye() !== NULL ) ? $entity->getEmploye()->getNom() : 'aucun'
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Valid DemandePermission entity.
     *
     * @Route("/prime/{id}/{valid}", name="prime_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idEmploye)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Prime')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prime entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('prime_show', array('id' => $idEmploye)));
    }

    /**
     * Check Date.
     *
     * @Route("/prime/check/{idEmploye}", name="prime_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request    = $this->get('request');
        $date       = $request->query->get('date');
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:Prime')->findOneBy(
            array(  'periode'        => $date,
                    'employe'        => $idEmploye
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
     * Creates a form to create a Prime entity.
     *
     * @param Prime $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Prime $entity)
    {
        $form = $this->createForm(new PrimeType(), $entity, array(
            'action' => $this->generateUrl('prime_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Prime entity.
     *
     * @Route("/{id}", name="prime_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Prime();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Prime')->findBy(
            array('employe' => $id)
        );

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success
        );
    }

    /**
     * Displays a form to edit an existing Prime entity.
     *
     * @Route("/{id}/edit", name="prime_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idEmploye)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Prime')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prime entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'idEmploye'   => $idEmploye
        );
    }

    /**
    * Creates a form to edit a Prime entity.
    *
    * @param Prime $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Prime $entity)
    {
        $form = $this->createForm(new PrimeType(), $entity, array(
            'action' => $this->generateUrl('prime_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Prime entity.
     *
     * @Route("/{id}", name="prime_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Prime:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:Prime')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_prime');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prime entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');
            return $this->redirect($this->generateUrl('prime_show', array('id' => $entityEmploye->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

}
