<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DepenseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employe',null, array(
                'label' => 'Employé',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ->add('voiture',null, array(
                'label' => 'Voiture Concerné',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ->add('motif','textarea', array(
                'label' => 'Motifs *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('materiel','text', array(
                'label' => 'Matériel *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('montant','number', array(
                'label' => 'Montant *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )))
            ->add('depenseFile', 'file', array(
                'label' => 'Facture de la dépense (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('periodeDepense',null, array(
                'label' => 'PeriodeDépense',
                'required' => false,
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Depense'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_depense';
    }
}
