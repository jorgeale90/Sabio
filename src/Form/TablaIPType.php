<?php

namespace App\Form;

use App\Entity\Hardware;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HardwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('componentes', ChoiceType::class, [
                'required' => false,
                'label' => 'Componente :',
                'placeholder' => 'Seleccione una opción',
                'attr' => array('class' => 'form-control select2', 'required' => 'required'),
                'choices' => [
                    'Memoria RAM' => 'Memoria RAM',
                    'Disco Duro' => 'Disco Duro',
                    'Fuente de alimentación' => 'Fuente de alimentación',
                    'Módem' => 'Módem',
                    'Memoria Cache' => 'Memoria Cache',
                    'Lectora de CD/DVD' => 'Lectora de CD/DVD',
                    'Disqueteras' => 'Disqueteras',
                    'Tarjetas de video' => 'Tarjetas de video',
                    'Teclado' => 'Teclado',
                    'Mouse' => 'Mouse',
                    'Bocinas' => 'Bocinas',
                    'Tarjeta de Sonido' => 'Tarjeta de Sonido',
                    'Otros' => 'Otros'
                ],
            ])

            ->add('numero', null, [
                'required' => false,
                'label' => 'Número :',
                'attr' => array('class' => 'form-control', 'required' => 'required')
            ])

            ->add('clasificacion', null, [
                'required' => false,
                'label' => 'Clasifcación o Tipo :',
                'attr' => array('class' => 'form-control')
            ])

            ->add('capacidad', null, [
                'required' => false,
                'label' => 'Capacidad :',
                'attr' => array('class' => 'form-control', 'data-container'=>'body', 'data-toggle'=>'popover', 'data-placement'=>'top', 'data-content'=>'La Capacidad en las Memorias RAM se miden en (MB), en los Discos Duros (GB), en las Tarjetas de Videos (MB o GB) y en la Fuente de Alimentación (Watts).')
            ])

            ->add('marca', null, [
                'required' => false,
                'label' => 'Marca :',
                'attr' => array('class' => 'form-control')
            ])

            ->add('modelo', null, [
                'required' => false,
                'label' => 'Modelo :',
                'attr' => array('class' => 'form-control')
            ])

            ->add('velocidad', null, [
                'required' => false,
                'label' => 'Velocidad :',
                'attr' => array('class' => 'form-control')
            ])

            ->add('serie', null, [
                'required' => false,
                'label' => 'Serie :',
                'attr' => array('class' => 'form-control')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hardware::class,
        ]);
    }
}
