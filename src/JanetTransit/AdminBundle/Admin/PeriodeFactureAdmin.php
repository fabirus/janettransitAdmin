<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PeriodeFactureAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dateFacture','text', array(
                'label' => 'Date de la journée *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control ',
                    'placeholder' => 'Format JJ/MM/AA',
                )))
            ->add('contrat',null, array(
                'label' => 'Contrat *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dateFacture');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('dateFacture')
        ;
    }

}