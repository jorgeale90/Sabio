<?php

namespace App\Form;

use App\Entity\TablaIP;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TablaIPType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip', null, [
                'required' => false,
                'label' => 'Dirección IP :',
                'attr' => array('class' => 'form-control')
            ])

            ->add('mac', null, [
                'required' => false,
                'label' => 'Mac :',
                'attr' => array('class' => 'form-control')
            ])

            ->add('departamento', null, [
                'required' => false,
                'label' => 'Departamento :',
                'attr' => array('class' => 'form-control')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TablaIP::class,
        ]);
    }
}
