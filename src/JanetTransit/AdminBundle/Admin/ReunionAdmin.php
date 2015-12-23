<?php

namespace JanetTransit\AdminBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ReunionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('employeIntervenants', 'sonata_type_model', array(
                'label'     => 'Employe',
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom',
                "multiple"  => true
            ))
            ->add('dateReunion', 'text', array(
                'label'     => 'Date de la reunion format(dd/mm/yyyy) ',
            ))
            ->add('libelle', 'text', array(
                'label'     => 'Sujet de la reunion ',
            ))
            ->add('compteRendu', 'ckeditor', array(
                'plugins' => array(
                    'wordcount' => array(
                        'path'     => '/web/ckeditor/plugins/wordcount/',
                        'filename' => 'plugin.js',
                    ),
                ),
                'required' => true,
                'label' => 'Compte Rendu *'
            ))
            ->add('employePresident', 'sonata_type_model', array(
                'label'     => 'Président de la reunion',
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('employeAssistant', 'sonata_type_model', array(
                'label'     => 'Assistant(e) de la reunion',
                'class'     => 'JanetTransit\AdminBundle\Entity\Employe',
                'property'  => 'nom'
            ))
            ->add('updatedAt', 'date', array(
                'label'     => 'date courrante',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dateReunion')
            ->add('employePresident', null, array(), 'entity', array(
                'class'    => 'JanetTransit\AdminBundle\Entity\Employe',
                'property' => 'nom'
            ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('dateReunion')
            ->addIdentifier('libelle')
            ->addIdentifier('employePresident')
            ->addIdentifier('employeAssistant')
            ->addIdentifier('employeIntervenants')
            ->addIdentifier('compteRendu')
        ;
    }

}