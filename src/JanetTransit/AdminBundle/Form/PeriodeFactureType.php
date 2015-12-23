<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PeriodeFactureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFacture','text', array(
                'label' => 'Date de la journée *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateFacture',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('periodefacture_checkDate', 'dateFacture')"
                ))
            )
            ->add('contrat',null, array(
                'label' => 'Contrat *',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\PeriodeFacture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_periodefacture';
    }
}
