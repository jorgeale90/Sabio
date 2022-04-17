<?php

namespace App\Form;

use App\Entity\ContratoInternet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratoInternetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('folio')

            ->add('fecha', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ))

            ->add('provincia', EntityType::class, array(
                'label' => 'Provincia :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Provincia',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('municipio', EntityType::class, array(
                'label' => 'Municipio :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Municipio',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
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

            ->add('telefono')

            ->add('personal2', EntityType::class, array(
                'label' => 'Director de la Institución: Nombre y Apellidos :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('serviciocorreo', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control select2', 'required' => 'required'),
                'choices' => [
                    'Si' => 'Si',
                    'No' => 'No'
                ],
            ])

            ->add('accesoredes', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control select2', 'required' => 'required'),
                'choices' => [
                    'Si' => 'Si',
                    'No' => 'No'
                ],
            ])

            ->add('login')

            ->add('pass')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContratoInternet::class,
        ]);
    }
}
