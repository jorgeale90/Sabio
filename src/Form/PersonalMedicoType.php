<?php

namespace App\Form;

use App\Entity\PersonalMedico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PersonalMedicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ci')

            ->add('noregistro')

            ->add('nombre')

            ->add('apellidos')

            ->add('direccionparticular')

            ->add('telefonofijo')

            ->add('movil')

            ->add('email')

            ->add('autobliografia')

            ->add('organizacionpolitica', EntityType::class, array(
                'label' => 'Organización Política :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\OrganizacionPolitica',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('sexo', EntityType::class, array(
                'label' => 'Sexo :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Sexo',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('cargo', EntityType::class, array(
                'label' => 'Cargo :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Cargo',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('nacionalidad', EntityType::class, array(
                'label' => 'Nacionalidad :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Nacionalidad',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('especialidad', EntityType::class, array(
                'label' => 'Especialidad :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Especialidad',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

           ->add('categoriadocente', EntityType::class, array(
                'label' => 'Categoría Docente :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\CategoriaDocente',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

           ->add('categoriacientifica', EntityType::class, array(
                'label' => 'Categoría Científica :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\CategoriaCientifica',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

           ->add('mision',ChoiceType::class,[
                    'required'=>false,
                    'multiple'=>false,
                    'expanded'=>false,
                    'attr' => array('class' => 'form-control select2'),
                    'choices'=>[
                        'Si'=>'Si',
                        'No'=>'No',
                        'None'=>'None',
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cargo::class,
        ]);
    }
}