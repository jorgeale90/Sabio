<?php

namespace App\Form;

use App\Entity\Ram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')

            ->add('clasificacion')

            ->add('capacidad')

            ->add('marca')

            ->add('velocidad')

            ->add('serie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ram::class,
        ]);
    }
}
