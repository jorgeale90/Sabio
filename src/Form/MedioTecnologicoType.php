<?php

namespace App\Form;

use App\Entity\MedioTecnologico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MedioTecnologicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mac')

            ->add('serie')

            ->add('fecha', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ))

            ->add('descripcion')

            ->add('tipomedio', EntityType::class, array(
                'label' => 'Tipo Medio :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoMedio',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('marca', EntityType::class, array(
                'label' => 'Marca :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Marca',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('modelo', EntityType::class, array(
                'label' => 'Modelo :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Modelo',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('personal1', EntityType::class, array(
                'label' => 'Administrador :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('personal2', EntityType::class, array(
                'label' => 'Cliente :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MedioTecnologico::class,
        ]);
    }
}
