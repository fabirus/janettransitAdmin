<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Contrat;
use JanetTransit\AdminBundle\Form\ContratType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Contrat controller.
 *
 * @Route("/contrat")
 */
class ContratController extends Controller
{
    /**
     * Check Date.
     *
     * @Route("/fichedepaiecheckDate/{idEmploye}", name="fichedepaie_checkDate")
     * @Method("GET")
     * @Template()
     */
    public function checkDateAction($idEmploye){

        $request        = $this->get('request');
        $date           = $request->query->get('date');

        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:Contrat')
            ->createQueryBuilder('a')
            ->select('a')
            ->where('a.employe =:idEmploye AND (a.dateDebut =:date OR a.dateFin =:date) ')
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
     * Creates a new Contrat entity.
     *
     * @Route("/", name="contrat_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Contrat:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new Contrat();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_contrat');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);


        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('contrat_show', array('id' => $entityEmploye->getId())));
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
            "entite"            => 'CONTRAT',
            "dateDebut"         => $entity->getDateDebut(),
            "dateFin"           => $entity->getDateFin(),
            "duree"             => $entity->getDuree(),
            "typeContrat"       => $entity->getTypeContrat(),
            'employe'           => $entity->getEmploye()->getNom(),
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a Contrat entity.
     *
     * @param Contrat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Contrat $entity)
    {
        $form = $this->createForm(new ContratType(), $entity, array(
            'action' => $this->generateUrl('contrat_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a Sanction entity.
     *
     * @Route("/contrat/{id}/{idEmploye}", name="contrat_print")
     * @Method("GET")
     * @Template("")
     */
    public function printAction($id, $idEmploye)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:Contrat')->find($id);
        $editForm   = $this->createEditForm($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sanction entity.');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'success'       => $success,
            'idEmploye'     => $idEmploye
        );
    }


    /**
     * Finds and displays a Contrat entity.
     *
     * @Route("/{id}", name="contrat_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $entity     = new Contrat();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Contrat')->findBy(
            array('employe' => $id), array('dateDebut' => 'DESC'));


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrat entity.');
        }

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success,
        );
    }

    /**
     * Displays a form to edit an existing Contrat entity.
     *
     * @Route("/{id}/edit", name="contrat_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Contrat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrat entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Contrat entity.
    *
    * @param Contrat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contrat $entity)
    {
        $form = $this->createForm(new ContratType(), $entity, array(
            'action' => $this->generateUrl('contrat_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contrat entity.
     *
     * @Route("/{id}", name="contrat_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Contrat:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:Contrat')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_contrat');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrat entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('contrat_show', array('id' => $entityEmploye->getId(), 'success'=>'true')));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
//    /**
//     * Deletes a Contrat entity.
//     *
//     * @Route("/{id}", name="contrat_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, $id)
//    {
//        $form = $this->createDeleteForm($id);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $entity = $em->getRepository('JanetTransitAdminBundle:Contrat')->find($id);
//
//            if (!$entity) {
//                throw $this->createNotFoundException('Unable to find Contrat entity.');
//            }
//
//            $em->remove($entity);
//            $em->flush();
//        }
//
//        return $this->redirect($this->generateUrl('contrat'));
//    }

}
