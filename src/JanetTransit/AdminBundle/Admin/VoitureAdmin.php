<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class VoitureAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('immatricule', 'text', array(
                'label'     => 'Immatricule',
                'required'  => true,
            ))
            ->add('typeVoiture', 'sonata_type_model', array(
                'label'     => 'Type de Voiture',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\TypeVoiture',
                'property'  => 'nom'
            ))
            ->add('chauffeur', 'sonata_type_model', array(
                'label'     => 'Chauffeur',
                'required'  => false,
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('motoboy', 'sonata_type_model', array(
                'label'     => 'Motoboy',
                'required'  => false,
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('typeVoiture')
            ->add('immatricule')
            ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('immatricule')
            ->addIdentifier('typeVoiture')
            ->addIdentifier('chauffeur')
            ->addIdentifier('motoboy')
        ;
    }

}