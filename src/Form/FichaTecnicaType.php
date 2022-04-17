<?php

namespace App\Form;

use App\Entity\FichaTecnica;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichaTecnicaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                'label' => 'Responsable :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('personal2', EntityType::class, array(
                    'label' => 'Creado por :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('tipoequipo')

            ->add('noinventario')

            ->add('proyecto')

            ->add('area')

            ->add('modeloboard')

            ->add('socketboard')

            ->add('serieboard')

            ->add('tipocpu')

            ->add('marcacpu')

            ->add('velicidadcpu')

            ->add('seriecpu')

            ->add('hardware', CollectionType::class, [
                'entry_type' => HardwareType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichaTecnica::class,
        ]);
    }
}
