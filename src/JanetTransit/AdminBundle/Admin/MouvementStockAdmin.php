<?php
/**
 * Created by PhpStorm.
 * User: fabienwandji
 * Date: 17/11/15
 * Time: 18:01
 */

namespace JanetTransit\AdminBundle\Admin;

use JanetTransit\AdminBundle\Entity\Service;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MouvementStockAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type','choice', array(
                'choices' => array(
                    'achat'    => 'Achat',
                    'sortie'    => 'Sortie',
                    'retour'    => 'Retour'
                ),
                'label' => 'Opérations du Matériel',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('motif','textarea', array(
                'label' => 'Motif',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('qte','number', array(
                'label' => 'Quantité',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )
            ))
            ->add('periodeStock',null, array(
                'label' => 'Période Stock',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('employe',null, array(
                'label' => 'Employé',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ->add('heureMouvement',null, array(
                'label' => 'Heure hh:mm',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat',
                )
            ))
            ->add('stockFile', 'file', array(
                'label' => 'Justificatif du Mouvement (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('updatedAt', 'datetime', array(
                'label' => 'datetime',
                'required' => true,

            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('periodeStock')
            ->add('employe')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('type')
            ->addIdentifier('motif')
            ->addIdentifier('qte')
            ->addIdentifier('periodeStock')
            ->addIdentifier('employe')
            ->addIdentifier('heureMouvement')
        ;
    }
}