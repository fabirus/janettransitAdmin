<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContratEtsAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('typeContratEts', 'sonata_type_model', array(
                'label'     => 'Type de Contrat',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\TypeContratEts',
                'property'  => 'nom'
            ))
            ->add('nom', 'text', array(
                'label' => 'Nom de l\'entreprise'
            ))
            ->add('adresse', 'text', array(
                'label' => 'Adresse'
            ))
            ->add('tel', 'text', array(
                'label' => 'Téléphone'
            ))
            ->add('email', 'text', array(
                'label' => 'Email'
            ))
            ->add('updatedAt', 'datetime', array(
                'label' => 'updateAt'
            ))
            ->add('logoFile', 'file', array(
                'label' => 'Logo de l\'entreprise (jpeg|png)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file fileImage',
                    'accept' =>'image/jpeg, image/png'
                )
            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('typeContratEts');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('typeContratEts')
            ->addIdentifier('nom')
            ->addIdentifier('adresse')
            ->addIdentifier('tel')
            ->addIdentifier('email')
        ;
    }

}