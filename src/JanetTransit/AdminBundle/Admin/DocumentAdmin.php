<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DocumentAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dateFait', 'text', array(
                'label'     => 'Date Fait Format = jj/mm/yyyy',
                'required'  => true,
            ))
            ->add('dateEcheance', 'text', array(
                'label'     => 'Date Echéance Format = jj/mm/yyyy',
                'required'  => true,
            ))
            ->add('voiture', 'sonata_type_model', array(
                'label'     => 'Voiture',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\Voiture',
            ))
            ->add('typeDocument', 'sonata_type_model', array(
                'label'     => 'Type de Document',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\TypeDocument',
            ))
            ->add('updatedAt', 'datetime', array(
                'required'  => true,
            ))
            ->add('documentFile', 'file', array(
                'label' => 'Justificatif du Document  Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('voiture')
            ->add('typeDocument')
            ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('dateFait')
            ->addIdentifier('dateEcheance')
            ->addIdentifier('voiture')
            ->addIdentifier('typeDocument')
        ;
    }

}