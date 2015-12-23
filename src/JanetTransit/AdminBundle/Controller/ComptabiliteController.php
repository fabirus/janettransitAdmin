<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Comptabilite;
use JanetTransit\AdminBundle\Form\ComptabiliteType;
use Symfony\Component\HttpFoundation\Response;
/**
 * Comptabilite controller.
 *
 * @Route("/comptabilite")
 */
class ComptabiliteController extends Controller
{

    /**
     * Lists all Comptabilite entities.
     *
     * @Route("/", name="comptabilite")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Comptabilite();
        $form       = $this->createCreateForm($entity);

        $entities = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView()

        );
    }

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
        $em             = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->findBy(
            array('periode' => $date)
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
     * Creates a new Comptabilite entity.
     *
     * @Route("/", name="comptabilite_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Comptabilite:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Comptabilite();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comptabilite_informations'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Comptabilite entity.
     *
     * @param Comptabilite $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Comptabilite $entity)
    {
        $form = $this->createForm(new ComptabiliteType(), $entity, array(
            'action' => $this->generateUrl('comptabilite_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Comptabilite entity.
     *
     * @Route("/{id}", name="comptabilite_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }


        return array(
            'entity'   => $entity,
        );
    }


    /**
     * Finds and displays a Comptabilite Manutention entities.
     *
     * @Route("/{id}", name="comptabilite_manutention")
     * @Method("GET")
     * @Template()
     */
    public function manutentionAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $percu          = 0;
        $fraisRoute     = 0;
        $carburation    = 0;
        $stationnement  = 0;
        $entity         = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Facture')->findByPeriodeBuilder($entity->getPeriode());
        $mouvementsE    = $em->getRepository('JanetTransitAdminBundle:Facture')->findByMouvementEffectueBuilder($entity->getPeriode(), 0);
        $mouvementsN    = $em->getRepository('JanetTransitAdminBundle:Facture')->findByMouvementEffectueBuilder($entity->getPeriode(), 1);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }

        foreach($entities as $manutention){

            $percu += $manutention->getPercu();
            $fraisRoute += $manutention->getFraisRoute();
            $carburation += $manutention->getCarburation();
            $stationnement += $manutention->getStationnement();
        }

        return array(
            'entities'      => $entities,
            'entity'        => $entity,
            'percu'         => $percu,
            'stationnement' =>$stationnement,
            'fraisRoute'    => $fraisRoute,
            'carburation'   => $carburation,
            'mouvementE'    => $mouvementsE,
            'mouvementN'    => $mouvementsN,
        );
    }


    /**
     * Finds and displays a Comptabilite Catburation entities.
     *
     * @Route("/{id}", name="comptabilite_carburation")
     * @Method("GET")
     * @Template()
     */
    public function carburationAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $paye           = 0;
        $Nonpaye        = 0;
        $total          = 0;
        $entity         = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Carburation')->findByPeriodeBuilder($entity->getPeriode());
        $entitiesP      = $em->getRepository('JanetTransitAdminBundle:Carburation')->findByCarburationValidBuilder($entity->getPeriode(), 0);
        $entitiesN      = $em->getRepository('JanetTransitAdminBundle:Carburation')->findByCarburationValidBuilder($entity->getPeriode(), 1);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }

        foreach($entitiesP as $paie){

            $paye += $paie->getMontant();
        }

        foreach($entitiesN as $nonPaie){

            $Nonpaye += $nonPaie->getMontant();
        }

        foreach($entities as $depense){

            $total += $depense->getMontant();
        }

        return array(
            'entities'      => $entities,
            'entity'        => $entity,
            'paye'          => $paye,
            'Nonpaye'       => $Nonpaye,
            'total'         => $total
        );
    }

    /**
     * Finds and displays a Comptabilite Depense entities.
     *
     * @Route("/{id}", name="comptabilite_depense")
     * @Method("GET")
     * @Template()
     */
    public function depenseAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $paye           = 0;
        $Nonpaye        = 0;
        $total          = 0;
        $resultTotal    = [];
        $entity         = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);
        $typeDepnse     = $em->getRepository('JanetTransitAdminBundle:TypeDepense')->findAll();
        $entities       = $em->getRepository('JanetTransitAdminBundle:Depense')->findByPeriodeBuilder($entity->getPeriode());
        $entitiesP      = $em->getRepository('JanetTransitAdminBundle:Depense')->findByDepenseValidBuilder($entity->getPeriode(), 0);
        $entitiesN      = $em->getRepository('JanetTransitAdminBundle:Depense')->findByDepenseValidBuilder($entity->getPeriode(), 1);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }

        foreach($entitiesP as $paie){

            $paye += $paie->getMontant();
        }

        foreach($entitiesN as $nonPaie){

            $Nonpaye += $nonPaie->getMontant();
        }

        foreach($entities as $depense){

            $total += $depense->getMontant();
        }

        foreach($typeDepnse as $tdepense){
            $resultTotal[$tdepense->getNom()] = $em->getRepository('JanetTransitAdminBundle:Depense')->findByDepenseByTypeBuilder($entity->getPeriode(), $tdepense->getNom());
        }

        return array(
            'entities'      => $entities,
            'entity'        => $entity,
            'paye'          => $paye,
            'Nonpaye'       => $Nonpaye,
            'total'         => $total,
            'resultat'      => $resultTotal
        );
    }

    /**
     * Displays a form to edit an existing Comptabilite entity.
     *
     * @Route("/{id}/edit", name="comptabilite_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Comptabilite entity.
    *
    * @param Comptabilite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comptabilite $entity)
    {
        $form = $this->createForm(new ComptabiliteType(), $entity, array(
            'action' => $this->generateUrl('comptabilite_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Comptabilite entity.
     *
     * @Route("/{id}", name="comptabilite_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Comptabilite:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comptabilite_informations'));

        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Data entity.
     *
     * @Route("/{id}", name="data_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Comptabilite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comptabilite entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('comptabilite_informations'));
    }

}
