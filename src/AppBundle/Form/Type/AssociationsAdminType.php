<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Entity\Associations;

class AssociationsAdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name')
            ->add('searchaddress', null, array(
                'attr' => array(
                    'onfocus' => 'geolocate()'),
            ))
            ->add('numstreet')
            ->add('address1')
            ->add('address2')
            ->add('postalcode')
            ->add('city')
            ->add('department')
            ->add('region')
            ->add('country')
            ->add('url')
            ->add('dateCreation', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5'  => 'false'
            ))
            ->add('rna')
            ->add('logo', FileType::class, array(
                'required' => false,
            ))
            ->add('object', TextareaType::class, array(
                'attr' => array('style' => 'resize: none'),
            ))
            ->add('phoneNumber')
            ->add('categorie', EntityType::class, array(
                'class' => 'AppBundle:Categories',
                'placeholder' => 'Choisir une catégorie',
                'choice_label' => 'name',
                'preferred_choices' => array(1),
                'required' => true,
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Associations'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_associations';
    }


}
