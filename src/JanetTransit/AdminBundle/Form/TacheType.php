<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
                'label' => 'Nom de la tache *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('explication', 'textarea', array(
                'label' => 'Explication *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('employe', null, array(
                'label' => 'Employés *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselect',
                    'multiple' => 'multiple'
                )))
            ->add('taf', null, array(
                'label' => 'TAF *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('voiture', null, array(
                'label' => 'Voiture Concernée',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control multiselectOne',
                )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JanetTransit\AdminBundle\Entity\Tache'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_tache';
    }
}
