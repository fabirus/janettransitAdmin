<?php

namespace JanetTransit\WikiBundle\Admin;

use JanetTransit\WikiBundle\Entity\Category;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class CategoryAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Informations relatives à la catégorie du Wiki', array('class' => 'col-md-6'))
                ->add('name', 'text', array('label' => 'Nom'))
                ->add('description', 'textarea', array('label' => 'Description'))
            ->end()
            ->with('Icones', array('class' => 'col-md-3'))
                ->add('spanClass', 'text', array('label' => 'classe du Span', 'required' => true))
                ->add('iClass', 'text', array('label' => 'Classe du I', 'required' => true ))
            ->end()
            ->with('Catégorie Parente', array('class' => 'col-md-3'))
                ->add('parent', 'sonata_type_model', array(
                    'label'     => 'catégorie',
                    'required'  => false,
                    'class'     => 'JanetTransit\WikiBundle\Entity\Category',
                    'property'  => 'name'
                ))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('parent', null, array('label' => 'Catégorie Parente'), 'entity', array(
                'class'    => 'JanetTransit\WikiBundle\Entity\Category',
                'property' => 'name'
            ));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('parent')
            ->addIdentifier('name')
            ->addIdentifier('description');
    }
}