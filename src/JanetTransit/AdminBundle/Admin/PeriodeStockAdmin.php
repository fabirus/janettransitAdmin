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

class PeriodeStockAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('datePeriode', 'text', array('label' => 'Journée de Mouvement dd/mm/yyyy'))
            ->add('stock',null, array(
                'label' => 'Stock *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('datePeriode');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('datePeriode')
            ->addIdentifier('stock')
        ;
    }
}