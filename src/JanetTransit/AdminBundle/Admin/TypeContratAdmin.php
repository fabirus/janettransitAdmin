<?php

namespace JanetTransit\AdminBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class TypeContratAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom', 'text', array(
                'label'     => 'Nom du Contrat',
            ))
            ->add('description', 'textarea', array(
                'label'     => 'Description du Contrat',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom', null, array(
                'label'     => 'Nom du Contrat',
            ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->addIdentifier('description')
        ;
    }

}