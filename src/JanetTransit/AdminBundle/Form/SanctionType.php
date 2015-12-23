<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SanctionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateSanction','text', array(
                'label' => 'Date de Sanction *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateAbsence',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('sanction_checkDate', 'dateAbsence')"
                )))
            ->add('dateDebut','text', array(
                'label' => 'Date de Début *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateDebut',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('sanction_checkDate', 'dateDebut')"
                )))
            ->add('dateFin','text', array(
                'label' => 'Date de Fin *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateFin',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('sanction_checkDate', 'dateFin')"
                )))
            ->add('motif','textarea', array(
                'label' => 'Motif *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('retenuSalaire','number', array(
                'label' => 'Retenu de Salaire',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control number'
                )))
            ->add('employe',null, array(
                'label' => 'Employé *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('sanctionFile', 'file', array(
                'label' => 'Justificatif de la sanction Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf'
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Sanction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_sanction';
    }
}
