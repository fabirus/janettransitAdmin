<?php

namespace JanetTransit\AdminBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CarburationAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employe', 'sonata_type_model', array(
                'label'     => 'Employe',
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('periodeCarburation', 'sonata_type_model', array(
                'label'     => 'periode de carburation',
                'class'     => 'JanetTransit\AdminBundle\Entity\PeriodeCarburation',
                'property'  => 'dateCarburation'
            ))
            ->add('motif', 'textarea', array(
                'label'     => 'motif',
            ))
            ->add('montant', 'number', array(
                'label'     => 'Montant',
            ))
            ->add('updatedAt', 'date', array(
                'label'     => 'Update',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('periodeCarburation', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\PeriodeCarburation',
                'property' => 'dateCarburation'
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
            ->addIdentifier('employe')
            ->addIdentifier('periodeCarburation')
            ->addIdentifier('motif')
            ->addIdentifier('montant')
        ;
    }

}