<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\ContratEts;
use JanetTransit\AdminBundle\Form\ContratEtsType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

/**
 * ContratEts controller.
 *
 * @Route("/contratets")
 */
class ContratEtsController extends Controller
{

    /**
     * Lists all ContratEts entities.
     *
     * @Route("/", name="contratets")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em       = $this->getDoctrine()->getManager();
        $entity   = new ContratEts();
        $form     = $this->createCreateForm($entity);
        $entities = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
        );
    }
    /**
     * Creates a new ContratEts entity.
     *
     * @Route("/", name="contratets_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:ContratEts:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = new ContratEts();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');

            return $this->redirect($this->generateUrl('contratets_informations'));
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
            "id"                => $entity->getId(),
            "entite"            => 'CONTRAT ETS',
            'nom'               => $entity->getNom(),
            "adresse"           => $entity->getAdresse(),
            "representant"      => $entity->getRepresentant(),
            "telephone"         => $entity->getTel(),
            "email"             => $entity->getEmail()
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a ContratEts entity.
     *
     * @param ContratEts $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ContratEts $entity)
    {
        $form = $this->createForm(new ContratEtsType(), $entity, array(
            'action' => $this->generateUrl('contratets_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a ContratEts entity.
     *
     * @Route("/{id}", name="contratets_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = $em->getRepository('JanetTransitAdminBundle:ContratEts')->find($id);
        $editForm   = $this->createEditForm($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContratEts entity.');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),

        );
    }


    /**
    * Creates a form to edit a ContratEts entity.
    *
    * @param ContratEts $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContratEts $entity)
    {
        $form = $this->createForm(new ContratEtsType(), $entity, array(
            'action' => $this->generateUrl('contratets_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContratEts entity.
     *
     * @Route("/{id}", name="contratets_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:ContratEts:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:ContratEts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContratEts entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('contratets_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Find ContratEts entities.
     *
     * @Route("/recherche/contratets", name="contratetssearch")
     * @Method("GET")
     * @Template()
     */
    public function searchAction(){

        $request    = $this->get('request');
        $json       = array();
        $searchText = '';
        $searchText = $request->query->get('searchText');
        $em         = $this->getDoctrine()->getManager();

        if($request->isXmlHttpRequest()) {

            if ($searchText !== '') {
                $entities   = $em->getRepository('JanetTransitAdminBundle:ContratEts')->search($searchText);
            }
            else {
                $entities = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findAll();
            }

            $json['view'] = $this->renderView('JanetTransitAdminBundle:ContratEts:search.html.twig',
                array(
                    'entities' => $entities,
                    'searchText' => $searchText
                ));

            $response = new Response(json_encode($json));
            return $response;
        }
        else{
            $this->indexAction();

        }
    }
    /**
     * Deletes a ContratEts entity.
     *
     * @Route("/{id}", name="contratets_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:ContratEts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContratEts entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1){
            $this->operationUpdate($entity, 'SUPPRESSION');
        }

        return $this->redirect($this->generateUrl('contratets_informations'));
    }

}
