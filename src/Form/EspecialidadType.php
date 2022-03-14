<?php

namespace App\Form;

use App\Entity\Especialidad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EspecialidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')

            ->add('cargo', EntityType::class, array(
                'label' => 'Cargo :',
                'placeholder' => 'Seleccione una opción',
                'class' => 'App\Entity\Cargo',
                'attr' => array('class' => 'form-control col-md-7 col-xs-12 validate[required] js-example-basic-single', 'required' => 'required')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Especialidad::class,
        ]);
    }
}