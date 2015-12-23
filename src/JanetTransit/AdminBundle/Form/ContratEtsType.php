<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContratEtsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text', array(
                'label' => 'Nom de L\'entreprise *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
            )))
            ->add('adresse','text', array(
                'label' => 'Adresse *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
            )))
            ->add('representant','text', array(
                'label' => 'Réprésentant',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('tel','text', array(
                'label' => 'Téléphone *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control phoneNumber',
            )))
            ->add('email','email', array(
                'label' => 'Adresse Email',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('logoFile', null, array(
                'label' => 'Logo de l\'entreprise (jpeg|png)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file fileImage',
                    'accept' =>'image/jpeg, image/png'
                )
            ))
            ->add('contratFile', null, array(
                'label' => 'Justificatif du Contrat * (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('typeContratEts',null, array(
                'label' => 'Type De Contrat *',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\ContratEts'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_contratets';
    }
}
