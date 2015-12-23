<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Repository;
use JanetTransit\AdminBundle\Entity\Employe;
use JanetTransit\AdminBundle\Form\EmployeType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Employe controller.
 *
 * @Route("/employe")
 */
class EmployeController extends Controller
{

    /**
     * Lists all Employe entities.
     *
     * @Route("/", name="employe")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em         = $this->getDoctrine()->getManager();
        $entity     = new Employe();
        $form       = $this->createCreateForm($entity);

//        $entities   = $em->getRepository('JanetTransitAdminBundle:Employe')->findBy(array('del' => 0));
        $entities   = $em->getRepository('JanetTransitAdminBundle:Employe')->findAll();

        return array(
            'entities' => $entities,
            'form'     => $form->createView(),
            'success'  => $success
        );

    }
    /**
     * Creates a new Employe entity.
     *
     * @Route("/employe/create", name="employe_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:Employe:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity     = new Employe();
        $form       = $this->createCreateForm($entity);
        $em         = $this->getDoctrine()->getManager();
        $matricule  = $this->generateMatricule();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $entity->setUpdatedAt(new DateTime());
            $entity->setMatricule($matricule);
            $em->persist($entity);
            $em->flush();
            $this->operationUpdate($entity, 'CREATION');

            return $this->redirect($this->generateUrl('employe_informations', array('success'=>'true')));
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
            "entite"            => 'EMPLOYE',
            "nom"               =>  $entity->getNom(),
            "prenom"            =>  $entity->getPrenom(),
            "telephome"         =>  $entity->getTel(),
            "poste"             =>  $action == 'SUPPRESSION' ? 'none' : $entity->getPoste(),
            "service"           =>  $action == 'SUPPRESSION' ? 'none' : $entity->getServices(),
            "adresse"           =>  $entity->getAdresse(),
            "sexe"              =>  $entity->getSexe(),
            "dateEmbauche"      =>  $entity->getDateEmbauche(),
            "dateNaissance"     =>  $entity->getDateNaissance(),
            "villeNaissance"    =>  $entity->getVilleNaissance(),
            "email"             =>  $entity->getEmail(),
            "salaire"           =>  $entity->getSalaire()

        );

        $this->get('application.operation')->update($data, $user, $action);

    }

    /**
     * Generate Matricule
     * Return Matricule
     */
    public function generateMatricule(){
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];
//        echo '0000'.$rand;
        return '0000'.$rand;
    }

    /**
     * Creates a form to create a Employe entity.
     *
     * @param Employe $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Employe $entity)
    {
        $form = $this->createForm(new EmployeType(), $entity, array(
            'action' => $this->generateUrl('employe_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Find Employe entities.
     *
     * @Route("/recherche/employe", name="employe_search")
     * @Method("GET")
     * @Template()
     */
    public function searchAction(){

        $request    = $this->get('request');
        $json       = array();
        $searchText = '';
        $searchText = $request->query->get('searchText');
        $em         = $this->getDoctrine()->getManager();
        $select     = array(
            'searchText'    => $searchText,
            'entity'        => 'JanetTransitAdminBundle:Employe',
            'select'        => 'e',
            'where'         => 'e.nom LIKE :searchText OR e.prenom LIKE :searchText',
            'orderBy'       => 'e.nom', 'ASC',
        );
        if($request->isXmlHttpRequest()) {

            if ($searchText !== '') {
                $entities = $this->get('projet.search')->search($select);
            }
            else {
                $entities = $em->getRepository('JanetTransitAdminBundle:Employe')->findAll();
            }

            $json['view'] = $this->renderView('JanetTransitAdminBundle:Employe:search.html.twig',
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
     * Finds and displays a Employe entity.
     *
     * @Route("/employe/{id}", name="employe_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);

        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Employe entity.');
        }
        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'success'     => $success
        );
    }

    /**
    * Creates a form to edit a Employe entity.
    *
    * @param Employe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Employe $entity)
    {
        $form = $this->createForm(new EmployeType(), $entity, array(
            'action' => $this->generateUrl('employe_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Employe entity.
     *
     * @Route("/employe/{id}", name="employe_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Employe:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();
            $this->operationUpdate($entity, 'MODIFICATION');

            return $this->redirect($this->generateUrl('employe_show', array('id' => $id, 'success' => 'true')));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Employe entity.
     *
     * @Route("/employe/delete/{id}/{del}", name="employe_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id, $del)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employe entity.');
        }

        $entity->setDel($del);
        $em->flush();
        if ($del == 1){
            $this->operationUpdate($entity, 'SUPPRESSION');
        }




        return $this->redirect($this->generateUrl('employe_informations'));
    }

}
