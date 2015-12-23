<?php
// DAWeldonExampleBundle/Form/Type/ProfileFormType.php
namespace JanetTransit\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('username')
            ->add('surname')
            ->add('forename')
            ->add('nickname')
            ->add('profilePictureFile');
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'readypeeps_user_profile';
    }
}