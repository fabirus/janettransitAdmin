<?php

namespace JanetTransit\AdminBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TacheAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employe', 'sonata_type_model', array(
                'label'     => 'Employe',
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom',
                "multiple" => true
            ))
            ->add('nom', 'text', array(
                'label'     => 'Nom de la tache',
            ))
            ->add('taf', 'sonata_type_model', array(
                'label'     => 'Date du Taf',
                'class'     => 'JanetTransit\AdminBundle\Entity\Taf',
                'property'  => 'dateTache'
            ))
            ->add('explication', 'textarea', array(
                'label'     => 'Explication',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('taf', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\Taf',
                'property' => 'dateTache',
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
            ->addIdentifier('nom')
            ->addIdentifier('explication')
            ->addIdentifier('employe')
            ->addIdentifier('taf')
        ;
    }

}