<?php

namespace App\Form;

use App\Entity\PersonalMedico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PersonalMedicoType extends AbstractType
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

            ->add('ci')

            ->add('noregistro', null, [
                'label' => 'No. Registro :',
                'empty_data' => ''
            ])

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
                'multiple' => 'true',
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
               'placeholder' => 'Seleccione una opción',
               'attr' => array('class' => 'form-control select2'),
               'choices'=>[
                   'Si'=>'Si',
                   'No'=>'No',
               ],
           ])

           ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/png',
                        ]
                    ])
                ]
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonalMedico::class,
        ]);
    }
}