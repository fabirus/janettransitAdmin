<?php

namespace JanetTransit\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EmployeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
                'label' => 'Nom *',
                'attr' => array(
                    'class' => 'form-control',
                    'minlength' => 2
            )
            ))
            ->add('prenom', 'text', array(
                'label' => 'Prénom *',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('tel', 'text', array(
                'label' => 'Téléphone *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control phoneNumber red-tooltip',
                    'placeholder' => 'Exemple 699-10-63-27',
                )))
            ->add('dateEmbauche','text', array(
                'label' => 'Date d\'embauche *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly'
                )
            ))
            ->add('dateNaissance','text', array(
                'label' => 'Date de Naissance *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control dateFormat',
                    'placeholder' => 'Format JJ/MM/AA',
                    'readOnly'  => 'readOnly'
                )
            ))
            ->add('villeNaissance','text', array(
                'label' => 'Ville de Naissance *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('adresse','text', array(
                'label' => 'Adresse *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email','email', array(
                'label' => 'Adresse Email',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
//            ->add('services',null, array(
//                'label' => 'Service *',
//                'required' => true,
//                'attr' => array(
//                    'class' => 'form-control'
//                )
//            ))
          ->add('services','entity', array(
                'class' =>'JanetTransit\AdminBundle\Entity\Service',
                'property' =>'nom',
                'query_builder' => function(\JanetTransit\AdminBundle\Entity\Repository\ServiceRepository $repository){
                    return $repository->findActiveServiceQueryBuilder();
                },
                'label' => 'Service *',
                'required' => true,
                'attr' => array(
                    'class'     => 'form-control selectService',
                    'onClick'   => 'common().selectPoste()'
                )
            ))
            ->add('poste',null, array(
                'label' => 'Poste *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('salaire','number', array(
                'label' => 'Salaire *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control number'
                )
            ))
            ->add('sexe','choice', array(
                'choices' => array(
                    'masculin' => 'Masculin',
                    'feminin' => 'Feminin'
                ),
                'label' => 'Sexe *',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('imageFile', null, array(
                'label' => 'Photo de l\'employé Extension (jpeg|png)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control file fileImage',
                    'accept' =>'image/jpeg, image/png'
                )
            ))
            ->add('identiteFile', null, array(
                'label' => 'Pièce d\'identité de l\'employé Extension (pdf)',
                'required' => false,
//                'data_class' => 'Symfony\Component\HttpFoundation\File\File',
//                'property_path' => 'identiteFileName',
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
            'data_class' => 'JanetTransit\AdminBundle\Entity\Employe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'janettransit_adminbundle_employe';
    }
}
