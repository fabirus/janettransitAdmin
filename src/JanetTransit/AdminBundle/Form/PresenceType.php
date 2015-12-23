<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PresenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('at' ,'text', array(
                'label' => 'Date *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat dateAbsence',
                    'readOnly'  => 'readOnly',
                    'onBlur'   => "common().checkDateBDD('presence_checkDate', 'dateAbsence')"
                )))
            ->add('heureArrivee' ,'text', array(
                'label' => 'Heure d\'arrivée *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat',
                    'readOnly'  => 'readOnly'
                )))
            ->add('heureDepart' ,'text', array(
                'label' => 'Heure de Départ *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat',
                    'readOnly'  => 'readOnly'
                )))
            ->add('statut' ,'choice', array(
                'choices' => array(
                    'absent'    => 'Absent',
                    'present'   => 'Présent',
                    'retard'    => 'Retard'
                ),
                'label' => 'Statut *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('infos' ,'textarea', array(
                'label' => 'Informations',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('employe' ,null, array(
                'label' => 'Employe *',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('absenceFile', 'file', array(
                'label' => 'Justificatif de l\'absence Extension (pdf)',
                'required' => false,
                'attr' => array(
                    'class'             => 'form-control fileAbsence file filePdf',
                    'accept'            => 'application/pdf'
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Presence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_presence';
    }
}
