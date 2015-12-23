<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReunionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateReunion','text', array(
                'label' => 'Date de la réunion *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateReunion',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('reunion_checkDate', 'dateReunion')"
                )))
            ->add('libelle','text', array(
                'label' => 'Libellé *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
//            ->add('compteRendu','textarea', array(
//                'label' => 'Compte Rendu *',
//                'required' => true,
//                'attr' => array(
//                    'class' => 'form-control',
//                )))
            ->add('compteRendu','ckeditor', array(
                'plugins' => array(
                    'wordcount' => array(
                        'path'     => '/web/ckeditor/plugins/wordcount/',
                        'filename' => 'plugin.js',
                    ),
                ),
                'required' => true,
                'label' => 'Compte Rendu *'
                ))
            ->add('employePresident',null, array(
                'label' => 'Président de la réunion *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ->add('employeAssistant',null, array(
                'label' => 'Assistant(e) de la réunion *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ->add('employeIntervenants',null, array(
                'label' => 'Participants *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectAll',
                    'multiple' => 'multiple'
                )
            ))
            ->add('reunionFile', 'file', array(
                'label' => 'Justificatif de la Réunion (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JanetTransit\AdminBundle\Entity\Reunion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_reunion';
    }
}
