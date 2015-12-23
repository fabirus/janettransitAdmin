<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TafType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateTache', 'text', array(
                'label' => 'date de la Tache *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateTache',
                    'placeholder' => 'Format JJ/MM/AA',
                    'onBlur'   => "common().checkDateBDD('taf_checkDate', 'dateTache')"
                )))
            ->add('description', 'textarea', array(
                'label' => 'Description',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control'
                )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JanetTransit\AdminBundle\Entity\Taf'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_taf';
    }
}
