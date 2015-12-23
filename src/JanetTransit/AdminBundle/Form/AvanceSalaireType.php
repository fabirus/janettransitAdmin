<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvanceSalaireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('at','text', array(
                'label' => 'Date de demande *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateDemande',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('avancesalaire_checkDate', 'dateDemande')"
                )))
            ->add('montant','number', array(
                'label' => 'Montant *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )))
            ->add('motif','textarea', array(
                'label' => 'Motifs *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('employe',null, array(
                'label' => 'Employé *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('avanceFile', null, array(
                'label' => 'Justificatif de l\'avance Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('periode','text', array(
                'label' => 'Période *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat periode',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('avancesalaire_checkDate', 'periode')"
                )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JanetTransit\AdminBundle\Entity\AvanceSalaire'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_avancesalaire';
    }
}
