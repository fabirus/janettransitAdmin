<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heure','text', array(
                'label' => 'Heure d\'arrivée *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat',
                    'readOnly'  => 'readOnly'
                )))
            ->add('numeroContainer','text', array(
                'label' => 'Numéro de Container *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('depart','text', array(
                'label' => 'Lieu de Départ *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('destination','text', array(
                'label' => 'Lieu de Destination *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))
            ->add('client','text', array(
                'label' => 'Noms et Prénoms du Client',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control client',
                )))
            ->add('percu','number', array(
                'label' => 'Montant Perçu *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('stationnement','number', array(
                'label' => 'Montant du Stationnement *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('carburation','number', array(
                'label' => 'Montant de la Carburation *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('fraisRoute','number', array(
                'label' => 'Montant des Frais de Route',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number',
                )))
            ->add('factureFile', 'file', array(
                'label' => ' Justificatif de la Facture (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('proccesFile', 'file', array(
                'label' => ' Justificatif du Proccès (pdf)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file filePdf',
                    'accept' =>'application/pdf',
                )
            ))
            ->add('periodeFacture',null, array(
                'label' => 'Période de la Facture *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('voiture',null, array(
                'label' => 'Voiture *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Facture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_facture';
    }
}
