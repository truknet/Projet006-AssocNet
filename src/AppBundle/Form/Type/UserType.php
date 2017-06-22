<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /** * {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => "Nom"))
            ->add('username', null, array('label' => "Nom d'utilisateur"))
            ->add('email', null, array('required' => false, 'label' => 'E-mail'))
            ->add('enabled', null, array('label' => 'Actif/Inactif'))
            ->add('roles', ChoiceType::class, array(
                'attr'  =>  array('class' => 'form-control',
                    'style' => 'margin:5px 0;'),
                'choices' =>
                    array
                    (
                        'Administrateur' => 'ROLE_SUPER_ADMIN',
                        'Admin Association' => 'ROLE_ADMIN',
                        'Particulier' => 'ROLE_USER',
                    ) ,
                'multiple' => true,
                'required' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}
