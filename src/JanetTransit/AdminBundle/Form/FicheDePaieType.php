<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FicheDePaieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periode','text', array(
                'label' => 'Période *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat periode',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('fichedepaie_checkDate', 'periode')"
                )))
            ->add('observation','textarea', array(
                'label' => 'Observation *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('recommandation','textarea', array(
                'label' => 'Recommandation *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('fichedepaieFile', 'file', array(
                'label' => 'Justificatif de la fiche de Paie Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf'
                )
            ))
            ->add('employe',null, array(
                'label' => 'Employé *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\FicheDePaie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_fichedepaie';
    }
}
