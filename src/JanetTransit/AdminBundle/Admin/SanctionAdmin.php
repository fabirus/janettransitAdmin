<?php
/**
 * Created by PhpStorm.
 * User: fabienwandji
 * Date: 26/11/15
 * Time: 16:59
 */

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class SanctionAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employe', 'sonata_type_model', array(
                'label'     => 'Nom de l\'employe',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('dateSanction', 'date' ,array('label' => 'Date Sanction'))
            ->add('dateDebut', 'date' ,array('label' => 'Date Début'))
            ->add('dateFin', 'date' ,array('label' => 'Date Fin'))
            ->add('motif', 'textarea' ,array('label' => 'Motifs'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('employe', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\Employe',
                'property' => 'nom'
            ))
            ->add('dateSanction', null ,array('label' => 'Date Sanction'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('employe')
            ->addIdentifier('dateSanction')
            ->addIdentifier('dateDebut')
            ->addIdentifier('dateFin')
            ->addIdentifier('motif')
        ;
    }

}