<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContratType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut','text', array(
                'label' => 'Date de début *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateDebut',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('contrat_checkDate', 'dateDebut')"
                )))
            ->add('dateFin','text', array(
                'label' => 'Date de Fin *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat dateFin',
                    'placeholder' => 'Format JJ/MM/AA',
                    'required'     => 'required',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('contrat_checkDate', 'dateFin')"
                )))
            ->add('typeContrat',null, array(
                'label' => 'Type de Contrat *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('duree','choice', array(
                'choices' => array(
                    '1'    => '1 Jour',
                    '2'    => '2 Jours',
                    '3'    => '3 Jours',
                    '4'    => '4 Jours',
                    '5'    => '5 Jours',
                    '6'    => '6 Jours',
                ),
                'label' => 'Durée de Travail Hebdomadaire *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('employe',null, array(
                'label' => 'Employé *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('contratFile', 'file', array(
                'label' => 'Justificatif du contrat Extension (pdf)',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Contrat'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_contrat';
    }
}
