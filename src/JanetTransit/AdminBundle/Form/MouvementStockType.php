<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MouvementStockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type','choice', array(
                'choices' => array(
                    'achat'    => 'Achat',
                    'sortie'    => 'Sortie',
                    'retour'    => 'Retour'
                ),
                'label' => 'Opérations du Matériel *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('motif','textarea', array(
                'label' => 'Motif *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('qte','number', array(
                'label' => 'Quantité *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )
            ))
            ->add('periodeStock',null, array(
                'label' => 'Période Stock *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('employe',null, array(
                'label' => 'Employé *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control multiselectOne'
                )
            ))
            ->add('heureMouvement',null, array(
                'label' => 'Heure *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control dateFormat',
                    'readOnly'  => 'readOnly'
                )
            ))
            ->add('stockFile', 'file', array(
                'label' => 'Justificatif du Mouvement (pdf)',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\MouvementStock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_mouvementstock';
    }
}
