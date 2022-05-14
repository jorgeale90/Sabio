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
            ->add('provincia', EntityType::class, array(
                'label' => 'Provincia :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Provincia',
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))

            ->add('municipio', EntityType::class, array(
                'label' => 'Municipio :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Municipio',
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))

            ->add('institucion', EntityType::class, array(
                'label' => 'Institución :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Institucion',
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ))

            ->add('fichatecnica', EntityType::class, array(
                'label' => 'Ficha Técnica :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\FichaTecnica',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('noidentificacion')

            ->add('accionrealizada')

            ->add('fecha', DateType::class, array(
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ))

            ->add('area')

            ->add('personalmedico', EntityType::class, array(
                'label' => 'Participantes :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\PersonalMedico',
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