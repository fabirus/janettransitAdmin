<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\MouvementStock;
use JanetTransit\AdminBundle\Form\MouvementStockType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * MouvementStock controller.
 *
 * @Route("/mouvementstock")
 */
class MouvementStockController extends Controller
{

    /**
     * Lists all MouvementStock entities.
     *
     * @Route("/", name="mouvementstock")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($idPeriode, $idStock, $idTypeStock)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new MouvementStock();
        $form           = $this->createCreateForm($entity);
        $stock          = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);
        $typeStock      = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($idTypeStock);
        $periodeStock   = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->find($idPeriode);


        $entities = $em->getRepository('JanetTransitAdminBundle:MouvementStock')->findBy(
            array('periodeStock' => $idPeriode)
        );

        return array(
            'entities'      => $entities,
            'form'          => $form->createView(),
            'stock'         => $stock,
            'typeStock'     => $typeStock,
            'periodeStock'  => $periodeStock

        );
    }
    /**
     * Creates a new MouvementStock entity.
     *
     * @Route("/", name="mouvementstock_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:MouvementStock:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_mouvementstock');
        $idPeriodeStock     = $dataform['periodeStock'];
        $idStock            = $request->request->get('stock');
        $idTypeStock        = $request->request->get('typeStock');
        $entityStock        = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);
        $entityTypeStock    = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($idTypeStock);
        $entity             = new MouvementStock();
        $form               = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');


            if( $entity->getType() == 'achat'){
                $this->mouvementAchat($em, $entityStock, $entity->getQte());
            }
            else if($entity->getType() == 'retour') {
                $this->mouvementRetour($em, $entityStock, $entity->getQte());
            }
            else{
                $this->mouvementSortie($em, $entityStock, $entity->getQte());
            }

            return $this->redirect($this->generateUrl('mouvementstock_informations', array(
                'idPeriode'     => $idPeriodeStock,
                'idStock'       => $idStock,
                'idTypeStock'   => $idTypeStock

            )));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    public function mouvementRetour($em, $entityStock, $qte){
        $newQte = $entityStock->getQteStock() + $qte;
        $entityStock->setQteStock($newQte);
        $em->flush();
    }

    public function mouvementAchat($em, $entityStock, $qte){
        $newQte = $entityStock->getQteInitial() + $qte;
        $entityStock->setQteInitial($newQte);
        $em->flush();
    }

    public function mouvementSortie($em, $entityStock, $qte){
        $newQte = $entityStock->getQteStock() - $qte;
        $entityStock->setQteStock($newQte);
        $em->flush();
    }


    /**
     * Operation Create Entity
     */

    public function operationUpdate($entity, $action) {
        $user  = $this->get('security.context')->getToken()->getUser();
        $data   = array(
            "id"                =>  $entity->getId(),
            "entite"            => 'MVT STOCK',
            'mouvement'         =>  $entity->getType(),
            "heure"             =>  $entity->getHeureMouvement(),
            'qte'               =>  $entity->getQte(),
            "date"              =>  $entity->getPeriodeStock()->getDatePeriode(),
            "employe"           =>  ($entity->getEmploye() !== NULL ) ? $entity->getEmploye()->getNom() : 'aucun'
        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Creates a form to create a MouvementStock entity.
     *
     * @param MouvementStock $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MouvementStock $entity)
    {
        $form = $this->createForm(new MouvementStockType(), $entity, array(
            'action' => $this->generateUrl('mouvementstock_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing MouvementStock entity.
     *
     * @Route("/{id}/edit", name="mouvementstock_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idPeriode, $idStock, $idTypeStock)
    {
        $em             = $this->getDoctrine()->getManager();
        $stock          = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);
        $typeStock      = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($idTypeStock);
        $periodeStock   = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->find($idPeriode);

        $entity = $em->getRepository('JanetTransitAdminBundle:MouvementStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementStock entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'stock'         => $stock,
            'typeStock'     => $typeStock,
            'periodeStock'  => $periodeStock
        );
    }

    /**
    * Creates a form to edit a MouvementStock entity.
    *
    * @param MouvementStock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MouvementStock $entity)
    {
        $form = $this->createForm(new MouvementStockType(), $entity, array(
            'action' => $this->generateUrl('mouvementstock_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MouvementStock entity.
     *
     * @Route("/{id}", name="mouvementstock_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:MouvementStock:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_mouvementstock');
        $idPeriodeStock     = $dataform['periodeStock'];
        $idStock            = $request->request->get('stock');
        $idTypeStock        = $request->request->get('typeStock');
        $entityStock        = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);

        $entity = $em->getRepository('JanetTransitAdminBundle:MouvementStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementStock entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');

            if( $entity->getType() == 'achat'){
                $this->mouvementAchat($em, $entityStock, $entity->getQte());
            }
            else if($entity->getType() == 'retour') {
                $this->mouvementRetour($em, $entityStock, $entity->getQte());
            }
            else{
                $this->mouvementSortie($em, $entityStock, $entity->getQte());
            }

            return $this->redirect($this->generateUrl('mouvementstock_informations', array(
                'idPeriode'     => $idPeriodeStock,
                'idStock'       => $idStock,
                'idTypeStock'   => $idTypeStock

            )));        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Voiture entity.
     *
     * @Route("/{id}", name="voiture_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del, $idRefresh, $idRefresh2, $idRefresh3){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:MouvementStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementStock entity.');
        }
        $entity->setDel($del);
        $em->flush();
        if ($del == 1) {
            $this->operationUpdate($entity, 'SUPPRESSION');
        }

        return $this->redirect($this->generateUrl('mouvementstock_informations',
            array(
                'id'          => $id,
                'idPeriode'   => $idRefresh3,
                'idStock'     => $idRefresh,
                'idTypeStock' => $idRefresh2

            )));

    }

}
