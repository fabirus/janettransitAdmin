<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Document;
use JanetTransit\AdminBundle\Form\DocumentType;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{

    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id, $idType)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = new Document();
        $form           = $this->createCreateForm($entity);
        $voiture        = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($id);
        $typeVoiture    = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->find($idType);

        $entities = $em->getRepository('JanetTransitAdminBundle:Document')->findBy(
            array('voiture' => $id)
        );

        return array(
            'entities'      => $entities,
            'voiture'       => $voiture,
            'typeVoiture'   => $typeVoiture,
            'form'          => $form->createView(),
        );
    }
    /**
     * Creates a new Document entity.
     *
     * @Route("/", name="document_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Document:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity             = new Document();
        $em                 = $this->getDoctrine()->getManager();
        $dataform           = $request->request->get('janettransit_adminbundle_document');
        $id                 = $dataform['voiture'];
        $idType             = $request->request->get('janettransit_adminbundle_voiture')['typeVoiture'];
        $entityVoiture      = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($id);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('document_informations',
                array('id' => $entityVoiture->getId(),
                    'idType' => $idType
                )));
        }

        return array(
            'entity'        => $entity,
            'form'          => $form->createView(),
            'voiture'       => $entityVoiture
        );
    }

    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $idVoiture, $idType)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:Document')->find($id);
        $entityVoiture  = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($idVoiture);
        $entityType     = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->find($idType);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'voiture'     => $entityVoiture,
            'typeVoiture' => $entityType
        );
    }

    /**
    * Creates a form to edit a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Document entity.
     *
     * @Route("/{id}", name="document_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Document:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em                 = $this->getDoctrine()->getManager();
        $entity             = $em->getRepository('JanetTransitAdminBundle:Document')->find($id);
        $dataform           = $request->request->get('janettransit_adminbundle_document');
        $id                 = $dataform['voiture'];
        $idType             = $request->request->get('janettransit_adminbundle_voiture')['typeVoiture'];
        $entityVoiture      = $em->getRepository('JanetTransitAdminBundle:Voiture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('document_informations',
                array('id' => $entityVoiture->getId(),
                    'idType' => $idType
                )));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del){

        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }
        $entity->setDel($del);
        $em->flush();

        return $this->redirect($this->generateUrl('typevoiture_informations'));
    }



}
