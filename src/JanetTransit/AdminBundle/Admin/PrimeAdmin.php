<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class PrimeAdmin extends Admin
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
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('employe', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\Employe',
                'property' => 'nom'
            ))
            ->add('periode', null ,array('label' => 'Période'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('employe')
            ->addIdentifier('periode')
            ->addIdentifier('motif')
            ->addIdentifier('montant')
        ;
    }

}