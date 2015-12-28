<?php

namespace JanetTransit\WikiBundle\Admin;

use JanetTransit\WikiBundle\Entity\Category;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ArticleAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Informations relatives à l\'article du Wiki', array('class' => 'col-md-7'))
                ->add('title', 'text', array('label' => 'Titre'))
                ->add('content', 'ckeditor', array(
                'plugins' => array(
                    'wordcount' => array(
                        'path'     => '/web/ckeditor/plugins/wordcount/',
                        'filename' => 'plugin.js',
                    )
                ),
                    'label' => 'Description'
                ))
//                ->add('content', 'sonata_formatter_type', array(
//                    'label' => 'Description',
//                    'format_field' => 'contentFormatter',
//                    'source_field'   => 'rawContent',
//                    'target_field'   => 'content',
//                    'ckeditor_context'     => 'default',
//                    'listener'       => true,
//                    'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher()
//                ))
            ->add('articleFile', 'file', array(
                'label' => 'Image de l\'article (jpeg|png)',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control file fileImage',
                    'accept' =>'image/jpeg, image/png'
                )
            ))
//                ->add('image', 'sonata_type_model', array('label' => 'Image') )
            ->end()
            ->with('Catégorie de l\'article', array('class' => 'col-md-5'))
                ->add('category', 'sonata_type_model', array(
                    'label'     => 'Categorie',
                    'required'  => false,
                    'class'     => 'JanetTransit\WikiBundle\Entity\Category',
                    'property'  => 'name'
                ))
            ->add('updatedAt', 'datetime', array(
                'label'     => 'date courrante',
            ))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category', null, array(), 'entity', array(
                'class'    => 'JanetTransit\WikiBundle\Entity\Category',
                'property' => 'name'
            ));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('content')
            ->addIdentifier('category')
            ->addIdentifier('image');
    }
}