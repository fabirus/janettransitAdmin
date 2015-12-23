<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFait','text', array(
                'label' => 'Date Fait *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                )))
            ->add('dateEcheance','text', array(
                'label' => 'Date Echéance *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                )))
            ->add('typeDocument', null, array(
                'label' => 'Type de Docment *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('documentFile', 'file', array(
                'label' => 'Justificatif du Document  Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('voiture',null, array(
                'label' => 'Voiture *',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_document';
    }
}
