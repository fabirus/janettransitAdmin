<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\DemandePermission;
use JanetTransit\AdminBundle\Form\DemandePermissionType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

/**
 * DemandePermission controller.
 *
 * @Route("/demandepermission")
 */
class DemandePermissionController extends Controller
{
    /**
     * Check Date.
     *
     * @Route("/demandepermissioncheckDate/{idEmploye}", name="demandepermission_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request        = $this->get('request');
        $date           = $request->query->get('date');

        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:DemandePermission')
            ->createQueryBuilder('d')
            ->select('d')
            ->where('d.employe =:idEmploye AND (d.dateDemande =:date OR d.dateFin =:date OR d.dateDebut =:date)')
            ->setParameters(array('date' => $date,'idEmploye' => $idEmploye))
            ->getQuery();

        $results = $query->getArrayResult();

        if(count($results) == 0) {
            $response = new Response('false');
        }
        else {
            $response = new Response('true');
        }
        return $response;

    }

    /**
     * Creates a new DemandePermission entity.
     *
     * @Route("/demandepermission/create", name="demandepermission_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:DemandePermission:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new DemandePermission();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_demandepermission');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);


        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('demandepermission_show', array('id' => $entityEmploye->getId())));
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'employe'   => $entityEmploye,
        );
    }

    /**
     * Operation Create Entity
     */

    public function operationUpdate($entity, $action) {
        $user  = $this->get('security.context')->getToken()->getUser();
        $data   = array(
            "id"                =>  $entity->getId(),
            "entite"            => 'DEMANDE DE PERMISSION',
            "DateDemande"       =>  $entity->getDateDemande(),
            "DateDebut"         =>  $entity->getDateDebut(),
            "DateFin"           =>  $entity->getDateFin(),
            "employe"           =>  $entity->getEmploye()->getNom()
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a DemandePermission entity.
     *
     * @param DemandePermission $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DemandePermission $entity)
    {
        $form = $this->createForm(new DemandePermissionType(), $entity, array(
            'action' => $this->generateUrl('demandepermission_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a Sanction entity.
     *
     * @Route("/demandepermission/{id}/{idEmploye}", name="demandepermission_print")
     * @Method("GET")
     * @Template("")
     */
    public function printAction($id, $idEmploye)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:DemandePermission')->find($id);
        $editForm   = $this->createEditForm($entity);
        $motif      = wordwrap($entity->getMotif(), 50, "\n", true);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandePermission entity.');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'success'       => $success,
            'motif'         => $motif,
            'idEmploye'     => $idEmploye
        );
    }

    /**
     * Finds and displays a DemandePermission entity.
     *
     * @Route("/demandepermission/{id}", name="demandepermission_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new DemandePermission();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:DemandePermission')->findBy(
            array('employe' => $id), array('dateDemande' => 'DESC'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandePermission entity.');
        }

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success,
        );
    }




    /**
    * Creates a form to edit a DemandePermission entity.
    *
    * @param DemandePermission $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DemandePermission $entity)
    {
        $form = $this->createForm(new DemandePermissionType(), $entity, array(
            'action' => $this->generateUrl('demandepermission_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DemandePermission entity.
     *
     * @Route("/demandepermission/{id}", name="demandepermission_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:DemandePermission:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:DemandePermission')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_demandepermission');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandePermission entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');

            return $this->redirect($this->generateUrl('demandepermission_show', array('id' => $entityEmploye->getId(), 'success' => 'true')));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Valid DemandePermission entity.
     *
     * @Route("/demandepermission/{id}/{valid}/{idEmploye}", name="demandepermission_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idEmploye)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:DemandePermission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandePermission entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('demandepermission_show', array('id' => $idEmploye)));
    }

}
