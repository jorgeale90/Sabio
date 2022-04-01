<?php

namespace App\Form;

use App\Entity\SistemaContable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SistemaContableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')

            ->add('permisos', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control select2', 'required' => 'required'),
                'choices' => [
                    'Escritura' => 'Escritura',
                    'Lectura' => 'Lectura',
                    'Control Total' => 'Control Total'
                ],
            ])

            ->add('sistemamodulo', EntityType::class, array(
                'label' => 'Sistema de Módulo :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\SistemaModulo',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('personal', EntityType::class, array(
                'label' => 'Personal :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SistemaContable::class,
        ]);
    }
}
