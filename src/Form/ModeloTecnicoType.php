<?php

namespace App\Form;

use App\Entity\ModeloTecnico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ModeloTecnicoType extends AbstractType
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

            ->add('fichatecnica', EntityType::class, array(
                'label' => 'Ficha Técnica :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\FichaTecnica',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('tipomedio', EntityType::class, array(
                'label' => 'Tipo de Medio :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\TipoMedio',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))

            ->add('noinventario', null, [
                'label' => 'No. Inventario :',
                'empty_data' => ''
            ])

            ->add('proyecto', null, [
                'label' => 'Proyecto :',
                'empty_data' => ''
            ])

            ->add('area', null, [
                'label' => 'Area :',
                'empty_data' => ''
            ])

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

            ->add('serie', null, [
                'label' => 'Serie :',
                'empty_data' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModeloTecnico::class,
        ]);
    }
}
