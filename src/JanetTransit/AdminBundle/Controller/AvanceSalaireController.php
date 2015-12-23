<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\AvanceSalaire;
use JanetTransit\AdminBundle\Form\AvanceSalaireType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;


/**
 * AvanceSalaire controller.
 *
 * @Route("/avancesalaire")
 */
class AvanceSalaireController extends Controller
{

    /**
     * Check Date.
     *
     * @Route("/avancesalairecheckDate/{idEmploye}", name="avancesalaire_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request        = $this->get('request');
        $date           = $request->query->get('date');

        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:AvanceSalaire')
            ->createQueryBuilder('a')
            ->select('a')
            ->where('a.employe =:idEmploye AND a.at =:date')
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
     * Creates a new AvanceSalaire entity.
     *
     * @Route("/avancesalaire/create", name="avancesalaire_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:AvanceSalaire:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new AvanceSalaire();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_avancesalaire');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');

            return $this->redirect($this->generateUrl('avancesalaire_show', array('id' => $entityEmploye->getId())));
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
            "entite"            => 'AVANCE SALAIRE',
            "date"              =>  $entity->getAt(),
            "periode"           =>  $entity->getPeriode(),
            "montant"           =>  $entity->getMontant(),
            "employe"           =>  $entity->getEmploye()->getNom()
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a AvanceSalaire entity.
     *
     * @param AvanceSalaire $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AvanceSalaire $entity)
    {
        $form = $this->createForm(new AvanceSalaireType(), $entity, array(
            'action' => $this->generateUrl('avancesalaire_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}/{idEmploye}", name="avancesalaire_print")
     * @Method("GET")
     * @Template("")
     */
    public function printAction($id, $idEmploye)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:AvanceSalaire')->find($id);
        $editForm   = $this->createEditForm($entity);
        $motif      = wordwrap($entity->getMotif(), 50, "\n", true);

        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        $date   = $entity->getAt();
        $dateEn = str_replace('/', '-', $date);
        $dt     = strftime("%B %Y", strtotime($dateEn));

//         afficher la date en français le tout complet
//        $dt = strftime("%A, %e %B %Y", strtotime($dateEn));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvanceSalaire entity.');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'success'       => $success,
            'motif'         => $motif,
            'idEmploye'     => $idEmploye,
            'date'          => $dt
        );
    }

    /**
     * Finds and displays a AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}", name="avancesalaire_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new AvanceSalaire();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:AvanceSalaire')->findBy(
            array('employe' => $id), array('at' => 'DESC'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvanceSalaire entity.');
        }

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success,
        );
    }



    /**
    * Creates a form to edit a AvanceSalaire entity.
    *
    * @param AvanceSalaire $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AvanceSalaire $entity)
    {
        $form = $this->createForm(new AvanceSalaireType(), $entity, array(
            'action' => $this->generateUrl('avancesalaire_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}", name="avancesalaire_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:AvanceSalaire:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:AvanceSalaire')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_avancesalaire');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvanceSalaire entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');

            return $this->redirect($this->generateUrl('avancesalaire_show', array('id' => $entityEmploye->getId(), 'success'=>'true')));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Valid AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}/{valid}/{idEmploye}", name="avancesalaire_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idEmploye)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:AvanceSalaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvanceSalaire entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('avancesalaire_show', array('id' => $idEmploye)));
    }

}
