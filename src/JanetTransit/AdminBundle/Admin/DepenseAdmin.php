<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DepenseAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employe','sonata_type_model', array(
                'label' => 'Employé',
                'required' => false,
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',

            ))
            ->add('voiture','sonata_type_model', array(
                'label' => 'Voiture Concerné',
                'required' => false,
                'class'     => 'JanetTransit\AdminBundle\Entity\Voiture',
            ))
            ->add('motif','textarea', array(
                'label' => 'Motifs',
                'required' => true,
                ))
            ->add('materiel','text', array(
                'label' => 'Matériel',
                'required' => true,
                ))
            ->add('montant','number', array(
                'label' => 'Montant',
                'required' => true,
                ))
            ->add('updatedAt','datetime', array(
                'label' => 'DateTime',
                'required' => true,
               ))
            ->add('depenseFile', 'file', array(
                'label' => 'Facture de la dépense (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('periodeDepense','sonata_type_model', array(
                'label' => 'PeriodeDépense',
                'required' => false,
                'class'     => 'JanetTransit\AdminBundle\Entity\PeriodeDepense',

            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('employe')
            ->add('periodeDepense')
            ->add('voiture');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('employe')
            ->addIdentifier('voiture')
            ->addIdentifier('motif')
            ->addIdentifier('materiel')
            ->addIdentifier('montant')
            ->addIdentifier('periodeDepense')
        ;
    }

}