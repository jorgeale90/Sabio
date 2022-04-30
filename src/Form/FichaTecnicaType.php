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

            ->add('noinventario', null, [
                'label' => 'No. Inventario :',
                'empty_data' => ''
            ])

            ->add('proyecto', null, [
                'label' => 'Proyecto :',
                'empty_data' => ''
            ])

            ->add('area')

            ->add('modeloboard', null, [
                'label' => 'Modelo de la Motherboard :',
                'empty_data' => ''
            ])

            ->add('socketboard', null, [
                'label' => 'Socket de la Motherboard :',
                'empty_data' => ''
            ])

            ->add('serieboard', null, [
                'label' => 'Serie de la Motherboard :',
                'empty_data' => ''
            ])

            ->add('tipocpu', null, [
                'label' => 'Tipo de CPU :',
                'empty_data' => ''
            ])

            ->add('marcacpu', null, [
                'label' => 'Marca de la CPU :',
                'empty_data' => ''
            ])

            ->add('velicidadcpu', null, [
                'label' => 'Velocidad de la CPU :',
                'empty_data' => ''
            ])

            ->add('seriecpu', null, [
                'label' => 'Serie de la CPU :',
                'empty_data' => ''
            ])

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
