<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Depense;
use JanetTransit\AdminBundle\Form\DepenseType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

/**
 * Depense controller.
 *
 * @Route("/depense")
 */
class DepenseController extends Controller
{

    /**
     * Lists all Depense entities.
     *
     * @Route("/", name="depense")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entities   = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findTypeMecaniqueQueryBuilder();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all TypeDepense entities.
     *
     * @Route("/", name="typedepense")
     * @Method("GET")
     * @Template()
     */
    public function typeDepenseAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JanetTransitAdminBundle:TypeDepense')->findAll();

        return array(
            'entities'  => $entities,
            'contratId' => $id
        );
    }


    /**
     * Creates a new Depense entity.
     *
     * @Route("/", name="depense_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Depense:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em                 = $this->getDoctrine()->getManager();
        $entity             = new Depense();
        $dataform           = $request->request->get('janettransit_adminbundle_depense');
        $idPeriodeDepense   = $dataform['periodeDepense'];
        $idContrat          = $request->request->get('contrat');
        $idTypeDepense      = $request->request->get('depense');
        $form               = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            return $this->redirect($this->generateUrl('depense_show',
                array(
                    'idPeriodeDepense' => $idPeriodeDepense,
                    'idContrat'        => $idContrat,
                    'idTypeDepense'    => $idTypeDepense

                )));
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
            "entite"            => 'DEPENSE',
            "materiel"          =>  $entity->getMateriel(),
            "voiture"           =>  ($entity->getVoiture() !== NULL ) ? $entity->getVoiture()->getImmatricule() : 'aucune',
            "montant"           =>  $entity->getMontant(),
            "Date"              =>  $entity->getPeriodeDepense()->getDateDepense(),
            "employe"           =>  ($entity->getEmploye() !== NULL ) ? $entity->getEmploye()->getNom() : 'aucun'
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Valid AvanceSalaire entity.
     *
     * @Route("/avancesalaire/{id}/{valid}/{idEmploye}", name="avancesalaire_valid")
     * @Method("VALID")
     */
    public function validAction($id, $valid, $idPeriodeDepense, $idContrat, $idTypeDepense)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Depense')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depense entity.');
        }
        $entity->setValid($valid);
        $em->flush();

        return $this->redirect($this->generateUrl('depense_show',
            array(
                'idPeriodeDepense' => $idPeriodeDepense,
                'idContrat'        => $idContrat,
                'idTypeDepense'    => $idTypeDepense

            )));
    }

    /**
     * Creates a form to create a Depense entity.
     *
     * @param Depense $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Depense $entity)
    {
        $form = $this->createForm(new DepenseType(), $entity, array(
            'action' => $this->generateUrl('depense_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a Depense entity.
     *
     * @Route("/{id}", name="depense_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($idPeriodeDepense, $idContrat, $idTypeDepense)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new Depense();
        $form           = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Depense')->findBy(
            array('periodeDepense' => $idPeriodeDepense)
        );

        $entityPeriode = $em->getRepository('JanetTransitAdminBundle:PeriodeDepense')->find($idPeriodeDepense);

        return array(
            'entities'          => $entities,
            'entityPeriode'     => $entityPeriode,
            'form'              => $form->createView(),
            'idContrat'         => $idContrat,
            'idTypeDepense'     => $idTypeDepense
        );
    }

    /**
     * Displays a form to edit an existing Depense entity.
     *
     * @Route("/{id}/edit", name="depense_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idPeriodeDepense, $idContrat, $idTypeDepense)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Depense')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depense entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'            => $entity,
            'edit_form'         => $editForm->createView(),
            'idPeriodeDepense'  => $idPeriodeDepense,
            'idTypeDepense'     => $idTypeDepense,
            'idContrat'        => $idContrat
        );
    }

    /**
    * Creates a form to edit a Depense entity.
    *
    * @param Depense $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Depense $entity)
    {
        $form = $this->createForm(new DepenseType(), $entity, array(
            'action' => $this->generateUrl('depense_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Depense entity.
     *
     * @Route("/{id}", name="depense_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Depense:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_depense');
        $idPeriodeDepense   = $dataform['periodeDepense'];
        $idContrat          = $request->request->get('contrat');
        $idTypeDepense      = $request->request->get('depense');

        $entity = $em->getRepository('JanetTransitAdminBundle:Depense')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depense entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');


            return $this->redirect($this->generateUrl('depense_show',
                array(
                    'idPeriodeDepense' => $idPeriodeDepense,
                    'idContrat'        => $idContrat,
                    'idTypeDepense'    => $idTypeDepense

                )));
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
                $entities   = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findTypeMecaniqueSearchQueryBuilder($searchText);
            }
            else {
                $entities = $em->getRepository('JanetTransitAdminBundle:ContratEts')->findTypeMecaniqueQueryBuilder();
            }

            $json['view'] = $this->renderView('JanetTransitAdminBundle:Depense:search.html.twig',
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
     * Deletes a Voiture entity.
     *
     * @Route("/{id}", name="voiture_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del, $idRefresh, $idRefresh2, $idRefresh3){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Depense')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depense entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1) {
            $this->operationUpdate($entity, 'SUPPRESSION');
        }

            return $this->redirect($this->generateUrl('depense_show',
            array(
                'idPeriodeDepense' => $idRefresh,
                'idContrat'        => $idRefresh2,
                'idTypeDepense'    => $idRefresh3

            )));

//        return $this->redirect($this->generateUrl('depense_show', array('idPeriodeDepense' => $idRefresh)));
    }

}
