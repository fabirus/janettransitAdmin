<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DemandePermissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDemande','text', array(
                'label' => 'Date de demande *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateDemande',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('demandepermission_checkDate', 'dateDemande')"
                )))
            ->add('dateDebut','text', array(
                'label' => 'Date de début *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateDebut',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('demandepermission_checkDate', 'dateDebut')"
                )))
            ->add('dateFin','text', array(
                'label' => 'Date de fin *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateFin',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('demandepermission_checkDate', 'dateFin')"
                )))
            ->add('motif','textarea', array(
                'label' => 'Motif *',
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
            ->add('permissionFile', 'file', array(
                'label' => 'Justificatif de la permission Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\DemandePermission'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_demandepermission';
    }
}
