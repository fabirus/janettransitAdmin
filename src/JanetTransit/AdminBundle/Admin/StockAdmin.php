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

class StockAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('materiel', 'text', array('label' => 'Matériel'))
            ->add('qteInitial', 'text', array(
                'label' => 'Qte Initiale'
            ))
            ->add('qteStock', 'text', array(
                'label' => 'Qte Stock'
            ))
            ->add('typeStock', null, array(
                'label' => 'Type de Stock'
            ))

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('materiel')
            ->add('typeStock')

        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('materiel')
            ->addIdentifier('typeStock')
            ->addIdentifier('qteInitial')
            ->addIdentifier('qteStock')
        ;
    }
}