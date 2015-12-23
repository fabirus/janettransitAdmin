<?php
/**
 * Created by PhpStorm.
 * User: fabienwandji
 * Date: 26/11/15
 * Time: 21:20
 */

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContratAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('typeContrat', 'sonata_type_model', array(
                'label'     => 'Type de Contrat',
                'class'     => 'JanetTransit\AdminBundle\Entity\TypeContrat',
                'property'  => 'nom'
            ))
            ->add('employe', 'sonata_type_model', array(
                'label'     => 'Employe',
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('dateDebut', null, array(
                'label'     => 'date Debut format jj/mm/yyy',
            ))
            ->add('dateFin', null, array(
                'label'     => 'date Fin format jj/mm/yyy',
            ))
            ->add('duree', null, array(
                'label'     => 'duree de 1-6 jours',
            ))
            ->add('updatedAt', 'date', array(
                'label'     => 'date courrante',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('typeContrat', null, array(
                'label'     => 'Type de Contrat',
            ))
            ->add('employe', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\Employe',
                'property' => 'nom'
            ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('typeContrat')
            ->addIdentifier('employe')
            ->addIdentifier('dateDebut')
            ->addIdentifier('dateFin')
            ->addIdentifier('duree')
        ;
    }


}