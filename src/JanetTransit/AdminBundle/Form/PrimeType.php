<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrimeType extends AbstractType
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
                    'class'     => 'form-control dateFormat periode',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('prime_checkDate', 'periode')"
                )))
            ->add('motif','textarea', array(
                'label' => 'Motifs *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control',
                )))
            ->add('montant','number', array(
                'label' => 'Montant *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control number',
                )))
            ->add('employe' ,null, array(
                'label' => 'Employe *',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JanetTransit\AdminBundle\Entity\Prime'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_prime';
    }
}
