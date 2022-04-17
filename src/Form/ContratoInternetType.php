<?php

namespace App\Form;

use App\Entity\ContratoAnclaje;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratoAnclajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')

            ->add('fecha', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ))

            ->add('institucion', EntityType::class, array(
                'label' => 'Institución :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Institucion',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('personal1', EntityType::class, array(
                'label' => 'Nombre y Apellidos del Solicitante :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('login')

            ->add('contrasenna')

            ->add('accesotelefonico')

            ->add('personal2', EntityType::class, array(
                'label' => 'Director de la Institución: Nombre y Apellidos :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContratoAnclaje::class,
        ]);
    }
}
