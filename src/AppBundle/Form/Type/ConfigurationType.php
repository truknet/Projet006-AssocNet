<?php

namespace AppBundle\Form\Type;


use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class ConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('themeFront',              ChoiceType::class, array(
                'choices'  => array(
                    'Standard' => 'css/Bootswatch3/bootstrap/bootstrap.min.css',
                    'Cerulean' => 'css/Bootswatch3/bootstrap-cerulean/bootstrap.min.css',
                    'Cosmo' => 'css/Bootswatch3/bootstrap-cosmo/bootstrap.min.css',
                    'Cyborg' => 'css/Bootswatch3/bootstrap-cyborg/bootstrap.min.css',
                    'Darkly' => 'css/Bootswatch3/bootstrap-darkly/bootstrap.min.css',
                    'Flatly' => 'css/Bootswatch3/bootstrap-flatly/bootstrap.min.css',
                    'Journal' => 'css/Bootswatch3/bootstrap-journal/bootstrap.min.css',
                    'Lumen' => 'css/Bootswatch3/bootstrap-lumen/bootstrap.min.css',
                    'Paper' => 'css/Bootswatch3/bootstrap-paper/bootstrap.min.css',
                    'Readable' => 'css/Bootswatch3/bootstrap-readable/bootstrap.min.css',
                    'Sandstone' => 'css/Bootswatch3/bootstrap-sandstone/bootstrap.min.css',
                    'Simplex' => 'css/Bootswatch3/bootstrap-simplex/bootstrap.min.css',
                    'Slate' => 'css/Bootswatch3/bootstrap-slate/bootstrap.min.css',
                    'Spacelab' => 'css/Bootswatch3/bootstrap-spacelab/bootstrap.min.css',
                    'Superhero' => 'css/Bootswatch3/bootstrap-superhero/bootstrap.min.css',
                    'United' => 'css/Bootswatch3/bootstrap-united/bootstrap.min.css',
                    'Yeti' => 'css/Bootswatch3/bootstrap-yeti/bootstrap.min.css'
                )
            ))
            ->add('themeAdmin',              ChoiceType::class,
                array
                (
                    'choices'  => array(
                        'Standard' => 'css/Bootswatch3/bootstrap/bootstrap.min.css',
                        'Cerulean' => 'css/Bootswatch3/bootstrap-cerulean/bootstrap.min.css',
                        'Cosmo' => 'css/Bootswatch3/bootstrap-cosmo/bootstrap.min.css',
                        'Cyborg' => 'css/Bootswatch3/bootstrap-cyborg/bootstrap.min.css',
                        'Darkly' => 'css/Bootswatch3/bootstrap-darkly/bootstrap.min.css',
                        'Flatly' => 'css/Bootswatch3/bootstrap-flatly/bootstrap.min.css',
                        'Journal' => 'css/Bootswatch3/bootstrap-journal/bootstrap.min.css',
                        'Lumen' => 'css/Bootswatch3/bootstrap-lumen/bootstrap.min.css',
                        'Paper' => 'css/Bootswatch3/bootstrap-paper/bootstrap.min.css',
                        'Readable' => 'css/Bootswatch3/bootstrap-readable/bootstrap.min.css',
                        'Sandstone' => 'css/Bootswatch3/bootstrap-sandstone/bootstrap.min.css',
                        'Simplex' => 'css/Bootswatch3/bootstrap-simplex/bootstrap.min.css',
                        'Slate' => 'css/Bootswatch3/bootstrap-slate/bootstrap.min.css',
                        'Spacelab' => 'css/Bootswatch3/bootstrap-spacelab/bootstrap.min.css',
                        'Superhero' => 'css/Bootswatch3/bootstrap-superhero/bootstrap.min.css',
                        'United' => 'css/Bootswatch3/bootstrap-united/bootstrap.min.css',
                        'Yeti' => 'css/Bootswatch3/bootstrap-yeti/bootstrap.min.css'
                    )
                ))
            ->add('frontSidebarLastAssocNb', IntegerType::class)
            ->add('frontListAssocNb', IntegerType::class)
            ->add('adminValidAutoSubmissionAssoc',          ChoiceType::class,
                array
                (
                    'choices'  => array(
                        'Oui' => 1,
                        'Non' => 0,
                    )
                ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Configuration'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_configuration';
    }


}
