<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FactureAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('heure','text', array(
                'label' => 'Heure d\'arrivée *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat',
                    'readOnly'  => 'readOnly'
                )))
            ->add('numeroContainer','text', array(
                'label' => 'Numéro de Container *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('depart','text', array(
                'label' => 'Lieu de Départ *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('destination','text', array(
                'label' => 'Lieu de Destination *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('client','text', array(
                'label' => 'Noms et Prénoms du Client',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control client',
                )))
            ->add('percu','number', array(
                'label' => 'Montant Perçu *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('carburation','number', array(
                'label' => 'Montant de la Carburation *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('fraisRoute','number', array(
                'label' => 'Montant des Frais de Route',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('factureFile', 'file', array(
                'label' => ' Justificatif de la Facture (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('proccesFile', 'file', array(
                'label' => ' Justificatif du Proccès (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('periodeFacture',null, array(
                'label' => 'Période de la Facture *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('voiture',null, array(
                'label' => 'Voiture *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('depart')
            ->add('periodeFacture')
            ->add('destination');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('heure')
            ->addIdentifier('numeroContainer')
            ->addIdentifier('depart')
            ->addIdentifier('destination')
            ->addIdentifier('client')
            ->addIdentifier('percu')
            ->addIdentifier('carburation')
            ->addIdentifier('fraisRoute')
            ->addIdentifier('periodeFacture')
            ->addIdentifier('voiture')
        ;
    }

}