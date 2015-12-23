<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('materiel','text', array(
                'label' => 'Matériel *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('qteInitial','number', array(
                'label' => 'Quantité Initial *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )))
            ->add('qteStock','number', array(
                'label' => 'Quantité en Stock *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )))
            ->add('typeStock',null, array(
                'label' => 'Type de Stock *',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Stock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_stock';
    }
}
