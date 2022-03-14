<?php

namespace App\Form;

use App\Entity\Modelo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')

            ->add('marca', EntityType::class, array(
                'label' => 'Marca :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Marca',
                'attr' => array('class' => 'form-control select2', 'required' => 'required')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modelo::class,
        ]);
    }
}