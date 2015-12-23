<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;


class ChangePasswordFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
            $constraint = new UserPassword();
        } else {
            // Symfony 2.1 support with the old constraint class
            $constraint = new OldUserPassword();
        }

        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => $constraint,
            'attr' => array(
                'placeholder' => 'Mot de Passe Actuel',
                'class'       => 'form-control'
            )
        ));
        $builder->add('new', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.new_password',
                'attr' => array(
                    'placeholder' => 'Nouveau Mot de Passe',
                    'class'       => 'form-control'
                )),
            'second_options' => array('label' => 'form.new_password_confirmation',
                'attr' => array(
                    'placeholder' => 'Confirmation',
                    'class'       => 'form-control'
                )),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }

    public function getName()
    {
        return 'projet_client_changePassword';
    }
}
