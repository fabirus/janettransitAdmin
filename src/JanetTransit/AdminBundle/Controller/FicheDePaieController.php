<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\FicheDePaie;
use JanetTransit\AdminBundle\Form\FicheDePaieType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

/**
 * FicheDePaie controller.
 *
 * @Route("/fichedepaie")
 */
class FicheDePaieController extends Controller
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
            ->getRepository('JanetTransitAdminBundle:FicheDePaie')
            ->createQueryBuilder('a')
            ->select('a')
            ->where('a.employe =:idEmploye AND a.periode =:date')
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
     * Creates a new FicheDePaie entity.
     *
     * @Route("/", name="fichedepaie_create")
     * @Method("POST")
     * @Template("JanetTransitAdminBundle:FicheDePaie:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity         = new FicheDePaie();
        $em             = $this->getDoctrine()->getManager();
        $dataform       = $request->request->get('janettransit_adminbundle_fichedepaie');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);


        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fichedepaie_show', array('id' => $entityEmploye->getId())));
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'employe'   => $entityEmploye,
        );
    }

    /**
     * Creates a form to create a FicheDePaie entity.
     *
     * @param FicheDePaie $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FicheDePaie $entity)
    {
        $form = $this->createForm(new FicheDePaieType(), $entity, array(
            'action' => $this->generateUrl('fichedepaie_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a FicheDepaie entity.
     *
     * @Route("/fichedepaie/{id}/{idEmploye}", name="fichedepaie_print")
     * @Method("GET")
     * @Template("")
     */
    public function printAction($id, $idEmploye)
    {
        $request            = $this->get('request');
        $success            = $request->query->get('success');
        $em                 = $this->getDoctrine()->getManager();
        $entity             = $em->getRepository('JanetTransitAdminBundle:FicheDePaie')->find($id);
        $prime              = $em->getRepository('JanetTransitAdminBundle:Prime')->findOneBy(
            array(
                'employe' => $idEmploye,
                'periode' => $entity->getPeriode(),
                'valid'   => 0
                )
        );
        $avanceSalaire  = $em->getRepository('JanetTransitAdminBundle:AvanceSalaire')->findOneBy(
            array(
                'employe' => $idEmploye,
                'periode' => $entity->getPeriode(),
                'valid'   => 0
            )
        );
        $absences           = $this->absence($entity, $idEmploye);
        $retenuSalire       = $this->sanction($entity, $idEmploye);
        $nbreJoursTravail   = $this->daysofWeek($entity, $idEmploye) * 4;

        $editForm = $this->createEditForm($entity);

        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        $date   = '5/'.$entity->getPeriode();
        $dateEn = str_replace('/', '-', $date);
        $dt     = strftime("%B %Y", strtotime($dateEn));

//         afficher la date en français le tout complet
//        $dt = strftime("%A, %e %B %Y", strtotime($dateEn));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvanceSalaire entity.');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'success'       => $success,
            'idEmploye'     => $idEmploye,
            'date'          => $dt,
            'prime'         => $prime,
            'avanceSalaire' => $avanceSalaire,
            'absences'      => count($absences),
            'retenuSalire'  => $retenuSalire,
            'joursTravail'  => $nbreJoursTravail,
        );
    }

    /**
     * Return Absence
     */

    public function absence($entity, $idEmploye){
        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:Presence')
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.employe =:idEmploye AND p.at LIKE :date AND p.statut =:absent')
            ->setParameters(array('date' => '%'.$entity->getPeriode().'%','idEmploye' => $idEmploye, 'absent' => 'absent'))
            ->getQuery();

        $results = $query->getArrayResult();

        return $results;
    }

    /**
     * Return Nbre de jours de travail hebdomadaire
     */

    public function daysofWeek($entity, $idEmploye){
        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:Contrat')
            ->createQueryBuilder('c')
            ->select('c')
            ->where('c.employe =:idEmploye AND c.dateDebut LIKE :date')
            ->orderBy('c.dateDebut', 'DESC')
            ->setMaxResults(1)
            ->setParameters(array('date' => '%'.$entity->getPeriode().'%','idEmploye' => $idEmploye))
            ->getQuery();

        $results = $query->getArrayResult();

//        var_dump($results);

        return $results[0]['duree'];
    }

    /**
     * Return Sanction Montant
     */

    public function sanction($entity, $idEmploye){
        $query = $this->getDoctrine()
            ->getRepository('JanetTransitAdminBundle:Sanction')
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.employe =:idEmploye AND p.dateSanction LIKE :date AND p.valid = 0')
            ->setParameters(array('date' => '%'.$entity->getPeriode().'%','idEmploye' => $idEmploye))
            ->getQuery();

        $results = $query->getArrayResult();
        $montant = 0;

        if (count($results) > 0){
            foreach($results as $result){
                $montant += $result['retenuSalaire'];
            }
        }

        return $montant;
    }


    /**
     * Finds and displays a FicheDePaie entity.
     *
     * @Route("/fichedepaie/{id}", name="fichedepaie_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $request    = $this->get('request');
        $success    = $request->query->get('success');
        $entity     = new FicheDePaie();
        $form       = $this->createCreateForm($entity);

        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($id);
        $entities       = $em->getRepository('JanetTransitAdminBundle:FicheDePaie')->findBy(
            array('employe' => $id), array('periode' => 'DESC'));


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FicheDePaie entity.');
        }

        return array(
            'entities'      => $entities,
            'employe'       => $entityEmploye,
            'form'          => $form->createView(),
            'success'       => $success,
        );
    }

    /**
     * Displays a form to edit an existing FicheDePaie entity.
     *
     * @Route("/{id}/edit", name="fichedepaie_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JanetTransitAdminBundle:FicheDePaie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FicheDePaie entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a FicheDePaie entity.
    *
    * @param FicheDePaie $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FicheDePaie $entity)
    {
        $form = $this->createForm(new FicheDePaieType(), $entity, array(
            'action' => $this->generateUrl('fichedepaie_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FicheDePaie entity.
     *
     * @Route("/{id}", name="fichedepaie_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:FicheDePaie:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em             = $this->getDoctrine()->getManager();
        $entity         = $em->getRepository('JanetTransitAdminBundle:FicheDePaie')->find($id);
        $dataform       = $request->request->get('janettransit_adminbundle_fichedepaie');
        $idEmploye      = $dataform['employe'];
        $entityEmploye  = $em->getRepository('JanetTransitAdminBundle:Employe')->find($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FicheDePaie entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('fichedepaie_show', array('id' => $entityEmploye->getId(), 'success'=>'true')));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

}
