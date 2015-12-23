<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VoitureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('immatricule','text', array(
                'label' => 'Immatricule *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )))

            ->add('marque',null, array(
                'label' => 'Marque de la voiture *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))

            ->add('modele','text', array(
                'label' => 'Modèle',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )))

            ->add('typeVoiture',null, array(
                'label' => 'type de voiture',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('chauffeur','entity', array(
                'class' =>'JanetTransit\AdminBundle\Entity\Employe',
                'query_builder' => function(\JanetTransit\AdminBundle\Entity\Repository\EmployeRepository $repository){
                    return $repository->findChauffeurQueryBuilder();
                },
                'label' => 'Chauffeur de la voiture',
                'required' => false,
                'attr' => array(
                    'class'     => 'form-control multiselectOne',
                )
            ))
            ->add('motoboy','entity', array(
                'class' =>'JanetTransit\AdminBundle\Entity\Employe',
                'query_builder' => function(\JanetTransit\AdminBundle\Entity\Repository\EmployeRepository $repository){
                    return $repository->findMotoboyQueryBuilder();
                },
                'label' => 'Motoboy de la voiture' ,
                'required' => false,
                'attr' => array(
                    'class'     => 'form-control multiselectOne',
                )
            ))

            ->add('cartegriseFile', 'file', array(
                'label' => 'Carte Grise (pdf)',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Voiture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_voiture';
    }
}
