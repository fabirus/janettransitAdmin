<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\PeriodeStock;
use JanetTransit\AdminBundle\Form\PeriodeStockType;
use Symfony\Component\HttpFoundation\Response;
/**
 * PeriodeStock controller.
 *
 * @Route("/periodestock")
 */
class PeriodeStockController extends Controller
{

    /**
     * Lists all PeriodeStock entities.
     *
     * @Route("/", name="periodestock")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($idStock, $idTypeStock)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new PeriodeStock();
        $form           = $this->createCreateForm($entity);
        $stock          = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);
        $typeStock      = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($idTypeStock);


        $entities = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->findBy(
            array('stock' => $idStock)
        );

        return array(
            'entities'  => $entities,
            'form'      => $form->createView(),
            'stock'     => $stock,
            'typeStock' => $typeStock
        );
    }
    /**
     * Creates a new PeriodeStock entity.
     *
     * @Route("/", name="periodestock_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:PeriodeStock:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_periodestock');
        $idStock            = $dataform['stock'];
        $idTypeStock        = $request->request->get('typeStock');
        $entityStock        = $em->getRepository('JanetTransitAdminBundle:Stock')->find($idStock);
        $entityTypeStock    = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($idTypeStock);
        $entity             = new PeriodeStock();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('periodestock_informations',
                array(
                    'idStock'       => $idStock,
                    'idTypeStock'   => $idTypeStock

                )));
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'typeStock' => $entityTypeStock,
            'stock'     => $entityStock

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

        $entities   = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->findBy(
            array('stock' => $idEmploye, 'datePeriode' => $date, 'del' =>0)
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
     * Creates a form to create a PeriodeStock entity.
     *
     * @param PeriodeStock $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PeriodeStock $entity)
    {
        $form = $this->createForm(new PeriodeStockType(), $entity, array(
            'action' => $this->generateUrl('periodestock_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing PeriodeStock entity.
     *
     * @Route("/{id}/edit", name="periodestock_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idStock, $idTypeStock)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeStock entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'idStock'     => $idStock,
            'idTypeStock' => $idTypeStock
        );
    }

    /**
    * Creates a form to edit a PeriodeStock entity.
    *
    * @param PeriodeStock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PeriodeStock $entity)
    {
        $form = $this->createForm(new PeriodeStockType(), $entity, array(
            'action' => $this->generateUrl('periodestock_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PeriodeStock entity.
     *
     * @Route("/{id}", name="periodestock_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:PeriodeStock:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_periodestock');
        $idStock            = $dataform['stock'];
        $idTypeStock        = $request->request->get('typeStock');

        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeStock entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('periodestock_informations',
                array(
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
    public function deleteAction($id, $del, $idRefresh, $idRefresh2){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:PeriodeStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PeriodeStock entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('periodestock_edit',
            array(
                'id'                => $id,
                'idStock'           => $idRefresh,
                'idTypeStock'       => $idRefresh2

            )));

    }

}
