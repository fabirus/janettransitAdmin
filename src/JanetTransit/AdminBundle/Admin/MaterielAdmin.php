<?php

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MaterielAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('at','text', array(
                'label' => 'Date',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat at',
                    'placeholder' => 'Format JJ/MM/AA',
                )))
            ->add('motif','textarea', array(
                'label' => 'Motifs',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat'
                )))
            ->add('qte','number', array(
                'label' => 'Quantité',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number qte',
                    'onBlur'   => "common().checkQte('materiel_checkQte', 'qte', 'stock')"
                )))
            ->add('stock','entity', array(
                'class' =>'JanetTransit\AdminBundle\Entity\Stock',
                'query_builder' => function(\JanetTransit\AdminBundle\Entity\Repository\StockRepository $repository){
                    return $repository->findAdministratifQueryBuilder();
                },
                'label' => 'Matériel',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne stock'
                )))
            ->add('materielFile', 'file', array(
                'label' => 'Justificatif (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf'
                )
            ))
            ->add('employe', null, array(
                'label' => 'Employé',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
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
        ->add('stock', null, array(),'entity', array(
            'class' =>'JanetTransit\AdminBundle\Entity\Stock',
            'query_builder' => function(\JanetTransit\AdminBundle\Entity\Repository\StockRepository $repository){
                return $repository->findAdministratifQueryBuilder();
            }
        ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('employe')
            ->addIdentifier('at')
            ->addIdentifier('stock')
            ->addIdentifier('qte')
            ->addIdentifier('motif')
        ;
    }

}