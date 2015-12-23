<?php
namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        parent::buildForm($builder, $options);
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'placeholder' => 'Nom d\'utilisateur',
                    'class'       => 'form-control'
                )))
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'placeholder' => 'Adresse E-mail',
                    'class'       => 'form-control'

                )))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password',
                    'attr' => array(
                        'placeholder' => 'Mot de passe',
                        'class'       => 'form-control'

                    )),
                'second_options' => array('label' => 'form.password_confirmation',
                    'attr' => array(
                        'placeholder' => 'Confirmation Mot de passe',
                        'class'       => 'form-control'

                    )),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('imageFile', null, array(
                'label'=>'Avatar (jpeg|png)',
                'attr' => array(
                    'class' => 'btn btn-success form-control avatar file fileImage',

                )));
    }

    public function getName()
    {
        return 'projet_client_registration';
    }
}