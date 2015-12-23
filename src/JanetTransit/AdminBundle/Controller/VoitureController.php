<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Voiture;
use JanetTransit\AdminBundle\Form\VoitureType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Voiture controller.
 *
 * @Route("/voiture")
 */
class VoitureController extends Controller
{

    /**
     * Lists all Voiture entities.
     *
     * @Route("/", name="voiture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new Voiture();
        $form           = $this->createCreateForm($entity);
        $typeVoiture    = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:Voiture')->findBy(
            array('typeVoiture' => $id)
        );

        return array(
            'entities'      => $entities,
            'typeVoiture'   => $typeVoiture,
            'form'          => $form->createView(),
        );
    }
    /**
     * Creates a new Voiture entity.
     *
     * @Route("/", name="voiture_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Voiture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new Voiture();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_voiture');
        $idType         = $dataform['typeVoiture'];
        $entityType     = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->find($idType);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('voiture_informations', array('id' => $entityType->getId())));
        }

        return array(
            'entity'        => $entity,
            'form'          => $form->createView(),
            'typeVoiture'   => $entityType
        );
    }

    /**
     * Creates a form to create a Voiture entity.
     *
     * @param Voiture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Voiture $entity)
    {
        $form = $this->createForm(new VoitureType(), $entity, array(
            'action' => $this->generateUrl('voiture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing Voiture entity.
     *
     * @Route("/{id}/edit", name="voiture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idType)
    {
        $em = $this->getDoctrine()->getManager();

        $entity     = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($id);
        $entityType = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->find($idType);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Voiture entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'typeVoiture' => $entityType
        );
    }

    /**
    * Creates a form to edit a Voiture entity.
    *
    * @param Voiture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Voiture $entity)
    {
        $form = $this->createForm(new VoitureType(), $entity, array(
            'action' => $this->generateUrl('voiture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Voiture entity.
     *
     * @Route("/{id}", name="voiture_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Voiture:edit.html.twig")
     */
    public function updateAction(Request $request, $id){

        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_voiture');
        $idType         = $dataform['typeVoiture'];
        $entityType     = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->find($idType);

        $entity = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Voiture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('voiture_informations', array('id' => $entityType->getId())));
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
    public function deleteAction($id, $del){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Voiture entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('typevoiture_informations'));
    }

}
