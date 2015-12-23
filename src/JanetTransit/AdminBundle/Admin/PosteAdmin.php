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

class PosteAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom', 'text', array('label' => 'Nom du Poste'))
            ->add('description', 'textarea', array(
                'label' => 'Description du Poste'
            ))
            ->add('service', 'sonata_type_model', array(
                'label'     => 'Nom du service',
                'required'  => true,
                'class'     => 'JanetTransit\AdminBundle\Entity\Service',
                'property'  => 'nom'
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('service', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\Service',
                'property' => 'nom'
            ));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->addIdentifier('description')
            ->addIdentifier('service');
    }
}