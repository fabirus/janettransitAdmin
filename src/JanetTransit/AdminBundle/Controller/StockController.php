<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Stock;
use JanetTransit\AdminBundle\Form\StockType;

/**
 * Stock controller.
 *
 * @Route("/stock")
 */
class StockController extends Controller
{

    /**
     * Lists all Stock entities.
     *
     * @Route("/", name="stock")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JanetTransitAdminBundle:TypeStock')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Stock entity.
     *
     * @Route("/", name="stock_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Stock:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity             = new Stock();
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_stock');
        $idTypeStock        = $dataform['typeStock'];
        $entityTypeStock    = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($idTypeStock);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stock_show', array('id' => $idTypeStock)));
        }

        return array(
            'entity'            => $entity,
            'form'              => $form->createView(),
            'entityTypeStock'   => $entityTypeStock
        );
    }

    /**
     * Creates a form to create a Stock entity.
     *
     * @param Stock $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Stock $entity)
    {
        $form = $this->createForm(new StockType(), $entity, array(
            'action' => $this->generateUrl('stock_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Finds and displays a Stock entity.
     *
     * @Route("/{id}", name="stock_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity             = new Stock();
        $em                 = $this->getDoctrine()->getManager();
        $form               = $this->createCreateForm($entity);
        $entityTypeStock    = $em->getRepository('JanetTransitAdminBundle:TypeStock')->find($id);
        $entities           = $em->getRepository('JanetTransitAdminBundle:Stock')->findBy(
            array('typeStock' => $id)
        );

        return array(
            'entities'          => $entities,
            'form'              => $form->createView(),
            'entityTypeStock'   => $entityTypeStock
        );
    }

    /**
     * Displays a form to edit an existing Stock entity.
     *
     * @Route("/{id}/edit", name="stock_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idTypeStock)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'idTypeStock'=> $idTypeStock
        );
    }

    /**
    * Creates a form to edit a Stock entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Stock $entity)
    {
        $form = $this->createForm(new StockType(), $entity, array(
            'action' => $this->generateUrl('stock_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Stock entity.
     *
     * @Route("/{id}", name="stock_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Stock:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_stock');
        $idTypeStock        = $dataform['typeStock'];
        $entityTypeStock    = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idTypeStock);

        $entity = $em->getRepository('JanetTransitAdminBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('stock_show', array('id' => $idTypeStock)));
        }

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
    public function deleteAction($id, $del, $idRefresh){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('stock_edit',
            array(
                'id'          => $id,
                'idTypeStock' => $idRefresh,

            )));

    }

}
