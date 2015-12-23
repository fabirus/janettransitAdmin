<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Sonata\UserBundle\Form\Type\RegistrationFormType;
class AdminController extends Controller
{
    public function indexAction()
    {
        $em                 = $this->getDoctrine()->getManager();
        $contrats           = $em->getRepository('JanetTransitAdminBundle:Contrat')->findAll();
        $taches             = $em->getRepository('JanetTransitAdminBundle:Tache')->findAll();
        $documents          = $em->getRepository('JanetTransitAdminBundle:Document')->findBy(
            array('del' => 0)
        );
        $carburations       = $em->getRepository('JanetTransitAdminBundle:Carburation')->findBy(
            array('del' => 0)
        );
        $depenses           = $em->getRepository('JanetTransitAdminBundle:Depense')->findBy(
            array('del' => 0)
        );
        $manutentions       = $em->getRepository('JanetTransitAdminBundle:Facture')->findBy(
            array('del' => 0)
        );
        $employes           = $em->getRepository('JanetTransitAdminBundle:Employe')->findBy(
            array('del' => 0)
        );

        return $this->render('JanetTransitAdminBundle:Admin:index.html.twig', array(
            'tache'         => $this->verifTache($taches),
            'contrat'       => $this->verifContrat($contrats),
            'document'      => $this->verifDocumentVoiture($documents),
            'carburation'   => $this->verifCarburation($carburations),
            'depense'       => $this->verifDepense($depenses),
            'manutention'   => $this->verifManutention($manutentions),
            'presence'      => $this->verifPresence($employes),
        ));
    }

    public function verifTache($taches){
        $tacheArray['response'] = false;

        if(count($taches) > 0) {
            foreach ($taches as $tache) {
                if ($tache->getEtat() != 0) {
                    $tacheArray['response'] = true;
                    $tacheArray['entity'] = $tache;
                    break;
                }
            }
        }
        return $tacheArray;
    }

    public function verifPresence($employes){
        $tacheArray['response'] = false;
        $dayArray               = [date('d/m/Y'), date('d/m/Y', strtotime(' -1 day')), date('d/m/Y', strtotime(' -2 day'))];
        $em                     = $this->getDoctrine()->getManager();

        foreach($dayArray as $day){
            $presences   = $em->getRepository('JanetTransitAdminBundle:Presence')->findBy(
                array('at' => $day)
            );
            if(count($employes) > count($presences)) {
                $tacheArray['response'] = true;
                $tacheArray['entity'] = $day;
                break;

            }
        }

        return $tacheArray;
    }

    public function verifContrat($contrats){
        $contratArray['response'] = false;
        $now                = time();

        if(count($contrats) > 0){
            foreach($contrats as $contrat){
                $dateEn = strtotime(str_replace('/', '-', $contrat->getDateFin()));
                $datediff = $now - $dateEn;
                if($datediff/(60*60*24) <= 10){
                    $contratArray['response'] = true;
                    $contratArray['entity']   = $contrat;
                    break;
                }
            }
        }
        return $contratArray;
    }

    public function verifDocumentVoiture($documents){
        $documentArray['response'] = false;
        $now                       = time();

        if(count($documents) > 0){
            foreach($documents as $document){
                $dateEn = strtotime(str_replace('/', '-', $document->getDateEcheance()));
                $datediff = $now - $dateEn;
                if($datediff/(60*60*24) <= 10){
                    $documentArray['response'] = true;
                    $documentArray['entity']   = $document;
                    break;
                }
            }
        }
        return $documentArray;
    }

    public function verifCarburation($carburations){
        $carburationArray['response'] = false;

        if(count($carburations) > 0){
            foreach($carburations as $carburation){
                if ($carburation->isValid() != 0) {
                    $carburationArray['response'] = true;
                    $carburationArray['entity'] = $carburation;
                    break;
                }
            }
        }
        return $carburationArray;
    }

    public function verifDepense($depenses){
        $depenseArray['response'] = false;

        if(count($depenses) > 0){
            foreach($depenses as $depense){
                if ($depense->isValid() != 0) {
                    $depenseArray['response'] = true;
                    $depenseArray['entity']   = $depense;
                    break;
                }
            }
        }
        return $depenseArray;
    }

    public function verifManutention($manutentions){
        $manutentionArray['response'] = false;

        if(count($manutentions) > 0){
            foreach($manutentions as $manutention){
                if ($manutention->isValid() != 0) {
                    $manutentionArray['response'] = true;
                    $manutentionArray['entity']   = $manutention;
                    break;
                }
            }
        }
        return $manutentionArray;
    }

    public function avatarAction(){
        $user = $this->container->get('security.context')->getToken()->getUser();
//        $form = $this->createFormBuilder($user);
//        $form = $this->createForm(new RegistrationFormType($user), $user, array(
//            'action' => $this->generateUrl('poste_update', array('id' => $user->getId())),
//            'method' => 'PUT',
//        ));

//        $form->add('submit', 'submit', array('label' => 'Update'));
//        echo $user->getUsername();


        return $this->render('JanetTransitAdminBundle:Admin:avatar.html.twig', array(
            'user' => $user->getId()
        ));
    }

    /**
     * Edits an existing Poste entity.
     *
     * @Route("/poste/{id}", name="poste_update")
     * @Method("PUT")
     * @Template("JanetTransitAdminBundle:Poste:edit.html.twig")
     */
    public function avatarUpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationSonataUserBundle:User')->find($id);
        $dataform       = $request->request->get('fos_user_registration_form');
        $idEmploye      = $dataform['imageFile'];

//        $editForm->handleRequest($request);

//        var_dump($idEmploye);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        echo 'here';

        $entity->setImageName($idEmploye);
        $em->flush();

//        $editForm = $this->createEditForm($entity);
//        $editForm->handleRequest($request);

//        if ($editForm->isValid()) {
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('poste_informations'));
//        }
//
//        return array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//        );
    }
}
