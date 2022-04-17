<?php

namespace App\Form;

use App\Entity\AuditoriaInterna;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AuditoriaInternaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noidentificacion')

            ->add('accionrealizada')

            ->add('fecha', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ))

            ->add('area')

            ->add('user', EntityType::class, array(
                'label' => 'Participantes :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\User',
                'multiple' => 'true',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('situaciones')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AuditoriaInterna::class,
        ]);
    }
}