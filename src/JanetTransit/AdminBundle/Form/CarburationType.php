<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarburationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motif','textarea', array(
                'label' => 'Motifs *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat'
                )))
            ->add('montant','number', array(
                'label' => 'Montant *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )))
            ->add('carburationFile', 'file', array(
                'label' => 'Justificatif de la Carburation (pdf)',
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
                    'class' => 'form-control multiselect'
                )
            ))
            ->add('periodeCarburation',null, array(
                'label' => 'periode carbration *',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Carburation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_carburation';
    }
}
