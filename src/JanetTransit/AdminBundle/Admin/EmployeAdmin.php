<?php
/**
 * Created by PhpStorm.
 * User: fabienwandji
 * Date: 17/11/15
 * Time: 18:52
 */

namespace JanetTransit\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class EmployeAdmin extends Admin
{

//    // Fields to be shown on create/edit forms
//    protected function configureFormFields(FormMapper $formMapper)
//    {
//        $formMapper
//            ->add('nom', 'text', array('label' => 'Nom du Poste'))
//            ->add('description', 'textarea', array(
//                'label' => 'Description du Poste'
//            ))
//            ->add('service', 'sonata_type_model', array(
//                'label'     => 'Nom du service',
//                'required'  => false,
//                'class'     => 'JanetTransit\AdminBundle\Entity\Service',
//                'property'  => 'nom'
//            ));
//    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('prenom')
            ->add('poste')
            ->add('dateEmbauche');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->addIdentifier('prenom')
            ->addIdentifier('dateEmbauche')
            ->addIdentifier('poste')
            ->addIdentifier('tel')
            ->addIdentifier('salaire');
    }
}