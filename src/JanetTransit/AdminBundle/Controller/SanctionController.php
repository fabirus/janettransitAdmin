<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Sanction;
use JanetTransit\AdminBundle\Form\SanctionType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Sanction controller.
 *
 * @Route("/sanction")
 */
class SanctionController extends Controller
{
    /**
     * Check Date.
     *
     * @Route("/sanctioncheckDate/{idEmploye}", name="sanction_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request        = $this->get('request');
        $date           = $request->query->get('date');

        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:Sanction')
            ->createQueryBuilder('s')
            ->select('s')
            ->where('s.employe =:idEmploye AND (s.dateSanction =:date OR s.dateFin =:date OR s.dateDebut =:date)')
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
     * Creates a new Sanction entity.
     *
     * @Route("/sanction/create", name="sanction_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Sanction:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new Sanction();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_sanction');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('sanction_show', array('id' => $entityEmploye->getId())));
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
            "entite"            => 'SANCTION',
            'dateSanction'      =>  $entity->getDateSanction(),
            'dateDebut'         =>  $entity->getDateDebut(),
            'dateFin'           =>  $entity->getDateFin(),
            "retenuSalaire"     =>  $entity->getRetenuSalaire(),
            "employe"           =>  ($entity->getEmploye() !== NULL ) ? $entity->getEmploye()->getNom() : 'aucun'
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a Sanction entity.
     *
     * @param Sanction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sanction $entity)
    {
        $form = $this->createForm(new SanctionType(), $entity, array(
            'action' => $this->generateUrl('sanction_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Sanction entity.
     *
     * @Route("/sanction/{id}/{idEmploye}", name="sanction_print")
     * @Method("GET")
     * @Template("")
     */
    public function printAction($id, $idEmploye)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:Sanction')->find($id);
        $editForm   = $this->createEditForm($entity);
        $motif      = wordwrap($entity->getMotif(), 50, "\n", true);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sanction entity.');
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
     * Finds and displays Entities sanction by USerID.
     *
     * @Route("/sanction/{id}", name="sanction_show")
     * @Method("GET")
     * @Template("JanetTransitAdminBundle:Sanction:show.html.twig")
     */
    public function showAction($id)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Sanction();
        $form       = $this->createCreateForm($entity);


        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Sanction')->findBy(
            array('employe' => $id), array('dateSanction' => 'DESC'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sanction entity.');
        }

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success,
        );
    }



    /**
    * Creates a form to edit a Sanction entity.
    *
    * @param Sanction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sanction $entity)
    {
        $form = $this->createForm(new SanctionType(), $entity, array(
            'action' => $this->generateUrl('sanction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Sanction entity.
     *
     * @Route("/sanction/{id}", name="sanction_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Sanction:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:Sanction')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_sanction');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sanction entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('sanction_show', array('id' => $entityEmploye->getId(), 'success'=>'true')));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Valid DemandePermission entity.
     *
     * @Route("/sanction/{id}/{valid}/{idEmploye}", name="sanction_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idEmploye)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Sanction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sanction entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('sanction_show', array('id' => $idEmploye)));
    }

}
