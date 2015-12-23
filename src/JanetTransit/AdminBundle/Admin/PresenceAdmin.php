<?php
/**
 * Created by PhpStorm.
 * User: fabienwandji
 * Date: 24/11/15
 * Time: 17:54
 */

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PresenceAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employe', 'sonata_type_model', array(
                'label'     => 'Nom de l\'employe',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('at', 'date', array(
                'label' => 'Date'
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
            ->add('at', null ,array('label' => 'Date'))
            ->add('statut')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('employe')
            ->addIdentifier('at')
            ->addIdentifier('statut')
        ;
    }

}